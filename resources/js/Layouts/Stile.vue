<template>
    <Menu/>
        <div>
            <slot/>
            <v-sheet v-if="visiblePlay" rounded elevation="3" class="mt-2 p-3" color="#E1F5FE">
                <div class="d-flex justify-center align-center">
                    <div style="margin: auto">
                        <v-chip
                            class="ma-2"
                            color="primary"
                            label
                        >
                            <v-icon start icon="mdi-account-circle-outline"></v-icon>
                            <span style="display: none">{{ count }} -</span>
                            {{ songInPlay.name }} - {{ songInPlay.alb.name }}
                        </v-chip>

                        <v-btn class="text-none" stacked @click="prevSong">
                            <v-icon>mdi-rewind</v-icon>
                        </v-btn>
                        <v-btn v-if="playMusicBool" class="text-none" stacked style="margin: 0 10px" @click="pauseSong">
                            <v-icon>mdi-pause</v-icon>
                        </v-btn>
                        <v-btn v-else class="text-none" stacked style="margin: 0 10px" @click="playSong">
                            <v-icon>mdi-play</v-icon>
                        </v-btn>
                        <v-btn class="text-none" stacked @click="nextSong">
                            <v-icon>mdi-fast-forward</v-icon>
                        </v-btn>
                    </div>

                    <v-icon icon="mdi-menu-down" @click="hidePlayer" size="x-large"></v-icon>
                </div>
            </v-sheet>

            <v-sheet v-if="restorePlay" rounded elevation="3" class="mt-2 p-3" color="#E1F5FE" style="position: absolute; bottom: 0">
                <v-icon icon="mdi-menu-up" @click="showPlayer" size="x-large"></v-icon>
            </v-sheet>
        </div>
    <span style="display: none">{{ count }} -</span>
<!--    {{listOfSongs}}
        NumeroCanzoni:{{listOfSongs.length}}
        index:{{indexSong}}
        shuffle:{{shufflePlayBool}}-->

</template>

<script setup>
import Menu from "@/Components/Menu.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import {usePage} from '@inertiajs/vue3'

const page = usePage()

let playAudio = new Audio();

let visiblePlay = ref(false);
let restorePlay = ref(false);
let playMusicBool = ref(false);
let shufflePlayBool = ref(false);
let numberOfSongs = ref();
let listOfSongs = ref([]);
let indexSong = ref([]);
let songInPlay = ref();
let count = ref(1)

router.on('playShuffle', (e) => {
    shufflePlayBool.value = e.detail.shuffle;

    // se non sta suonando musica
    if (!playMusicBool.value) {
        playMusicBool.value = true;
        visiblePlay.value = true;
        caricaListaCanoni(page.props.auth.mySongs);
        suonaListaCanzoni();
    }
})

let caricaListaCanoni = (listaCanzoni) => {
    listOfSongs = listaCanzoni;
    numberOfSongs.value = listaCanzoni.length;
}

let suonaListaCanzoni = () => {
    // switch playMusicBool = vero
    playMusicBool.value = true;

    // Se shuffle suona canzone casuale
    if (shufflePlayBool.value){
        canzoneCasuale();
        playAudio.addEventListener('ended', function () {
            canzoneCasuale();
        });
    } else {
        // se non shuffle suona canzone successiva
        canzoneSuccessiva();
        playAudio.addEventListener('ended', function () {
            canzoneSuccessiva();
        });
    }
}

let canzoneCasuale = () => {
    indexSong = Math.floor(Math.random() * numberOfSongs.value)
    songInPlay = listOfSongs[indexSong];
    count.value++;
    playAudio.src = "/storage/songs/" + songInPlay.id + ".mp3";
    playAudio.play();
}

let canzoneSuccessiva = () => {
    indexSong = listOfSongs.findIndex(song => song.id == songInPlay.id);
    indexSong++;
    if (indexSong > listOfSongs.length - 1) {
        indexSong = 0;
    }
    songInPlay = listOfSongs[indexSong];
    count.value++;
    playAudio.src = "/storage/songs/" + songInPlay.id + ".mp3";
    playAudio.play();
}

let canzonePrecedente = () => {
    indexSong = listOfSongs.findIndex(song => song.id == songInPlay.id);
    indexSong--;
    if (indexSong == -1) {
        indexSong = listOfSongs.length - 1;
    }
    songInPlay = listOfSongs[indexSong];
    count.value--;
    playAudio.src = "/storage/songs/" + songInPlay.id + ".mp3";
    playAudio.play();
}

router.on('stopShuffle', (e) => {
    shufflePlayBool.value = false;
})

router.on('playAlbum', (e) => {
    indexSong = 0;
    shufflePlayBool.value = e.detail.shuffle;
    visiblePlay.value = true;
    caricaListaCanoni(e.detail.album.songs);
    suonaListaCanzoni();
})

let pauseSong = () => {
    playAudio.pause();
    playMusicBool.value = false;
}

let playSong = () => {
    playAudio.play();
    playMusicBool.value = true;
}

let nextSong = () => {
    if (shufflePlayBool.value) {
        canzoneCasuale();
    } else {
        canzoneSuccessiva();
    }
}

let prevSong = () => {
    if (shufflePlayBool.value) {
        canzoneCasuale();
    } else {
        canzonePrecedente();
    }
}

let hidePlayer = () => {
    visiblePlay.value = false
    restorePlay.value = true
}

let showPlayer = () => {
    visiblePlay.value = true
    restorePlay.value = false
}

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<style>

</style>
