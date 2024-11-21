<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
  quiz: {
    type: Object,
    required: true,
  },
  subject: {
    type: Object,
    required: true,
  },
  questions: {
    type: Array,
    required: true,
  },
});

function reportIssue() {
  alert('Thank you for reporting an issue!');
}
</script>

<template>
    <Head title="Quiz Result" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quiz Results</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-800">Quiz Completed</h1>
                        <h2 class="mt-2 text-xl font-bold text-gray-800">{{ quiz.title }}</h2>
                        <p class="text-gray-800">Score: {{ quiz.score }} / {{ questions.length }}</p>
                        <p class="text-gray-600">You have completed the quiz</p>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Question Review:</h3>
                        <ul>
                            <li v-for="(question, index) in questions" :key="index" class="py-4 border-b border-gray-200">
                                <p class="font-semibold text-gray-700">{{ question.label }}</p>
                                
                                <p class="mt-1"
                                   :class="{'text-green-600 font-bold': question.userAnswer === question.value, 'text-red-600 font-bold': question.userAnswer !== question.value}">
                                    Your Answer: {{ question.userAnswer }}
                                    <span v-if="question.userAnswer === question.value">✓ Correct</span>
                                    <span v-else>✗ Incorrect</span>
                                </p>

                                <p v-if="question.userAnswer !== question.value" class="text-gray-600 mt-1">
                                    Correct Answer: <span class="text-green-600 font-semibold">{{ question.value }}</span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="flex justify-between mt-6">
                        <DangerButton @click="reportIssue">Report Issue</DangerButton>
                        <Link class="primary-button" :href="route('dashboard')">Go Home</Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
