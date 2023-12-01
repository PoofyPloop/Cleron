<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-50"
    >
        <slot />
    </Link>
</template>
