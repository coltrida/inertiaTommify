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

<!--                    {{$page.props.auth.news[0].message}}-->


                    <v-menu v-if="$page.props.auth.news.length > 0">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                class="text-none" stacked
                                color="white"
                                v-bind="props"
                            >
                                <v-badge  :content="$page.props.auth.news.length" color="error">
                                    <v-icon>mdi-bell-outline</v-icon>
                                </v-badge>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="notizia in $page.props.auth.news /*$page.props.auth.news*/">
                                <v-btn block variant='text'>
                                    {{notizia.message}}
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <span v-if="$page.props.auth.user.role === 'admin'">
                        <Link :href="route('admin.home')">
                            <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                                Home
                            </v-btn>
                        </Link>
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
                        <Link :href="route('artist.home')">
                            <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                                Home
                            </v-btn>
                        </Link>
                        <Link :href="route('artist.myAlbums')">
                            <v-btn :variant="$page.component === 'Artist/MyAlbums' ? 'tonal' : 'text'">
                                My Albums
                            </v-btn>
                        </Link>
                    </span>

                    <span v-if="$page.props.auth.user.role === 'user'">
                        <v-btn v-if="playShuffleBool" style="background: #9ca3af; color: #1a202c"
                               class="text-none" stacked @click="stopShuffleBtn">
                            <v-icon >mdi-shuffle</v-icon>
                        </v-btn>
                        <v-btn v-else class="text-none" stacked @click="playShuffleBtn">
                            <v-icon >mdi-shuffle</v-icon>
                        </v-btn>


                        <Link :href="route('home')">
                            <v-btn :variant="$page.component === 'Home' ? 'tonal' : 'text'">
                                Home
                            </v-btn>
                        </Link>
                        <Link :href="route('user.myArtists')">
                            <v-btn :variant="$page.component === 'User/MyArtists' ? 'tonal' : 'text'">
                                My Artists
                            </v-btn>
                        </Link>
                        <Link :href="route('user.allArtists')">
                            <v-btn :variant="$page.component === 'User/AllArtists' ? 'tonal' : 'text'">
                                All Artists
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
                                <v-icon
                                    end
                                    icon="mdi-arrow-down"
                                ></v-icon>
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
import {Link, router, usePage} from '@inertiajs/vue3';
import {ref, onMounted, computed} from "vue";
const page = usePage()

let playShuffleBool = ref(false);

onMounted(() => {
    console.log(page.props.auth.news)
    Echo.channel('createAlbumChannel')
        .listen('createAlbumEvent', (ele) => {
            page.props.auth.news.unshift(ele.news)
            console.log(ele)
      //      router.reload({ only: ['users'] })
        })
})

let playShuffleBtn = () => {
    let detail = {
        'songs': 'all',
        'shuffle': true
    }
    let event = new CustomEvent('inertia:playShuffle', {'detail': detail});
    document.dispatchEvent(event);

    playShuffleBool.value = !playShuffleBool.value;
}

let stopShuffleBtn = () => {
    let detail = {
        'songs': 'all',
        'shuffle': false
    }
    let event = new CustomEvent('inertia:stopShuffle', {'detail': detail});
    document.dispatchEvent(event);

    playShuffleBool.value = !playShuffleBool.value;
}

</script>

<style scoped>

</style>
