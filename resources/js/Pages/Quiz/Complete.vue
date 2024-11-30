<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from '@/Components/Modal.vue';

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

const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const reportForm = useForm({
  quiz_id: props.quiz.id,
  description: '',
});

function submitReport() {
  if (reportForm.description.trim().length < 10) {
    alert("Please provide a description of at least 10 characters.");
    return;
  }
  console.log('Submitting report 1:', reportForm.description);
  reportForm.post(route('subjects.quizzes.reports.store', { 
    subject: props.subject.slug, 
    quiz: props.quiz.slug 
  }), {
    onSuccess: () => {
      alert('Report submitted successfully!');
      console.log('Submitting report 2:', reportForm.description);
      showModal.value = false;
      reportForm.reset();
    },
    onError: () => {
      alert('An error occurred. Please try again.');
    },
  });
}

const questions = ref(props.questions.map(question => ({
  ...question,
  user_answer: question.answer?.value || '', 
  value: String(question.value || '').trim().toLowerCase(),
})));

const score = computed(() => {
  return questions.value.filter((question) => {
    const userAnswer = String(question.user_answer || '').trim().toLowerCase();
    const correctAnswer = String(question.value || '').trim().toLowerCase();
    console.log(`Question ${question.id}:`, {
      userAnswer,
      correctAnswer,
      isCorrect: userAnswer === correctAnswer
    });
    return userAnswer === correctAnswer;
  }).length;
});
</script>

<template>
  <Head title="Quiz Result" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800">Quiz Completed</h1>
            <h2 class="mt-2 text-xl font-bold text-gray-800">{{ quiz.title }}</h2>
            <p class="text-gray-800">Score: {{ score }} / {{ questions.length }}</p>
            <p class="text-gray-600">You have completed the quiz</p>
          </div>
          
          <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Question Review:</h3>
            <ul>
              <li v-for="question in questions" 
                  :key="question.id" 
                  class="py-4 border-b border-gray-200">
                <p class="font-semibold text-gray-700">{{ question.label }}</p>
                
                <p v-if="String(question.user_answer || '').trim().toLowerCase() !== 
                        String(question.value || '').trim().toLowerCase()" 
                   class="text-gray-600 mt-1">
                  Correct Answer: <span class="text-green-600 font-semibold">{{ question.value }}</span>
                </p>

                <p class="mt-1"
                   :class="{
                     'text-green-600 font-bold': String(question.user_answer || '').trim().toLowerCase() === 
                                                String(question.value || '').trim().toLowerCase(),
                     'text-red-600 font-bold': String(question.user_answer || '').trim().toLowerCase() !== 
                                              String(question.value || '').trim().toLowerCase()
                   }">
                  Your Answer: {{ question.user_answer || 'No answer provided' }}
                  <span v-if="String(question.user_answer || '').trim().toLowerCase() === 
                            String(question.value || '').trim().toLowerCase()">✓ Correct</span>
                  <span v-else>✗ Incorrect</span>
                </p>
              </li>
            </ul>
          </div>
          <div class="flex justify-between mt-6">
            <DangerButton @click="openModal">Report Issue</DangerButton>
            <Link class="primary-button" :href="route('subjects.quizzes.show', {subject: subject.slug, quiz: quiz.slug})">Retry Quiz</Link>
            <Link class="primary-button" :href="route('dashboard')">Go Home</Link>

            <Modal :show="showModal" @close="closeModal" maxWidth="lg">
              <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold mb-4">Report Issue</h2>
                <textarea v-model="reportForm.description" rows="4" maxlength="250" class="w-full border p-2 mb-4"></textarea>
                <div class="flex justify-end space-x-2">
                  <DangerButton @click="closeModal">Cancel</DangerButton>
                  <PrimaryButton @click="submitReport">Send Report</PrimaryButton>
                </div>
              </div>
            </Modal>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
