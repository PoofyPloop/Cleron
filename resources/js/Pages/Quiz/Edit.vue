<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import QuestionCard from "./Partials/QuestionCard.vue";

const titleInput = ref(usePage().props.quiz.title);
const subjectInput = ref(usePage().props.quiz.subject_id);
const categoryInput = ref(usePage().props.quiz.category_id);
const subjects = usePage().props.subjects;
const categories = usePage().props.categories;

const form = useForm({
    title: usePage().props.quiz.title,
    subject: usePage().props.quiz.subject_id,
    category: usePage().props.quiz.category_id,
});

const updateQuiz = () => {
    form.put(route("quiz.update", usePage().props.quiz.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            if (form.errors.title) {
                titleInput.value.focus();
            }
            if (form.errors.subject) {
                subjectInput.value.focus();
            }
            if (form.errors.category) {
                categoryInput.value.focus();
            }
        },
    });
};

const questionForm = useForm({
    label: "New Question",
    value: "",
    type: "text",
    options: [],
    points: 1,
});

const questions = ref(usePage().props.quiz.questions);

const addQuestion = () => {
    questionForm.post(
        route("subjects.quizzes.questions.store", {
            subject: usePage().props.quiz.subject_id,
            quiz: usePage().props.quiz.id,
        }),
        {
            preserveScroll: true,
            only: ["quiz"],
        }
    );
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
                                href="/subjects"
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
                                        v-model="form.subject"
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
                                        v-model="form.category"
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
                                    <PrimaryButton :disabled="form.processing"
                                        >Update</PrimaryButton
                                    >

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
                                    v-for="question in questions"
                                    :key="question"
                                >
                                    <div class="p-6 text-gray-900">
                                        <QuestionCard
                                            :question="question"
                                        ></QuestionCard>
                                    </div>
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
