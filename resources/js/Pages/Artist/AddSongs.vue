<template>
    <Head title="Add Songs"/>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Add Songs for {{ albumConSongs.name }}</div>
        <Link :href="route('artist.myAlbums')">
            <v-btn color="#FFB74D">
                Back
            </v-btn>
        </Link>
    </div>

    <v-sheet rounded elevation="3" style="margin-top: 50px">
        <v-form @submit.prevent="insertSong">
            <v-container class="mb-4">
                <v-row>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="form.name"
                            label="Album name"
                            required
                            hide-details
                        ></v-text-field>
                        <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-600"></div>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-file-input
                            v-model="form.song"
                            accept=".mp3"
                            label="song"
                        ></v-file-input>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-btn
                            color="primary"
                            type="submit"
                            class="mt-2"
                            :disabled="form.processing"
                        >
                            Insert
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>
    </v-sheet>

    <v-sheet rounded elevation="3" style="margin-top: 50px">
        <v-list lines="one">
            <v-list-item
                v-for="song in albumConSongs.songs"
                :key="song.id"
                :title="song.name"
            >
                <template v-slot:prepend>
                    <v-icon v-if="idSongInPlay == song.id" icon="mdi-stop" @click="stopSong"></v-icon>
                    <v-icon v-else icon="mdi-play" @click="playSong(song.id)"></v-icon>
                </template>
            </v-list-item>
        </v-list>
    </v-sheet>

    <v-snackbar
        :timeout="2000"
        color="deep-purple-accent-4"
        elevation="24"
        v-model="insertOk"
    >
        Song inserita
    </v-snackbar>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import {ref} from "vue";

let props = defineProps({
    'albumConSongs': Object
});

let insertOk = ref(false);
let idSongInPlay = ref(0);
let playAudio = new Audio();

let form = useForm({
    name: '',
    album_id: props.albumConSongs.id,
    song:[]
});

let playSong = (idSong) => {
    idSongInPlay.value = idSong;
    playAudio.src = "/storage/songs/"+idSong+".mp3";
    playAudio.play();
}

let stopSong = () => {
    idSongInPlay.value = 0;
    playAudio.pause();
}

let insertSong = () => {
    form.post('/artist/myAlbums/addSongs', {
        onSuccess: () => {
            form.reset();
            insertOk.value = true;
        }
    });
}
</script>

<style scoped>

</style>
