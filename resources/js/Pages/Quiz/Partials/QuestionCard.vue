<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {useForm, usePage} from '@inertiajs/vue3';

    const props = defineProps(['question']); // Defines the props to access external properties
    const form = useForm(props.question); // Initializes form with question data

    /**
     * Saves question
     */
    const saveQuestion = () => {
    form.post(route('quizzes.questions.store', { quiz: usePage().props.quiz.id }), {
        preserveState: true,
        preserveScroll: true,
        only: ['quiz'],
    });
};

    /**
     * Deletes question of choice.
     * @returns {void}
     */
    const deleteQuestion = () => {
        form.delete(route('quizzes.questions.destroy',  {quiz: usePage().props.quiz.id, question: props.question.id}), {
            preserveState: true,
            preserveScroll: true,
            only: ['quiz'],
        });
    };
    
</script>

<template>
    <div class="space-y-4">
        <div>
            <InputLabel for="question" value="Question" />

            <textarea ref="questionInput" id="question" v-model="form.label"></textarea>

            <InputError :message="form.errors.category" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <p>Answer Type</p>

            <label>
                <input type="radio" ref="typeInput" v-model="form.type" value="textbox">
                Textbox
            </label>

            <label>
                <input type="radio" ref="typeInput" v-model="form.type" value="radio">
                Multiple Choice
            </label>

            <div class="flex items-center space-x-2">
                <p>Points</p>
                <input type="number" ref="scoreInput" class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm w-full mt-1" v-model="form.points" min="1">
            </div>
        </div>

        <div v-if="form.type == 'radio'">
            <div class="grid grid-cols-12 gap-6">
                <div v-for="option in form.options" class="col-span-12 md:col-span-6">
                    <InputLabel for="option1" value="Option 1" />

                    <TextInput
                        id="option1"
                        ref="option1Input"
                        v-model="option.label"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                    <TextInput
                        id="option1"
                        ref="option1Input"
                        v-model="option.value"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />

                    <InputError :message="form.errors.label" class="mt-2" />
                </div>
            </div>
        </div>

        <div>
            <InputLabel for="answer" value="Answer" />
            
            <TextInput
                id="option1"
                ref="option1Input"
                v-model="form.value"
                type="text"
                class="mt-1 block w-full"
                required
            />

            <InputError :message="form.errors.category" class="mt-2" />
        </div>
        
        <div>
            <InputLabel for="answer" value="Answer"/>
            
            <div class="grid grid-cols-2 gap-4"> 
                <input class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                <input class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                <input class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                <input class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
            </div>
            
            <InputError :message="form.errors.category" class="mt-2" />
        </div>
        
        <PrimaryButton :disabled="form.processing" @click="saveQuestion">Save</PrimaryButton>
        <DangerButton class="ml-2" @click="deleteQuestion">Delete</DangerButton>
    </div>
</template>