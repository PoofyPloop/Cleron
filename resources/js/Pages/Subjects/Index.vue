<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps(['subjects']);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subjects</h2>
        </template>

        <div class="my-5 mx-96">
            <div class="bg-white rounded-lg p-5 mt-10 mb-5 flex justify-center border">
                <button class="mx-10 text-lg">Math</button>
                <button class="mx-10 text-lg">Science</button>
                <button class="mx-10 text-lg">Geometry</button>
            </div>
            <div class="bg-white rounded-lg p-5 my-5 flex justify-center border"> 
                <button class="mx-10 text-lg">Categories</button>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="border py-5 pl-5 bg-white rounded-xl" v-for="subject in subjects" :key="subject.id">
                    <p>{{ subject?.title }}</p>
                    <div class="grid grid-cols-3" v-for="quiz in subject.quizzes" :key="quiz.id">
                        
                        <div class="col-span-2">
                            <p>{{ quiz?.title }}</p>
                            <p class="inline-flex items-center rounded-md bg-blue-100 px-1 py-0.5 text-xs font-small text-blue-800 ring-1 ring-inset ring-blue-800">{{ quiz.category?.title }} s</p>
                            <p class="pt-2 text-sm text-gray-400">{{ quiz.user?.name }} s</p>
                        </div>
    
                        <div class="flex items-center justify-center"> 
                            <div class="flex justify-center items-center" v-if="$page.props.auth.user.role == 1">
                                <Link :href="route('subjects.quizzes.show', {subject: subject.id, quiz: quiz.id})" class="primary-button">Take Quiz</Link>
                            </div>
                                
                            <div v-else>
                                <Link :href="route('subjects.quizzes.edit', {subject: subject.id, quiz: quiz.id})" class="primary-button">View</Link>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
