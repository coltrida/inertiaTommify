<template>
    <Head title="Home" />
    <div class="text-h3">Last Abums</div>
    <v-carousel
        cycle
        height="400"
        hide-delimiter-background
        show-arrows="hover"
    >
        <v-carousel-item
            v-for="(album, i) in lastCinqueAlbum"
            :key="i"
        >
            <v-img
                height="100%"
                aspect-ratio="16/9"
                cover
                :src="imgLink(album)"
            >
                <div class="d-flex fill-height justify-center align-center">
                    <div class="text-h2">
                        {{ album.name }} Slide
                    </div>
                </div>
            </v-img>
        </v-carousel-item>
    </v-carousel>

    <div class="text-h3" style="margin-top: 100px">Best Sellers</div>
    <v-carousel
        cycle
        height="400"
        hide-delimiter-background
        show-arrows="hover"
    >
        <v-carousel-item
            v-for="(album, i) in bestCinqueAlbumSellers"
            :key="i"
        >
            <v-img
                height="100%"
                aspect-ratio="16/9"
                cover
                :src="imgLink(album)"
            >
                <div class="d-flex fill-height justify-center align-center">
                    <div class="text-h2">
                        {{ album.name }}
                    </div>
                </div>
            </v-img>
        </v-carousel-item>
    </v-carousel>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    lastCinqueAlbum: Object,
    bestCinqueAlbumSellers: Object,
})

let imgLink = (album) => {
    return '/storage/covers/'+album.id+'.jpg'
}

</script>

<script>
export default {
    data () {
        return {
            colors: [
                'indigo',
                'warning',
                'pink darken-2',
                'red lighten-1',
                'deep-purple accent-4',
            ],
            slides: [
                'First',
                'Second',
                'Third',
                'Fourth',
                'Fifth',
            ],
        }
    },
}
</script>


<style scoped>

</style>
