<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

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
                                <span class="text-sm text-gray-400">{{thread.metadata.views}}</span>
                                <span class="text-sm text-gray-400">{{thread.metadata.likes}}</span>
                                <span class="text-sm text-gray-400">{{thread.metadata.dislikes}}</span>
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
