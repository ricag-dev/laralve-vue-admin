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
        ? 'bg-indigo-400 text-white'
        : ' '
);
</script>

<template>
    <Link :href="href" :class="classes" class="p-4 block border-b-2 border-black text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:bg-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <slot />
    </Link>
</template>
