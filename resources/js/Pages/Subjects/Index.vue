
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps(['subjects', 'categories']);

// State for filters
const selectedSubject = ref('all');
const selectedCategory = ref('all');

// Computed property to filter quizzes based on selected subject and category
const filteredQuizzes = computed(() => {
    return props.subjects.map(subject => {
        const quizzes = subject.quizzes.filter(quiz => {
            // Filter by selected category if it's not 'all'
            if (selectedCategory.value !== 'all' && quiz.category.title !== selectedCategory.value) {
                console.log("category: ", category);
                console.log("category title: ", quiz.category.title);
                return false;
            }
            return true; // Include all quizzes if 'all' is selected
        });

        console.log(props.subjects);
        console.log(quizzes);
        console.log("subject: ", subject.title);
        // console.log("category: ", category);
        return {
            ...subject,
            quizzes: quizzes
        };
    }).filter(subject => subject.quizzes.length > 0); // Remove subjects with no quizzes
});

// Function to reset the category filter
const resetCategoryFilter = () => {
    selectedCategory.value = 'all';
};

const getSubjectColor = (subjectId) => {
    switch (subjectId) {
        case 1: // Math
            return 'bg-blue-100 text-blue-700 ring-blue-700';
        case 2: // Science
            return 'bg-green-100 text-green-700 ring-green-700';
        case 3: // Geography
            return 'bg-yellow-100 text-yellow-700 ring-yellow-700';
        default: // Default color for other subjects
            return 'bg-gray-100 text-gray-600 ring-gray-600';
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subjects</h2>
        </template>

        <div class="mx-96">
            <div class="bg-white rounded-lg p-5 mt-10 mb-5 flex justify-center border">
                <select v-model="selectedSubject" @change="resetCategoryFilter">
                    <option value="all">All</option>
                    <option value="math">Math</option>
                    <option value="science">Science</option>
                    <option value="geography">Geography</option>
                </select>

                <select v-model="selectedCategory" :disabled="selectedSubject === 'all'">
                    <option value="all">All Categories</option>
                    
                    <option v-for="category in categories" :key="category.id" :value="category.title">
                        {{ category.title }}
                    </option>
                </select>
            </div>

            <div class="flex flex-wrap gap-2 w-full">
                <div class="border py-5 pl-5 bg-white rounded-xl" v-for="subject in filteredQuizzes" :key="subject.id">
                    <p>{{ subject?.title }}</p>
                    <p>{{ category?.title }}</p>
                    <div class="" v-for="quiz in subject.quizzes" :key="quiz.id">
                        <div class="col-span-2">
                            <p>{{ quiz?.title }}</p>
                            <p :class="getSubjectColor(subject.id)" class="inline-flex items-center rounded-md px-1 py-0.5 text-xs font-small ring-1 ring-inset mr-2 font-semibold">{{ subject.title }}</p>
                            <p class="inline-flex items-center rounded-md bg-slate-200 px-1 py-0.5 text-xs font-small text-slate-700 ring-1 ring-inset ring-slate-700 font-semibold">{{ quiz.category?.title }}</p>
                            <p class="pt-2 text-sm text-gray-400">{{ quiz.user?.name }}</p>
                        </div>
    
                        <div class="flex items-center justify-center"> 
                            <div class="flex justify-center items-center" v-if="$page.props.auth.user.role == 1">
                                <Link :href="route('subjects.quizzes.show', {subject: subject.slug, quiz: quiz.slug})" class="primary-button">Take Quiz</Link>
                            </div>
                                
                            <div v-else>
                                <Link :href="route('subjects.quizzes.edit', {subject: subject.slug, quiz: quiz.slug})" class="primary-button">View</Link>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
