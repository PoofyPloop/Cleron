<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps(['subjects', 'categories']);

const selectedSubject = ref('all');
const selectedCategory = ref('all');

console.log('prosp:', props);
console.log('prosp category:', props.category);

const filteredQuizzes = computed(() => {
    return props.subjects.map(subject => {
        const quizzes = subject.quizzes.filter(quiz => {
            
            if (selectedCategory.value !== 'all' && quiz.category.title !== selectedCategory.value) {
                return false;
            }
            if (quiz.category) {
                quiz.category.subject_id = quiz.subject_id;
            }

            return true; 
        });

        return {
            ...subject,
            quizzes: quizzes
        };
    }).filter(subject => subject.quizzes.length > 0); 
});

const resetCategoryFilter = () => {
    selectedCategory.value = 'all';
};

console.log('Categories:', props.categories);

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
                <select v-model="selectedSubject" @change="resetCategoryFilter" class="mr-2">
                    <option value="all">All</option>
                    <option value="Math">Math</option>
                    <option value="Science">Science</option>
                    <option value="Geography">Geography</option>
                </select>

                <select v-model="selectedCategory" :disabled="selectedSubject === 'all'">
                    <option value="all">All Categories</option>

                    <option v-if="selectedSubject === 'Math'" value="Arithmetic">Arithmetic</option>
                    <option v-if="selectedSubject === 'Math'" value="Algebra">Algebra</option>
                    <option v-if="selectedSubject === 'Math'" value="Statistics">Statistics</option>
                    <option v-if="selectedSubject === 'Math'" value="Trigonometry">Trigonometry</option>
                    <option v-if="selectedSubject === 'Math'" value="Geometry">Geometry</option>
                    <option v-if="selectedSubject === 'Math'" value="Calculus">Calculus</option>

                    <option v-if="selectedSubject === 'Science'" value="Physics">Physics</option>
                    <option v-if="selectedSubject === 'Science'" value="Chemistry">Chemistry</option>
                    <option v-if="selectedSubject === 'Science'" value="Biology">Biology</option>
                    <option v-if="selectedSubject === 'Science'" value="Earth Science">Earth Science</option>
                    <option v-if="selectedSubject === 'Science'" value="Astronomy">Astronomy</option>

                    <option v-if="selectedSubject === 'Geography'" value="Regional Geography">Regional Geography</option>
                    <option v-if="selectedSubject === 'Geography'" value="Geopolitics">Geopolitics</option>
                    <option v-if="selectedSubject === 'Geography'" value="Cartography">Cartography</option>
                    <option v-if="selectedSubject === 'Geography'" value="Climatology">Climatology</option>
                    <option v-if="selectedSubject === 'Geography'" value="Meteorology">Meteorology</option>
                </select>
            </div>
            
            <div class="grid grid-cols-3 gap-6">
                <template v-for="subject in subjects" :key="subject.id">
                    <template v-if="selectedSubject === 'all' || subject.title === selectedSubject">
                        <template v-for="quiz in subject.quizzes" :key="quiz.id">
                            <div v-if="selectedCategory === 'all' || quiz.category.title === selectedCategory" 
                                class="border p-4 bg-white rounded-xl shadow-sm h-[200px] w-full flex flex-col">
                                <div class="h-[50px]">
                                    <p class="font-semibold">{{ quiz.title }}</p>
                                </div>

                                <div class="mt-auto">
                                    <p :class="getSubjectColor(subject.id)" 
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset mr-2">
                                        {{ subject.title }}
                                    </p>
                                    <p class="inline-flex items-center rounded-md bg-slate-200 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-700">
                                        {{ quiz.category.title }}
                                    </p>
                                </div>

                                <div class="mt-auto">
                                    <p class="text-sm text-gray-400">{{ quiz.user?.name }}</p>
                                    
                                    <div class="mt-2">
                                        <div v-if="$page.props.auth.user.role == 1">
                                            <Link :href="route('subjects.quizzes.show', {subject: subject.slug, quiz: quiz.slug})" 
                                                class="primary-button">Take Quiz</Link>
                                        </div>
                                        <div v-else>
                                            <Link :href="route('subjects.quizzes.edit', {subject: subject.slug, quiz: quiz.slug})" 
                                                class="primary-button">View</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>