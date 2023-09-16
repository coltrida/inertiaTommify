<template>
    <Menu />
        <v-container>
            <div >
                <slot/>
                <v-sheet v-if="visiblePlay" rounded elevation="3" class="mt-2 p-3">
                    <div class="d-flex justify-center align-center">
                        <v-chip
                            class="ma-2"
                            color="primary"
                            label
                        >
                            <v-icon start icon="mdi-account-circle-outline"></v-icon>
                                {{songInPlay.name}} - {{songInPlay.alb.name}}
                        </v-chip>

                        <v-btn class="text-none" stacked>
                            <v-icon >mdi-rewind</v-icon>
                        </v-btn>
                        <v-btn v-if="playMusicBool" class="text-none" stacked style="margin: 0 10px" @click="pauseSong">
                            <v-icon >mdi-pause</v-icon>
                        </v-btn>
                        <v-btn v-else class="text-none" stacked style="margin: 0 10px" @click="playSong">
                            <v-icon >mdi-play</v-icon>
                        </v-btn>
                        <v-btn class="text-none" stacked @click="nextSong">
                            <v-icon >mdi-fast-forward</v-icon>
                        </v-btn>
                    </div>
                </v-sheet>
            </div>

        </v-container>
</template>

<script setup>
import Menu from "@/Components/Menu.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3'

const page = usePage()

let playAudio = new Audio();

let visiblePlay = ref(false);
let playMusicBool = ref(false);
let shufflePlayBool = ref(false);
let numberOfSongs = ref();
let listOfSongs = ref([]);
let songInPlay = ref();

router.on('playShuffle', (e) => {
/*    console.log(e.detail)
    console.log(page.props.auth.mySongs.length)*/
    listOfSongs = page.props.auth.mySongs;

    if (!playMusicBool.value){
        playMusicBool.value = true;
        shufflePlayBool.value = true;
        visiblePlay.value = true
        numberOfSongs.value = page.props.auth.mySongs.length;
        canzoneCasuale();
        playAudio.addEventListener('ended', function(){
            canzoneCasuale();
        });
    }
})

let canzoneCasuale = () => {
    let randomIndex = Math.floor(Math.random() * numberOfSongs.value)
 //   console.log(randomIndex)
    songInPlay = listOfSongs[randomIndex];
    playAudio.src = "/storage/songs/"+songInPlay.id+".mp3";
    playAudio.play();
}

let canzoneSuccessiva = () => {
 //   console.log(listOfSongs)
    let indexSong = listOfSongs.findIndex(song => song.id == songInPlay.id);
    indexSong++;
    if (indexSong > listOfSongs.length-1){
        indexSong = 0;
    }
    songInPlay = listOfSongs[indexSong];
    console.log(songInPlay)
    playAudio.src = "/storage/songs/"+songInPlay.id+".mp3";
    playAudio.play();
/*    playAudio.src = "/storage/songs/"+randomIdSong+".mp3";
    playAudio.play();*/
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
    if (shufflePlayBool.value){
        canzoneCasuale();
    } else {
        canzoneSuccessiva();
    }

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
