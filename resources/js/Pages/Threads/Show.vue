<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    thread: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    body: '', 
});

const comments = computed(() => props.thread.comments || []);
const editComment = ref(null);
const confirmingCommentDeletion = ref(false);
const commentToDelete = ref(null);

const confirmCommentDeletion = (id) => {
    commentToDelete.value = id;
    confirmingCommentDeletion.value = true;
};
const storeComment = () => {
    const discussionTitle = usePage().props.thread.title;
    if (!discussionTitle) {
        console.error("Discussion title is undefined");
        return;
    }

    form.post(route('threads.comments.store', { thread: discussionTitle }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            if (form.errors.body) {
                contentInput.value.focus();
            }
        },
    });
};

// const editCommentData = (comment) => {
//     console.log(comment);  

//     editComment.value = comment;
//     form.body = comment.body || '';  
// };

const editCommentData = (comment) => {
    console.log('Editing comment:', comment);
    editComment.value = { ...comment };  // Create a copy of the comment
    form.body = comment.body || '';
};

const cancelEditComment = () => {
    editComment.value = null;
    form.body = ''; 
};

const updateComment = () => {
    console.log('Updating comment, editComment.value:', editComment.value);
    if (!editComment.value || !editComment.value.id) {
        console.error('Comment data is missing', editComment.value);
        return;
    }

    form.put(route('threads.comments.update', {
        thread: props.thread.slug,
        comment: editComment.value.id,  // Use id instead of slug
    }), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Comment updated successfully');  
            editComment.value = null;
            form.reset();
        },
        onError: () => {
            console.error('Error updating comment');
            if (form.errors.body) {
                contentInput.value.focus();
            }
        },
    });
};


const deleteComment = (id) => {
    const threadSlug = usePage().props.thread.slug; 
    if (!threadSlug) {
        console.error("Thread slug is missing");
        return;
    }

    form.delete(route('threads.comments.destroy', {
        thread: threadSlug,  
        comment: id  
    }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            console.error("Error deleting comment");
        },
        onFinish: () => form.reset(),
    });
};


const closeModal = () => {
    confirmingCommentDeletion.value = false;
    form.reset();
};
</script>

<template>
    <Head :title="`Thread - ${thread.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Thread</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="pb-4">
                            <h1 class="text-2xl font-semibold">{{ thread.title }}</h1>
                            <p class="text-sm text-gray-400">
                                Published by {{ thread.user.name }}
                            </p>
                        </div>

                        <div class="disc-content" v-html="thread.description"></div>
                    </div>
                </div>

                <div class="pt-6">
                    <h2 class="text-xl font-semibold pb-2">
                        Comments
                    </h2>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <form @submit.prevent="storeComment" class="space-y-6">
                            <div>
                                <InputLabel for="content" value="Comment" />

                                <TextareaInput
                                    id="content"
                                    ref="contentInput"
                                    v-model="form.body"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.body" class="mt-2" /> 
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Comment</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                        Comment Posted.
                                    </p>
                                </Transition>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4" v-for="comment in thread.comments" :key="comment.id">
                        <div v-if="!editComment || editComment.id !== comment.id">
                            <p class="text-sm text-gray-400 pb-2">
                                {{ comment.user.name }} | {{ new Date(comment.created_at).toDateString() }}
                            </p>
                            <p>{{ comment.body }}</p>
                            <p>Slug: {{ comment.slug }}</p>
                            <p>id: {{ comment.id }}</p>
                        </div>

                        <div class="flex pt-4 justify-end space-x-4 text-sm" v-if="!editComment || (editComment && editComment.id !== comment.id)">
                            <a href="#" class="text-slate-500" @click.prevent="editCommentData(comment)">Edit</a>
                            <a href="#" class="text-red-500" @click.prevent="confirmCommentDeletion(comment.id)">Delete</a>
                        </div>

                        <form v-if="editComment && editComment.id === comment.id" @submit.prevent="updateComment" class="space-y-6">
                            <div>
                                <InputLabel for="content" value="Comment" />

                                <TextareaInput
                                    id="content"
                                    ref="contentInput"
                                    v-model="form.body"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.body" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                                <a href="#" @click.prevent="cancelEditComment" class="text-sm text-gray-400">Cancel</a>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                        Comment Updated.
                                    </p>
                                </Transition>
                            </div>
                        </form>

                        <!-- Modal for deletion confirmation -->
                        <Modal :show="confirmingCommentDeletion" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Are you sure you want to delete the comment?
                                </h2>

                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                                    <DangerButton
                                        class="ml-3"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        @click="deleteComment(commentToDelete)"
                                    >
                                        Delete Comment
                                    </DangerButton>
                                </div>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
