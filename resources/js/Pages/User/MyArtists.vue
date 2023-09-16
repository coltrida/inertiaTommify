<template>
    <Head title="My Artists" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">My Artists</div>
        <div style="width: 30%">
            <v-text-field v-model="search" label="Find"></v-text-field>
        </div>
    </div>
    <v-carousel
        cycle
        height="400"
        hide-delimiter-background
        show-arrows="hover"
    >
        <v-carousel-item
            v-for="(artist, i) in userConMyArtists.artist_sales"
            :key="i"
        >
            <v-img
                height="100%"
                aspect-ratio="16/9"

                src="/img/user.jpg"
            >
                <div class="d-flex fill-height justify-center align-top">
                    <div class="text-h4">
                        {{ artist.user.name }}
                    </div>
                </div>
            </v-img>
        </v-carousel-item>
    </v-carousel>
</template>

<script setup>
import {Link, router} from '@inertiajs/vue3';
import {ref, watch} from "vue";
let props = defineProps({
    userConMyArtists: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    router.get('/user/myArtists', { search: value }, {
        preserveState: true,
        replace: true
    })
})

</script>

<style scoped>

</style>
