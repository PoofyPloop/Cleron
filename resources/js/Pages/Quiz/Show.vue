
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    quiz: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    questions: props.quiz.questions,
});

const submit = () => {
    console.log("Submitted quiz data:", JSON.stringify(form.questions, null, 2));
    form.post(route('subjects.quizzes.submit', {subject: route().params.subject, quiz: props.quiz.slug}));
};

const logUserAnswer = (answer) => {
  console.log("User Answer Updated:", answer);
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 flex flex-col" v-if="$page.props.quiz">
                    <div class="flex justify-between">
                        <h2 class="title-h2">{{ quiz.title }}</h2>
                        <p class="text-sm">Points: {{ quiz.points }}</p>
                    </div>
                    <div>
                        <div class="text-md" v-html="quiz.description"></div>
                    </div>
                </div>


                <div class="mt-6 space-y-6">
                    <div class="mt-2">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                            <div class="p-5" v-for="(question, index) in form.questions" :key="index">
                                <p>{{ question.label }}</p>
                                <template v-if="question.type == 'radio'">
                                    <div v-for="(option, index) in question.options" :key="option" class="flex gap-1 items-center">
                                        <input :id="`option-${index}`" :name="`option-${index}`" v-model="question.user_answer" :value="option.value" :type="question.type"/>
                                        <label :for="`option-${index}`">{{ option.label }}</label>
                                    </div>
                                </template>
                                <template v-else-if="question.type == 'text'">
                                    <input 
                                        class="border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                                        v-model="question.user_answer" 
                                        :type="question.type" 
                                        @input="logUserAnswer(question.user_answer)" 
                                    />
                                </template>
                                <template v-else>
                                    <textarea class="border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" v-model="question.user_answer"></textarea>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <PrimaryButton @click="submit" class="mt-4" type="submit">Submit</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
