<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage, Link } from '@inertiajs/vue3';

const page = usePage();

const props = defineProps({
    statistics: {
        type: Object,
        default: () => ({
            quizzes: 0,
            average: 0,
            threads: 0,
            comments: 0, 
        }),
    },
    quizzes: {
        type: Array,
        default: () => [],
    },
    subject: {
        type: Object,
        default: null,
    },
    pendingReports: {
        type: Array,
        default: () => [],
    },
});

const userRole = computed(() => {
    return page.props.auth?.user?.role ?? null;
});

console.log('User  Role:', userRole.value);
console.log('Pending Reports:', props.pendingReports);
console.log('Report:', JSON.stringify(props.pendingReports, null, 2));

const markReportFixed = (report) => {
    router.delete(route('reports.destroy', {
        report: report.id
    }), {
        onSuccess: () => {
            alert('Report marked as fixed');
        },
        onError: (errors) => {
            console.error('Delete Errors:', errors);
            alert('Failed to remove report');
        }
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" v-if="userRole === 1">
                <p class="text-2xl font-semibold text-gray-600 pb-2 pt-10">Statistics</p>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Quizzes Completed</p>
                                    <p class="text-4xl">{{ statistics.quizzes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Average Grades</p>
                                    <p class="text-4xl">{{ statistics.average.toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Threads Created</p>
                                    <p class="text-4xl">{{ statistics.threads }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Thread Participation</p>
                                    <p class="text-4xl">{{ statistics.comments }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" v-if="userRole === 2">
                <div>
                    <p class="text-2xl font-semibold text-gray-600 pb-2">Quizzes</p>
                    
                    <div class="grid grid-cols-3 pt-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between items-center">
                                    <p>Access Quizzes</p>
                                    <Link :href="route('subjects.quizzes.index', { subject: subject.slug})" class="primary-button">View</Link>
                                </div>

                                <div class="flex justify-between items-center mt-1">
                                    <p>Create Quiz</p>
                                    <Link :href="route('subjects.quizzes.create', {subject: subject.slug})" class="primary-button p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-2xl font-semibold text-gray-600 pb-2 pt-10">Statistics</p>

                    <div class="grid grid-cols-12 gap-6 pt-6">
                        <div class="col-span-6">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <div class="flex justify-between">
                                        <p>Quizzes created</p>
                                        <p class="text-4xl">{{ statistics.quizzes }}</p> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-6">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <div class="flex justify-between">
                                        <p>Thread Participation</p>
                                        <p class="text-4xl">{{ statistics.comments }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <p class="text-2xl font-semibold text-gray-600 pb-2 pt-6">Reports</p>

                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <h2>Pending Reports</h2>
                                    <div v-if="pendingReports.length === 0" class="text-center text-gray-500">
                                        No pending reports found.
                                    </div>
                                    <table v-else class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Report Description</th>
                                                <th scope="col" class="px-6 py-3 text-center">Quiz</th>
                                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="report in pendingReports" :key="report.id" class="bg-white border-b">
                                                <td class="px-6 py-4">{{ report.description }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <Link :href="route('subjects.quizzes.edit', { 
                                                        subject: report.quiz.subject.slug, 
                                                        quiz: report.quiz.slug 
                                                    })" class="font-medium text-blue-600 hover:underline">
                                                        Fix
                                                    </Link>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <button @click="markReportFixed(report)" class="font-medium text-red-600 hover:underline">
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>