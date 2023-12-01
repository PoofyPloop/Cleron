<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

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
        ? 'block w-full pl-3 pr-4 py-2 text-left text-base font-medium text-primary-700 focus:outline-none'
        : 'block w-full pl-3 pr-4 py-2 text-left text-base font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
