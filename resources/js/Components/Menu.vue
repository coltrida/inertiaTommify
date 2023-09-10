<!--<template>
    <v-card
        flat
        rounded="0"
    >
        <v-toolbar
            :elevation="8"
            color="blue-grey-darken-4"
        >
                        <v-app-bar-nav-icon class="d-flex d-sm-none" @click="drawer = true"></v-app-bar-nav-icon>
&lt;!&ndash;                        <v-img
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                        ></v-img>&ndash;&gt;

            <v-toolbar-title>Tommify</v-toolbar-title>

            <v-spacer></v-spacer>

            <div class="d-none d-sm-flex">
                <div v-if="$page.props.auth.user">
                    <Link :href="route('home')">
                        <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                            Home
                        </v-btn>
                    </Link>

                    <Link :href="route('admin.users')">
                        <v-btn :variant="$page.component === 'Admin/Users' ? 'tonal' : 'text'">
                            Users
                        </v-btn>
                    </Link>

                    <Link :href="route('logout')" method="post" as="button">
                        <v-btn prepend-icon="mdi-account">
                            {{ $page.props.auth.user.name }}
                        </v-btn>
                    </Link>
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

<script>
export default {
    el: '#app',
    data () {
        return {
            drawer: false,
            tab: null,
            items: [
                'web', 'shopping', 'videos', 'images', 'news',
            ],
        }
    }
}
</script>

<style scoped>

</style>-->


<!--<template>
    <v-app app>
        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = true"
                                class="d-flex d-sm-none"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>Tommify</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>

            <template v-slot:extension>
                <v-tabs
                    v-model="tab"
                    align-with-title
                    class="d-none d-sm-flex"
                >
                <v-tabs-slider color="yellow"></v-tabs-slider>

                <v-tab
                    v-for="item in items"
                    :key="item"
                >
                    {{ item }}
                </v-tab>
                </v-tabs>
            </template>
        </v-app-bar>
        &lt;!&ndash; Add a navigation bar &ndash;&gt;
        <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
        >
            <v-list
                nav
                dense
            >
                <v-list-item-group
                >
                    <v-list-item v-for="(item, index) in items">
                        <v-list-item-title @click="tab = index">{{ item }}</v-list-item-title>
                    </v-list-item>

                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        &lt;!&ndash; Navigation bar ends &ndash;&gt;
        <v-content class="ma-5">
            <v-tabs-items v-model="tab" class="d-flex flex-column align-center">
                <v-tab-item
                    v-for="item in items"
                    :key="item"
                >
                    You are on {{ item }}
                </v-tab-item>
            </v-tabs-items>
        </v-content>
    </v-app>
</template>
<script>
export default {
    el: '#app',
    data () {
        return {
            drawer: false,
            tab: null,
            items: [
                'web', 'shopping', 'videos', 'images', 'news',
            ],
        }
    }
}
</script>-->


<template>
    <v-card>
        <v-layout>
            <!-- <v-system-bar color="deep-purple darken-3"></v-system-bar> -->

            <v-app-bar
                color="blue-grey-darken-4"
                prominent
            >
                <v-app-bar-nav-icon variant="text" class="d-flex d-sm-none" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

                <v-toolbar-title>tommify</v-toolbar-title>

                <v-spacer></v-spacer>

                <div class="d-none d-sm-flex">
                    <div v-if="$page.props.auth.user">
                        <Link :href="route('home')">
                            <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                                Home
                            </v-btn>
                        </Link>

                        <Link :href="route('admin.users')">
                            <v-btn :variant="$page.component === 'Admin/Users' ? 'tonal' : 'text'">
                                Users
                            </v-btn>
                        </Link>

                        <Link :href="route('logout')" method="post" as="button">
                            <v-btn prepend-icon="mdi-account">
                                {{ $page.props.auth.user.name }}
                            </v-btn>
                        </Link>
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
            </v-app-bar>

            <v-navigation-drawer
                v-model="drawer"
                location="left"
                temporary
            >
                <v-list>
                    <Link :href="route('home')">
                        <v-btn block :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                            Home
                        </v-btn>
                    </Link>
                    <Link :href="route('admin.users')">
                        <v-btn block :variant="$page.component === 'Admin/Users' ? 'tonal' : 'text'">
                            Users
                        </v-btn>
                    </Link>
                </v-list>
            </v-navigation-drawer>
        </v-layout>
    </v-card>
</template>

<script>
import {Link} from '@inertiajs/vue3';
export default {
    components: {Link},
    data: () => ({
        drawer: false,
        group: null,
        items: [
            {
                title: 'Foo',
                value: 'foo',
            },
            {
                title: 'Bar',
                value: 'bar',
            },
            {
                title: 'Fizz',
                value: 'fizz',
            },
            {
                title: 'Buzz',
                value: 'buzz',
            },
        ],
    }),

    watch: {
        group () {
            this.drawer = false
        },
    },
}
</script>
