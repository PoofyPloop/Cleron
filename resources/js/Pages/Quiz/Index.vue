<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

const confirmingQuizDeletion = ref(false);

const quizToDelete = ref(null);

const form = useForm({});

const props = defineProps({
    subjects: {
        type: Array,
        default: () => []
    },
});
console.log('Props:', props);
console.log('Subjects:', props.subjects);

const confirmQuizDeletion = (quiz) => {
    quizToDelete.value = quiz;
};

const deleteQuiz = () => {
    if (!quizToDelete.value) return;
    
    const routeUrl = route('quiz.destroy', { 
        subject: quizToDelete.value.subject.slug, 
        quiz: quizToDelete.value.slug 
    });
    
    form.delete(routeUrl, {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {},
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    quizToDelete.value = null;
    form.reset();
};
</script>

<template>
    <Head title="All Quizzes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Quizzes</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white py-6">
                <div>
                    <h3 class="title-h3 text-gray-600 pb-2">All Quizzes</h3>
                    <template v-if="subjects && subjects.length">
                        <div v-for="subject in subjects" :key="subject.id">
                            <Link :href="route('subjects.quizzes.create', {subject: subject.slug})" class="primary-button">Create Quiz</Link>
                        </div>
                    </template>

                    <div class="mt-6 list-style-none">
                        <div v-for="quiz in $page.props.quizzes" :key="quiz.id" class="p-4 bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg mt-3 flex items-center justify-between">
                            <p>{{ quiz.title }}</p>

                            <div class="flex items-center space-x-2">
                                <a :href="`/quiz/${quiz.slug}`" class="primary-button">Questions</a>

                                <a :href="route('subjects.quizzes.edit', { subject: quiz.subject.slug, quiz: quiz.slug })" class="primary-button">Edit Quiz</a>

                                <DangerButton @click="confirmQuizDeletion(quiz)">Delete Quiz</DangerButton>

                                <Modal :show="quizToDelete !== null" @close="closeModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Are you sure you want to delete this quiz?
                                        </h2>

                                        <div class="mt-6 flex justify-end">
                                            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                                            <DangerButton
                                                class="ml-3"
                                                :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing"
                                                @click="deleteQuiz"
                                            >
                                                Delete Quiz
                                            </DangerButton>
                                        </div>
                                    </div>
                                </Modal>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
