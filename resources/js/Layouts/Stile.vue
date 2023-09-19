<template>
    <Menu/>
    <v-container>
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

    </v-container>
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
let songInPlay = ref();
let count = ref(1)

router.on('playShuffle', (e) => {
/*        console.log(e.detail.songs)*/
        // console.log(page.props.auth.mySongs.length)
    if (e.detail.songs === 'all'){
        listOfSongs = page.props.auth.mySongs;
/*        console.log(listOfSongs)*/
    } else if(e.detail.songs === 'album'){
        listOfSongs = e.detail.album.songs;
/*        console.log(listOfSongs)
        console.log(e.detail.shuffle)*/
    }


    if (!playMusicBool.value) {
        playMusicBool.value = true;
        shufflePlayBool.value = e.detail.shuffle;
        visiblePlay.value = true
        numberOfSongs.value = page.props.auth.mySongs.length;
        if (shufflePlayBool.value){
            canzoneCasuale();
            playAudio.addEventListener('ended', function () {
                canzoneCasuale();
            });
        } else {
            canzoneSuccessiva();
            playAudio.addEventListener('ended', function () {
                canzoneSuccessiva();
            });
        }
    } else {
        if (e.detail.songs === 'album'){
            playAudio.pause();
            let indexSong = 0;
            songInPlay = listOfSongs[indexSong];
            count.value++;
            playAudio.src = "/storage/songs/" + songInPlay.id + ".mp3";
            playAudio.play();
        }
    }
})

let canzoneCasuale = () => {
    let randomIndex = Math.floor(Math.random() * numberOfSongs.value)
    songInPlay = listOfSongs[randomIndex];
    count.value++;
    playAudio.src = "/storage/songs/" + songInPlay.id + ".mp3";
    playAudio.play();
}

let canzoneSuccessiva = () => {
    //   console.log(listOfSongs)
    let indexSong = listOfSongs.findIndex(song => song.id == songInPlay.id);
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
    //   console.log(listOfSongs)
    let indexSong = listOfSongs.findIndex(song => song.id == songInPlay.id);
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
