
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps(['questions']);


</script>

<template>
    <Head title="Quiz Result" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Results</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="pb-6">You scored: </p>
                        {{ questions }}
                        <DangerButton>Report</DangerButton>
                        <!-- <Link class="primary-button">Retry</Link> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
