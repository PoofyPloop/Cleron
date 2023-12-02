<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { toRef, watch } from "vue";

const props = defineProps(["question"]); // Defines the props to access external properties

const question = toRef(props.question);

const form = useForm({
    ...question.value,
});

/**
 * Saves question
 */
const saveQuestion = () => {
    form.post(
        route("subjects.quizzes.questions.update", {
            subject: route().params.subject,
            quiz: route().params.quiz,
            question: props.question.id,
        }),
        {
            preserveState: true,
            preserveScroll: true,
            only: ["quiz"],
        }
    );
};

/**
 * Adds a new option block for the multiple choice
 */
const addOption = () => {
    if (form.options.length >= 4) return;
    form.options.push({
        key: (Math.random() + 1).toString(36).substring(7),
        label: "",
        value: "",
    });
};

/**
 * Deletes question of choice.
 * @returns {void}
 */
const deleteQuestion = () => {
    form.delete(
        route("subjects.quizzes.questions.destroy", {
            subject: route().params.subject,
            quiz: route().params.quiz,
            question: props.question.id,
        }),
        {
            preserveScroll: true,
            only: ["quiz"],
        }
    );
};

watch(props.question, (newValue) => {
    question.value = newValue;
});
</script>

<template>
    <div class="space-y-4">
        <div>

            <InputLabel for="question" value="Question" />

            <textarea
                id="question"
                v-model="form.label"
                class="focus:border-blue-500 focus:ring-blue-500"
            ></textarea>
            
            <InputError :message="form.errors.category" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <p>Answer Type</p>

            <label :for="`question-${question.id}-type-1`">
                <input
                    :name="`question-${question.id}-type-1`"
                    :id="`question-${question.id}-type-1`"
                    type="radio"
                    v-model="form.type"
                    value="text"
                />
                Textbox
            </label>

            <label :for="`question-${question.id}-type-2`">
                <input
                    :name="`question-${question.id}-type-2`"
                    :id="`question-${question.id}-type-2`"
                    type="radio"
                    v-model="form.type"
                    value="radio"
                />
                Multiple Choice
            </label>

            <label :for="`question-${question.id}-type-3`">
                <input
                    :name="`question-${question.id}-type-3`"
                    :id="`question-${question.id}-type-3`"
                    type="radio"
                    v-model="form.type"
                    value="textarea"
                />
                Text Area
            </label>

            <div class="flex items-center space-x-2">
                <p>Points</p>
                <input
                    type="number"
                    ref="scoreInput"
                    class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full mt-1"
                    v-model="form.points"
                    min="1"
                />
            </div>
        </div>

        <div v-if="form.type == 'radio'">
            <div class="grid grid-cols-2 gap-4">
                <div
                    v-if="form.options.length"
                    class="col-span-2 flex justify-start items-center"
                >
                    <div>
                        <PrimaryButton @click="addOption"
                            >Add option</PrimaryButton
                        >
                    </div>
                    <div>
                        <PrimaryButton
                            class="mx-2"
                            @click="removeOption(form.options.length - 1)"
                            >Remove option</PrimaryButton
                        >
                    </div>
                </div>
                <template v-if="form.options.length">
                    <div v-for="option in form.options" :key="option.key">
                        <InputLabel
                            :for="`option-${option.key}`"
                            value="Option"
                        />

                        <TextInput
                            :id="`option-${option.key}`"
                            v-model="option.label"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Label"
                            required
                        />
                        <TextInput
                            :id="`option-${option.key}`"
                            v-model="option.value"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Value"
                            required
                        />

                        <InputError :message="form.errors.label" class="mt-2" />
                    </div>
                </template>
                <div v-else class="text-center w-full col-span-2">
                    <h2 class="text-base font-semibold leading-6 text-gray-900">
                        Options
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        No options Added. Please click add option to get started.
                        <br>Notice: You can't have less than 2 and more than 4 options.
                    </p>
                    <div class="mt-6">
                        <PrimaryButton @click="addOption"
                            >Add option</PrimaryButton
                        >
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <InputLabel for="answer" value="Answer" />

                <TextInput
                    id="option"
                    v-model="form.value"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />

                <InputError :message="form.errors.category" class="mt-2" />
            </div>
        </div>

        <div v-else-if="form.type == 'textarea'">
            <InputLabel for="answer" value="Answer" />
            
            <textarea id="option" class="mt-1 block w-full" required/>

            <InputError :message="form.errors.category" class="mt-2" />
        </div>
        <div v-else>
            <InputLabel for="answer" value="Answer" />

            <TextInput
                id="option"
                ref="optionInput"
                v-model="form.value"
                type="text"
                class="mt-1 block w-full"
                required
            />

            <InputError :message="form.errors.category" class="mt-2" />
        </div>

        <PrimaryButton :disabled="form.processing" @click="saveQuestion"
            >Save</PrimaryButton
        >
        <DangerButton class="ml-2" @click="deleteQuestion">Delete</DangerButton>
    </div>
</template>
