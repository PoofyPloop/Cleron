
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import QuestionCard from "./Partials/QuestionCard.vue";

const props = defineProps({
    quiz: Object,
    subjects: Array,
    categories: Array,
});

const form = useForm({
    title: props.quiz.title,
    description: props.quiz.description,
    subject_id: props.quiz.subject_id,
    category_id: props.quiz.category_id,
    questions: props.quiz.questions,
});

const addQuestion = () => {
    router.post(
        route("subjects.quizzes.questions.store", {
            subject: route().params.subject,
            quiz: route().params.quiz,
        }),
        {
            label: "New Question",
            value: null,
            type: "radio",
            options: [
                {
                    label: "Option 1",
                    value: null,
                },
                {
                    label: "Option 2",
                    value: null,
                },
                {
                    label: "Option 3",
                    value: null,
                },
                {
                    label: "Option 4",
                    value: null,
                },
            ],
        },
        {
            only: ["quiz"],
        }
    );
};

watch(
    () => props.quiz,
    (quiz) => {
        form.title = quiz.title;
        form.description = quiz.description;
        form.subject_id = quiz.subject_id;
        form.category_id = quiz.category_id;
        form.questions = quiz.questions;
    }
);

// form.post(
//         route("subjects.quizzes.store", { subject: route().params.subject })
//     );

const updateQuiz = () => {
    console.log("props.quiz: ", props.quiz);
    console.log('Updating subject:', props.quiz.subject_id, ', Quiz:', props.quiz.slug);

    const SUBJECTS = { 1: "math", 2: "science", 3: "geography"}

    const subjectSlug = SUBJECTS[props.quiz.subject_id]

    const updateUrl = route('subjects.quizzes.update', {
        subject: subjectSlug, 
        quiz: props.quiz.slug
    });
    
    console.log('Update URL:', updateUrl); // Log the constructed URL

    try {
        form.patch(updateUrl, {
            onSuccess: () => {
                console.log('Quiz updated successfully');
            },
            onError: (errors) => {
                console.log('Update failed:', JSON.stringify(errors));
            }
        });
    } catch (error) {
        // Code that runs if an exception occurs
        console.error("Caught an error:", error.message);
    }
};

</script>

<template>
    <Head title="Update Quiz" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Quiz
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between">
                            <h2 class="title-h2">Update Quiz</h2>
                            <Link
                                :href="route('subjects.index')"
                                class="text-sm font-semibold text-blue-700 hover:text-gray-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"
                                    />
                                </svg>
                            </Link>
                        </div>

                        <div>
                            <form
                                @submit.prevent="updateQuiz"
                                class="mt-6 space-y-6"
                            >
                                <div>
                                    <InputLabel
                                        for="title"
                                        value="Quiz Title"
                                    />

                                    <TextInput
                                        id="title"
                                        ref="titleInput"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        :message="form.errors.title"
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="subject" value="Subject" />

                                    <select
                                        ref="subjectInput"
                                        v-model="form.subject_id"
                                    >
                                        <option value="null" selected>
                                            Select a subject
                                        </option>
                                        <option
                                            v-for="subject in subjects"
                                            :key="subject.id"
                                            :value="subject.id"
                                        >
                                            {{ subject.title }}
                                        </option>
                                    </select>

                                    <InputError
                                        :message="form.errors.subject"
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="category"
                                        value="Category"
                                    />

                                    <select
                                        ref="categoryInput"
                                        v-model="form.category_id"
                                    >
                                        <option value="null" selected>
                                            Select a category
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.title }}
                                        </option>
                                    </select>

                                    <InputError
                                        :message="form.errors.category"
                                        class="mt-2"
                                    />
                                </div>

                                <div class="flex items-center gap-4">
                                    <PrimaryButton :disabled="form.processing">
                                        Update
                                    </PrimaryButton>

                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                        <p
                                            v-if="form.recentlySuccessful"
                                            class="text-sm text-gray-600"
                                        >
                                            Updated.
                                        </p>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                        <hr class="my-5" />
                        <div class="mt-6 space-y-6">
                            <div class="flex items-center justify-between">
                                <h3 class="title-h3">Add Questions</h3>
                            </div>
                            <div class="mt-2">
                                <div
                                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6"
                                    v-for="question in form.questions"
                                    :key="question"
                                >
                                    <QuestionCard
                                        :question="question"
                                    ></QuestionCard>
                                </div>

                                <div class="flex items-center">
                                    <PrimaryButton
                                        class="mt-4"
                                        type="button"
                                        @click="addQuestion"
                                        >Add</PrimaryButton
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
