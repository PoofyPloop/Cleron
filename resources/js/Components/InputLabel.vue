<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block mb-2 text-gray-600 text-sm font-medium">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
