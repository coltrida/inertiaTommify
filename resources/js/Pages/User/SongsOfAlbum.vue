<template>
    <Head title="Songs of Albums" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Songs of {{albumConSongs.name}} album</div>
        <Link :href="route('user.albumsOfArtist', albumConSongs.songs[0].alb.artist_id)">
            <v-btn color="#FFB74D">
                Back
            </v-btn>
        </Link>
    </div>

    <v-sheet rounded elevation="3" style="margin-top: 50px">
        <v-list lines="one">
            <v-list-item
                v-for="song in albumConSongs.songs"
                :key="song.id"
                :title="song.name"
            >
                <template v-slot:prepend v-if="albumComprato">
                    <v-icon v-if="idSongInPlay == song.id" icon="mdi-stop" @click="stopSong"></v-icon>
                    <v-icon v-else icon="mdi-play" @click="playSong(song.id)"></v-icon>
                </template>
            </v-list-item>
        </v-list>
    </v-sheet>
    </v-container>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    'albumConSongs' : Object,
    'albumComprato' : Boolean,
})

let idSongInPlay = ref(0);
let playAudio = new Audio();

let playSong = (idSong) => {
    idSongInPlay.value = idSong;
    playAudio.src = "/storage/songs/"+idSong+".mp3";
    playAudio.play();
}

let stopSong = () => {
    idSongInPlay.value = 0;
    playAudio.pause();
}
</script>

<style scoped>

</style>
