<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const messageInput = ref('');

const form = useForm({
    message: ''
});

const sendMessage2 = () => {
    form.post(route('quiz.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            // alert('Quiz Created!')
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

const sendMessage = () => {
    this.$emit('messagesent', {
        user: usePage().props.user,
        message: messageInput
    });

    messageInput = ''
}
</script>

<template>
    <div class="w-full">
        <div>
            <InputLabel for="title" value="Message" />

            <TextInput
                id="title"
                ref="titleInput"
                v-model="form.message"
                type="text"
                class="mt-1 block w-full"
                @keyup.enter="sendMessage"
                placeholder="Type your message here..."
            />

            <InputError :message="form.errors.title" class="mt-2" />
        </div>

        <div class="mt-4">
            <button class="primary-button" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </div>
    </div>
</template>