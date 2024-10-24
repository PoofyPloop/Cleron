
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";


const props = defineProps({
    subjects: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

console.log("props: ", props);

const form = useForm({
    title: "",
    subject_id: "",
    category_id: "",
});

console.log("form: ", form);
console.log('Subject ID:', route().params.subject);

const submit = () => {
    form.post(route("subjects.quizzes.store", { subject: route().params.subject }), {
        onSuccess: () => {
            console.log('Form submitted successfully.');
        },
        onError: (errors) => {
            console.error('Submission failed', errors);
        }
    });
};
</script>

<template>
    <Head title="Create Quiz" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz - Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between">
                            <h2 class="title-h2">Create Quiz</h2>
                            <Link
                                :href="route('subjects.quizzes.index', { subject: route().params.subject })"
                                class="text-sm text-primary-500"
                                >Back to all quiz
                            </Link>
                        </div>

                        <div>
                            <form
                                @submit.prevent="submit"
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
                                        <option :value="null" selected>
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
                                        <option :value="null" selected>
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
                                        >Save</PrimaryButton
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
                                            Saved.
                                        </p>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
