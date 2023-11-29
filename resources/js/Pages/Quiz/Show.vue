<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import QuestionCard from './Partials/QuestionCard.vue';

const confirmingQuestionDeletion = ref(false);

const form = useForm({
    label: "New Question",
    value: "",
    type: "text",
    options: [],
    points: 1,
});

const questions = ref(usePage().props.quiz.questions,);

const addQuestion = () => {
    form.post(route('quizzes.questions.store', {quiz: usePage().props.quiz.id,}), {
        preserveScroll: true,
        only: ['quiz'],
    });
};


const confirmQuestionDeletion = () => {
    confirmingQuestionDeletion.value = true;
};

const deleteQuestion = (id) => {
    form.delete(route('quizzes.questions.destroy', id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {},
    });
};

const closeModal = () => {
    confirmingQuestionDeletion.value = false;
    form.reset();
};
</script>

<template>
    <Head title="Show Quiz" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Question - Show</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between">
                            <div class="pt-4" v-if="$page.props.quiz">
                                <h2 class="title-h2">{{ $page.props.quiz.title }}</h2>
                            </div>
                        </div>

                        
                    </div>
                </div>

                <div class="mt-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="title-h2 pl-6">Add Questions</h2>
                    </div>
                    <div class="mt-2">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6" v-for="question in questions" :key="question">
                            <div class="p-6 text-gray-900">
                                <QuestionCard :question="question"></QuestionCard>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <button class="primary-button mt-4" type="button" @click="addQuestion">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
