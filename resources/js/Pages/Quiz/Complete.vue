<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  quiz: {
    type: Object,
    required: true
  },
    questions: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-col items-center justify-center bg-white rounded-l p-5 mt-6 mx-96">
            <h1 class="text-3xl font-bold text-gray-800">Quiz Completed</h1>
            <h2 class="mt-2 text-xl font-bold text-gray-800">{{ quiz.title }}</h2>
            <p>Score: {{ quiz.score }} / {{ quiz.questions.length }}</p>
            <p class="text-gray-600">You have completed the quiz</p>
            <div class="mt-4">
              <Link class="primary-button" :href="route('dashboard')">Go Home</Link>
            </div>
          </div>
    </AuthenticatedLayout>
</template>