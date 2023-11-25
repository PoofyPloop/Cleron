<script setup>
</script>

<template>
    <ul class="container">
        <li class="mb-4 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" v-for="message in $page.props.messages" :key="message.id">
            <div class="font-semibold ">
                {{ message.receiver.name }} 
            </div>
            <p>
                {{ message.message }}
            </p>
        </li>
    </ul>
</template>