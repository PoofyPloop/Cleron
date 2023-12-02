<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const form = useForm({
    title: '',
    description: '',
    image: '',
});

const onSubmit = () => {
    form.post(route('threads.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
    });
};
</script>

<template>
    <Head title="Create Discussion" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Discussion - Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between">
                            <h2 class="title-h2">Create Discussion</h2>
                            <Link :href="route('threads.index')" class="text-sm text-primary-500">Back to threads</Link>
                        </div>

                        <div>
                            <form @submit.prevent="onSubmit" class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="title" value="Thread Title" />

                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError :message="form.errors.title" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="description" value="description" />

                                    <TextareaInput
                                        id="description"
                                        v-model="form.description"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError :message="form.errors.description" class="mt-2" />
                                </div>
                                
                                <div>
                                    <InputLabel for="image" value="Image Url (optional)" />

                                    <TextInput
                                        id="image"
                                        v-model="form.image"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError :message="form.errors.image" class="mt-2" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <PrimaryButton :disabled="form.processing">Post</PrimaryButton>

                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
