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

const editCommentForm = useForm({
    body: '',
});

const editingComment = ref(null); // Use this to track which comment is being edited
const confirmingCommentDeletion = ref(false);
const commentToDelete = ref(null);

const newCommentForm = useForm({
    body: '', // make sure this matches your backend expectation
});

// Store new comment
const storeComment = () => {
    const threadSlug = props.thread.slug; // Use slug instead of title
    if (!threadSlug) {
        console.error("Thread slug is undefined");
        return;
    }

    newCommentForm.post(route('threads.comments.store', { 
        thread: encodeURIComponent(threadSlug)
    }), {
        preserveScroll: true,
        onSuccess: () => {
            newCommentForm.reset();
        },
        onError: () => {
            if (newCommentForm.errors.body) {
                contentInput.value.focus();
            }
        },
    });
};

// Start editing a comment
const editCommentData = (comment) => {
    editingComment.value = comment;
    editCommentForm.body = comment.body;
};

// Cancel editing
const cancelEditComment = () => {
    editingComment.value = null;
    editCommentForm.reset();
};

// Update comment
const updateComment = () => {
    if (!editingComment.value) {
        return;
    }

    editCommentForm.put(route('threads.comments.update', {
        thread: props.thread.slug,
        comment: editingComment.value.id,
    }), {
        preserveScroll: true,
        onSuccess: () => {
            editingComment.value = null;
            editCommentForm.reset();
        },
        onError: () => {
            if (editCommentForm.errors.body) {
                contentInput.value.focus();
            }
        },
    });
};

const confirmCommentDeletion = (id) => {
    commentToDelete.value = id;
    confirmingCommentDeletion.value = true;
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
                                    v-model="newCommentForm.body"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="newCommentForm.errors.body" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="newCommentForm.processing">Comment</PrimaryButton>
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="newCommentForm.recentlySuccessful" class="text-sm text-gray-600">
                                        Comment Posted.
                                    </p>
                                </Transition>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4" 
                            v-for="comment in thread.comments" 
                            :key="comment.id">
                        <div v-if="editingComment?.id !== comment.id">
                            <p class="text-sm text-gray-400 pb-2">
                                {{ comment.user.name }} | {{ new Date(comment.created_at).toDateString() }}
                            </p>
                            <p>{{ comment.body }}</p>
                            
                            <div class="flex pt-4 justify-end space-x-4 text-sm" 
                                v-if="$page.props.auth.user.id === comment.user.id">
                                <a href="#" class="text-slate-500" @click.prevent="editCommentData(comment)">Edit</a>
                                <a href="#" class="text-red-500" @click.prevent="confirmCommentDeletion(comment.id)">Delete</a>
                            </div>
                        </div>

                         <form v-else @submit.prevent="updateComment" class="space-y-6">
                            <div>
                                <InputLabel for="content" value="Comment" />
                                <TextareaInput
                                    id="content"
                                    ref="contentInput"
                                    v-model="editCommentForm.body"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="editCommentForm.errors.body" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="editCommentForm.processing">Update</PrimaryButton>
                                <a href="#" @click.prevent="cancelEditComment" class="text-sm text-gray-400">Cancel</a>
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="editCommentForm.recentlySuccessful" class="text-sm text-gray-600">
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
