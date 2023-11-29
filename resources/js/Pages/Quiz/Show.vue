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

                        <div class="mt-4">
                            <p class="pb-2">Questions</p>
                            <div class="bg-gray-200 rounded-md p-3 flex items-center mt-4" v-for="question in $page.props.quiz.questions" :key="question.id">
                                
                                <div class="grid grid-rows-1 grid-cols-10 flex items-center ">
                                    <p required class="mx-2 col-start col-span-8">Question:: {{ question.text }}</p>
                                    <SecondaryButton class="mx-2 col-end-10">Edit</SecondaryButton>
                                    <DangerButton class="col-end-11 flex justify-center" @click="confirmQuestionDeletion">Delete</DangerButton>
                                </div>

                                <Modal :show="confirmingQuestionDeletion" @close="closeModal">
                                    <div class="p-6">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal" @click="closeModal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                        </button>
                                        <svg class="mx-auto my-4 text-gray-600 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="my-5 text-lg font-normal text-gray-700 flex items-center justify-center">Are you sure you want to delete this question?</h3>

                                        <div class="mt-6 flex justify-end">
                                            <SecondaryButton data-modal-hide="popup-modal" @click="closeModal">Cancel</SecondaryButton>

                                            <DangerButton
                                                class="ml-3"
                                                :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing"
                                                @click="deleteQuestion(questions.id)"
                                            >
                                                Delete
                                            </DangerButton>
                                        </div>
                                    </div>
                                </Modal>
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
