<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subjects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12" v-for="sub in $page.props.subjects" :key="sub.id">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <p class="pb-6">{{ sub.title }}</p>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="quizzes flex justify-between border rounded border-gray-200 p-3 mb-6" v-for="quiz in sub.quizzes" :key="quiz.id">
                                        <div>
                                            <p>{{ quiz.title }}</p>
                                            <p class="inline-flex items-center rounded-md bg-blue-100 px-1 py-0.5 text-xs font-small text-blue-800 ring-1 ring-inset ring-blue-800">{{ quiz.category.title }}</p>
                                            <p class="pt-2 text-sm text-gray-400">{{ quiz.user.name }}</p>
                                        </div>
                                        
                                        <div class="flex items-center" v-if="$page.props.auth.user.role == 1">
                                            <Link :href="`/quiz/test/${quiz.id}`" class="primary-button mr-5">Take Quiz</Link>
                                        </div>
                                        
                                        <div class="flex items-center" v-else>
                                            <Link :href="route('quizzes.show', {quiz: quiz.id})" class="primary-button mr-5">View</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
