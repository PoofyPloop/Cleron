<script setup>
</script>

<template>
    <ul class="container">
        <li class="mb-4 p-4 bg-white overflow-hidden shadow-sm" v-for="message in $page.props.messages" :key="message.id">
            <div class="font-semibold ">
                {{ message.receiver.name }} 
            </div>
            <div class="font-weight-bold mb-1">
                {{ message.message }}
            </div>
        </li>
    </ul>
</template>