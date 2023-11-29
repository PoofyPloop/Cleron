<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ChatMessages from '@/Components/ChatMessages.vue';
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inbox</h2>
        </template>

        <div class="py-10">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <p class="text-2xl font-semibold text-gray-600 pb-2">Messages</p>

                    <div class="grid grid-cols-10 gap-6">
                        <div class="col-span-10">
                            <ChatMessages 
                                :messages="$page.props.messages"
                            >
                            </ChatMessages>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>