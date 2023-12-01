<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full pl-3 pr-4 py-2 text-left text-base font-medium text-primary-700 focus:outline-none focus:text-primary-800 focus:bg-primary-100 '
        : 'block w-full pl-3 pr-4 py-2 text-left text-base font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
