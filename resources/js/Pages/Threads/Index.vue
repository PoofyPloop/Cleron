
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    threads: {
        type: Object,
        required: true,
    }
})
</script>

<template>
    <Head title="Threads" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Threads</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <p class="text-2xl font-semibold text-gray-600 pb-2">Threads</p>
                <Link
                    :href="route('threads.create')"
                    class="primary-button mb-4"
                >
                    Add New
                </Link>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4" v-for="thread in threads.data" :key="thread.id">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-semibold pb-4">{{ thread.title }}</h2>
                        <p>{{ thread.description }}...</p>

                        <div class="flex items-center justify-between space-x-4 mt-4">
                            <Link
                                :href="route('threads.show', {thread: thread.slug})"
                                class="primary-button"
                            >
                                Read More
                            </Link>
                            <div class="flex gap-2 items-center">
                                <!-- 1. fonts.google.com/icons      2. iconmonstr.com       3. https://heroicons.com/ -->
                                <!-- <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m11.998 5c-4.078 0-7.742 3.093-9.853 6.483-.096.159-.145.338-.145.517s.048.358.144.517c2.112 3.39 5.776 6.483 9.854 6.483 4.143 0 7.796-3.09 9.864-6.493.092-.156.138-.332.138-.507s-.046-.351-.138-.507c-2.068-3.403-5.721-6.493-9.864-6.493zm8.413 7c-1.837 2.878-4.897 5.5-8.413 5.5-3.465 0-6.532-2.632-8.404-5.5 1.871-2.868 4.939-5.5 8.404-5.5 3.518 0 6.579 2.624 8.413 5.5zm-8.411-4c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4zm0 1.5c-1.38 0-2.5 1.12-2.5 2.5s1.12 2.5 2.5 2.5 2.5-1.12 2.5-2.5-1.12-2.5-2.5-2.5z" fill-rule="nonzero"/></svg>
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg> -->
                                <span class="text-sm text-gray-400">{{thread.metadata.views}}</span>
                                <span class="text-sm text-green-600">{{thread.metadata.likes}}</span>
                                <span class="text-sm text-red-500">{{thread.metadata.dislikes}}</span>
                            </div>
                            <!-- <p class="text-sm text-gray-400">Comments Posted: {{ thread.comments.length }}</p> -->
                        </div>
                    </div>
                </div>

                <div class="flex gap-1 w-full">
                    <Link v-for="link in threads.links" :href="link.url" v-html="link.label" :key="link.url" :class="{'bg-gray-300 px-2': link.active}"></Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
