<template>
    <Head title="Home" />
<!--    <div class="text-h3">Last Abums</div>
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
                :src="album.cover"
            >
                <div class="d-flex fill-height justify-center align-center">
                    <div class="text-h2">
                        {{ album.name }}
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
                :src="album.cover"
            >
                <div class="d-flex fill-height justify-center align-center">
                    <div class="text-h2">
                        {{ album.name }}
                    </div>
                </div>
            </v-img>
        </v-carousel-item>
    </v-carousel>-->
    <v-parallax
        src="/img/sfondoHome.jpg"
    >
        <div class="d-flex flex-column fill-height justify-center align-end pa-5 text-white">
            <h1 class="text-h4 font-weight-thin mb-4">
                THE BEST WAY TO SUPPORT YOUR FAVORITE ARTISTS. <br>
                JUST PAY AND GET PAID FOR WHAT YOU LIKE. <br>
                NO MONTHLY FEES. IT'S FOREVER YOURS.
            </h1>
            <h4 class="subheading">
                <v-btn rounded="xl" color="orange">
                    LEARN MORE
                </v-btn>
            </h4>
        </div>

    </v-parallax>


</template>

<script setup>

defineProps({
    lastCinqueAlbum: Object,
    bestCinqueAlbumSellers: Object,
})

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
