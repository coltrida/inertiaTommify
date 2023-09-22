<template>
    <Head title="Albums of Artist" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">Albums of {{artistConAlbums.user.name}}  artist</div>
    </div>

    <v-carousel
        cycle
        height="400"
        hide-delimiter-background
        show-arrows="hover"
    >
        <v-carousel-item
            v-for="(album, i) in artistConAlbums.albums"
            :key="i"
        >
            <div class="text-h4 text-center my-2">
                {{ album.name }}

                <Link :href="route('user.songsOfAlbum', album.id)">
                        <span class="pl-2">
                        <v-btn density="compact" icon="mdi-music" size="x-large" color="primary"></v-btn>
                        </span>
                </Link>
            </div>

            <v-img
                height="100%"
                aspect-ratio="16/9"

                :src="imgLink(album)"
            >
            </v-img>
        </v-carousel-item>
    </v-carousel>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    'artistConAlbums' : Object
})

let imgLink = (item) => {
    return '/storage/covers/' + item.id + '.jpg'
}

</script>

<style scoped>

</style>
