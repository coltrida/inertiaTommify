<template>
    <v-card
        flat
        rounded="0"
    >
        <v-toolbar
            color="blue-grey-darken-4"
        >
<!--            <v-app-bar-nav-icon></v-app-bar-nav-icon>-->
<!--            <v-img
                src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
            ></v-img>-->

            <v-toolbar-title>Tommify</v-toolbar-title>

            <v-spacer></v-spacer>

            <Link :href="route('home')">
                <v-btn variant="text">
                    Home
                </v-btn>
            </Link>

            <Link :href="route('admin.users')">
                <v-btn variant="text">
                    Users
                </v-btn>
            </Link>

            <Link :href="route('login')">
                <v-btn variant="text">
                    Login
                </v-btn>
            </Link>

            <Link :href="route('register')">
                <v-btn variant="text">
                    Register
                </v-btn>
            </Link>

<!--            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>-->
        </v-toolbar>
    </v-card>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<style scoped>

</style>
