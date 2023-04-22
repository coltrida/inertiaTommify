<template>
    <header class="flex justify-center">
        <Link href="/">Home</Link>
        <Link href="/about">About</Link>
        <Link href="/contact">Contact</Link>
    </header>

    <main>
        <article>
            <slot />
        </article>
    </main>

    <footer
        class="bg-gradient-to-b from-transparent to-gray-300 w-full text-center mt-5 py-10 mx-auto"
    >
        <h2 class="font-bold text-xl pb-5">Player</h2>

    </footer>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>

<style scoped>

</style>
