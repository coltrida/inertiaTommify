<template>
    <Layout>
        <section>
            <h2 class="text-2xl font-bold py-10 flex justify-center">Users</h2>
            <article
                v-for="user in users"
                :key="user.id"
                class="flex justify-center items-center shadow-md bg-white rounded-xl p-4 mx-auto max-w-3xl"
            >

                <Link :href="route('article.show', user.id)">
                    <h3>{{user.name}}</h3>
                </Link>

            </article>
        </section>
    </Layout>
</template>

<script setup>
import Layout from '../Layouts/Principale.vue'
import { Link } from "@inertiajs/inertia-vue3";
defineProps({ users: Object })
</script>

<style scoped>

</style>
