<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
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
        preserveState: true,
        preserveScroll: true,
        only: ['quiz'],
    });
};


const confirmQuestionDeletion = () => {
    confirmingQuestionDeletion.value = true;
};

const deleteQuestion = (id) => {
    form.delete(route('question.destroy', id), {
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

                        <div class="mt-4">
                            <p class="pb-2">Questions</p>
                            <div class="bg-gray-200 rounded-md p-3 flex items-center justify-between mt-4" v-for="question in $page.props.quiz.questions" :key="question.id">
                                <p required>{{ question.text }}</p>

                                <DangerButton @click="confirmQuestionDeletion">Delete Question</DangerButton>

                                <Modal :show="confirmingQuestionDeletion" @close="closeModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Are you sure you want to delete this question?
                                        </h2>

                                        <div class="mt-6 flex justify-end">
                                            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                                            <DangerButton
                                                class="ml-3"
                                                :class="{ 'opacity-25': form2.processing }"
                                                :disabled="form2.processing"
                                                @click="deleteQuestion(question.id)"
                                            >
                                                Delete Question
                                            </DangerButton>
                                        </div>
                                    </div>
                                </Modal>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6" v-for="question in questions" :key="question">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center justify-between">
                                <h2 class="title-h2">Add Question</h2>
                            </div>
                            <QuestionCard :question="question"></QuestionCard>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button class="primary-button" type="button" @click="addQuestion">Add Question</button>
                    </div>

                    <div>
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <div class="rounded-md bg-green-50 p-4" v-if="form.recentlySuccessful">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">Saved</p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                                <span class="sr-only">Dismiss</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
