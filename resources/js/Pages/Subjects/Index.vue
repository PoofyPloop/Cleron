
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

        <div class="mx-96">
            <div class="bg-white rounded-lg p-5 mt-10 mb-5 flex justify-center border">
                <button class="mx-10 text-lg">Math</button> 
                <!-- i want to turn this html into 2 dropdown menus subjects and categories, subjects will have hold what subject it is  -->
                <button class="mx-10 text-lg">Science</button>
                <button class="mx-10 text-lg">Geometry</button>
            </div>
            <div class="bg-white rounded-lg p-5 my-5 flex justify-center border"> 
                <button class="mx-10 text-lg">Categories</button>
            </div>
            <div class="flex flex-wrap gap-2 w-full">
                <div class="border py-5 pl-5 bg-white rounded-xl" v-for="subject in subjects" :key="subject.id">
                    <p>{{ subject?.title }}</p>
                    <p>{{ category?.title }}</p>
                    <div class="" v-for="quiz in subject.quizzes" :key="quiz.id">
                        
                        <div class="col-span-2">
                            <p>{{ quiz?.title }}</p>
                            <p class="inline-flex items-center rounded-md bg-blue-100 px-1 py-0.5 text-xs font-small text-blue-800 ring-1 ring-inset ring-blue-800">{{ quiz.category?.title }} s</p>
                            <p class="pt-2 text-sm text-gray-400">{{ quiz.user?.name }} s</p>
                        </div>
    
                        <div class="flex items-center justify-center"> 
                            <div class="flex justify-center items-center" v-if="$page.props.auth.user.role == 1">
                                <Link :href="route('quizzes.show', {subject: subject.slug, quiz: quiz.slug})" class="primary-button">Take Quiz</Link>
                            </div>
                                
                            <div v-else>
                                <Link :href="route('quizzes.edit', {subject: subject.slug, quiz: quiz.slug})" class="primary-button">View</Link>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
