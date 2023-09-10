<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Menu from "@/Components/Menu.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Layout" />

    <Menu />
</template>

<style>

</style>
