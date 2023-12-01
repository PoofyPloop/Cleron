<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-white border border-blue-700 rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest shadow-sm hover:text-gray-600 hover:border-gray-600 hover:bg-gray-100"
    >
        <slot />
    </button>
</template>
