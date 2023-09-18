<template>
    <v-row>
        <v-col cols="12" sm="6">
            <div class="d-flex justify-space-between">
                <div class="text-h4">My Artists</div>
                <div style="width: 40%">
                    <v-text-field v-model="searchArtist" label="Find"></v-text-field>
                </div>
            </div>
            <v-sheet rounded elevation="3" style="margin-top: 10px; padding-bottom: 30px">
                <v-list lines="one" style="margin-bottom: 30px">
                    <v-list-item
                        v-for="artist in myArtistsPaginate.data"
                        :key="artist.id"
                        :title="artist.name"
                    >
                        <template v-slot:prepend>
                            <v-icon v-if="idSongInPlay == artist.id" icon="mdi-stop" @click="stopSong"></v-icon>
                            <v-icon v-else icon="mdi-play" @click="playSong(artist.id)"></v-icon>
                        </template>
                    </v-list-item>
                </v-list>
                <component
                    v-for="link in myArtistsPaginate.links"
                    class="mx-1 p-2" style="border: black 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !link.url, 'font-bold; bg-black': link.active}"
                >
                    <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-2"></Link>
                    <span v-else v-html="link.label" class="text-gray-400"></span>
                </component >
            </v-sheet>
        </v-col>

        <v-col cols="12" sm="6">
            <div class="d-flex justify-space-between">
                <div class="text-h4">My Albums</div>
                <div style="width: 40%">
                    <v-text-field v-model="searchAlbum" label="Find"></v-text-field>
                </div>
            </div>
            <v-sheet rounded elevation="3" style="margin-top: 10px">
                <v-list lines="one">
                    <v-list-item
                        v-for="album in userConMyAlbums.album_sales"
                        :key="album.id"
                        :title="album.name"
                    >
                        <template v-slot:prepend>
                            <v-icon v-if="idSongInPlay == album.id" icon="mdi-stop" @click="stopSong"></v-icon>
                            <v-icon v-else icon="mdi-play" @click="playSong(album.id)"></v-icon>
                        </template>
                    </v-list-item>
                </v-list>
            </v-sheet>
        </v-col>
    </v-row>

</template>

<script setup>
import {ref, watch} from "vue";
import {Link, router} from "@inertiajs/vue3";

let props = defineProps({
    'myArtistsPaginate': Object,
    'userConMyAlbums': Object,
    filters: Object
});

let searchArtist = ref(props.filters.searchArtist);
let searchAlbum = ref(props.filters.searchAlbum);

watch(searchArtist, value => {
    router.get('/user/home', { searchArtist: value }, {
        preserveState: true,
        replace: true
    })
})

watch(searchAlbum, value => {
    router.get('/user/home', { searchAlbum: value }, {
        preserveState: true,
        replace: true
    })
})

let idSongInPlay = ref(0);

let playSong = (idSong) => {

}

let stopSong = () => {

}

</script>

<style scoped>

</style>
