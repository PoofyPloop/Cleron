
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

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
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" v-if="$page.props.auth.user.role == 1">
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
                                    <p class="text-4xl">{{ statistics.average }}</p>
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

            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" v-if="$page.props.auth.user.role == 2">
                <div>
                    <p class="text-2xl font-semibold text-gray-600 pb-2">Quizzes</p>
                    
                    <div class="grid grid-cols-3 pt-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between items-center">
                                    <p>Access Quizzes</p>
                                    <Link :href="route('subjects.quizzes.index', { subject: subject.slug})" class="primary-button" >View</Link>
                                </div>

                                <div class="flex justify-between items-center mt-1">
                                    <p>Create Quiz</p>
                                    <Link :href="route('subjects.quizzes.create', {subject: subject.slug})" class="primary-button p-1" >
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
                                    <p class="text-4xl">{{  statistics.comments }}</p>
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
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Pending Report
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Go to
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Quiz 1
                                                </th>
                                                <td class="px-6 py-4">
                                                    <a href="#" class="font-medium text-blue-600 hover:underline">View</a>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a href="#" class="font-medium text-blue-600 hover:underline">Completed</a>
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
