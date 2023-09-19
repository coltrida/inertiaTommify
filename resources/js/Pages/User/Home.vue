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
                            <v-icon v-if="idArtistInPlay == artist.id" icon="mdi-stop" @click="stopArtist"></v-icon>
                            <v-icon v-else icon="mdi-play" @click="playArtist(artist.id)"></v-icon>
                        </template>
                    </v-list-item>
                </v-list>
                <div class="ml-3">
                <component
                    v-for="link in myArtistsPaginate.links"
                    class="mx-1 p-2" style="border: black 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !link.url, 'font-bold; bg-black': link.active}"
                >
                    <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-2"></Link>
                    <span v-else v-html="link.label" class="text-gray-400"></span>
                </component >
                </div>
            </v-sheet>
        </v-col>

        <v-col cols="12" sm="6">
            <div class="d-flex justify-space-between">
                <div class="text-h4">My Albums</div>
                <div style="width: 40%">
                    <v-text-field v-model="searchAlbum" label="Find"></v-text-field>
                </div>
            </div>
            <v-sheet rounded elevation="3" style="margin-top: 10px; padding-bottom: 30px">
                <v-list lines="one" style="margin-bottom: 30px">
                    <v-list-item
                        v-for="album in myAlbumsPaginate.data"
                        :key="album.id"
                        :title="album.name"
                    >
                        <template v-slot:prepend>
                            <v-icon v-if="idAlbumInPlay == album.id" icon="mdi-stop" @click="stopAlbum"></v-icon>
                            <v-icon v-else icon="mdi-play" @click="playAlbum(album)"></v-icon>
                        </template>
                    </v-list-item>
                </v-list>
                <div class="ml-3">
                    <component
                        v-for="link in myAlbumsPaginate.links"
                        class="mx-1 p-2" style="border: black 1px solid; border-radius: 5px"
                        :class="{'text-gray-400': !link.url, 'font-bold; bg-black': link.active}"
                    >
                        <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-2"></Link>
                        <span v-else v-html="link.label" class="text-gray-400"></span>
                    </component >
                </div>

            </v-sheet>
        </v-col>
    </v-row>

</template>

<script setup>
import {ref, watch} from "vue";
import {Link, router} from "@inertiajs/vue3";

let props = defineProps({
    'myArtistsPaginate': Object,
    'myAlbumsPaginate': Object,
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

let idArtistInPlay = ref(0);
let idAlbumInPlay = ref(0);
let playShuffleBool = ref(false);

let playArtist = (idArtist) => {

}

let stopArtist = () => {

}

let playAlbum = (album) => {
    let detail = {
        'songs': 'album',
        'shuffle': false,
        'album': album
    }
    idAlbumInPlay.value = album.id;
    idArtistInPlay.value = 0;
    let event = new CustomEvent('inertia:playShuffle', {'detail': detail});
    document.dispatchEvent(event);

    playShuffleBool.value = !playShuffleBool.value;
}

let stopAlbum = () => {

}

</script>

<style scoped>

</style>
