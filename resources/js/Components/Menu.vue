<template>
    <v-card
        flat
        rounded="0"
    >
        <v-toolbar :elevation="8"
            color="blue-grey-darken-4"
            fixed
        >
            <v-app-bar-nav-icon class="d-flex d-sm-none" @click="drawer = true"></v-app-bar-nav-icon>

            <v-toolbar-title>Tommify</v-toolbar-title>

            <v-spacer></v-spacer>

            <div class="d-none d-sm-flex">
                <div v-if="$page.props.auth.user">
                    <Link :href="route('home')">
                        <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                            Home
                        </v-btn>
                    </Link>

                    <span v-if="$page.props.auth.user.role === 'admin'">
                        <Link :href="route('admin.users')">
                            <v-btn :variant="$page.component === 'Admin/Users' ? 'tonal' : 'text'">
                                Users
                            </v-btn>
                        </Link>
                        <Link :href="route('admin.artists')">
                            <v-btn :variant="$page.component === 'Admin/Artists' ? 'tonal' : 'text'">
                                Artists
                            </v-btn>
                        </Link>
                        <Link :href="route('admin.albums')">
                            <v-btn :variant="$page.component === 'Admin/Albums' ? 'tonal' : 'text'">
                                Albums
                            </v-btn>
                        </Link>
                    </span>

                    <span v-if="$page.props.auth.user.role === 'artist'">
                        <Link :href="route('artist.myAlbums')">
                            <v-btn :variant="$page.component === 'Artist/MyAlbums' ? 'tonal' : 'text'">
                                My Albums
                            </v-btn>
                        </Link>
                    </span>

                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                                {{ $page.props.auth.user.name }}
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item>
                                <Link :href="route('logout')" method="post" as="button">
                                    <v-btn block variant='text'>
                                        Logout
                                    </v-btn>
                                </Link>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <div v-else>
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
                </div>
            </div>
        </v-toolbar>
    </v-card>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

</script>

<style scoped>

</style>
