<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
                                    <p class="text-4xl">{{ $page.props.scores ? $page.props.scores.length : 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <div class="flex justify-between">
                                        <p>Discussions Created</p>
                                        <p class="text-4xl">{{ $page.props.discussions ? $page.props.discussions.length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Discussion Participation</p>
                                    <p class="text-4xl">{{ $page.props.comments ? $page.props.comments.length : 0 }}</p>
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
                                <div class="flex justify-between">
                                    <p>Access Quizzes</p>
                                    <Link href="/quizzes" class="primary-button" >View</Link>
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
                                        <p class="text-4xl">{{ $page.props.quizzes ? $page.props.quizzes.length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between">
                                    <p>Discussions Participated</p>
                                    <p class="text-4xl">{{ $page.props.comments ? $page.props.comments.length : 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-span-6">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <div class="flex justify-between">
                                        <p>Discussions Created</p>
                                        <p class="text-4xl">{{ $page.props.discussions ? $page.props.discussions.length : 0 }}</p>
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
