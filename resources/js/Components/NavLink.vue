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
        ? 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white focus:outline-none'
        : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-primary-100 hover:text-gray-100 focus:outline-none focus:text-gray-100'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
