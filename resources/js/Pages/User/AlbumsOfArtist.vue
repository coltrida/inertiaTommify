<template>
    <Head title="Albums of Artist" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">Albums of {{artistConAlbums.user.name}}  artist</div>
    </div>

    <v-table theme="dark" style="border-collapse:separate;
                    border:solid black 1px;
                    border-radius:6px;">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 70%">
                Name
            </th>
            <th class="text-black">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in artistConAlbums.albums"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td class="">
                <Link >
                    <v-btn color="primary" title="songs">
                        <v-icon icon="mdi-music"></v-icon>
                    </v-btn>
                </Link>
                <v-btn color="success mx-2" v-if="!item.user_sales.some(element => {
                    if(element.id === $page.props.auth.user.id) {
                        return true
                        }
                    })">
                    <v-icon icon="mdi-cash"></v-icon>
                </v-btn>
            </td>
        </tr>
<!--        <tr>
            <td colspan="3">
                <component
                    class="mx-1 p-2" style="border: white 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !allArtists.links[0].url, 'font-bold; bg-white': allArtists.links[0].active}"
                >
                    <Link v-if="allArtists.links[0].url" :href="allArtists.links[0].url" v-html="allArtists.links[0].label" class="px-2"></Link>
                    <span v-else v-html="allArtists.links[0].label" class="text-gray-400"></span>
                </component >
                <component
                    class="mx-1 p-2" style="border: white 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !allArtists.links[allArtists.links.length-1].url, 'font-bold; bg-white': allArtists.links[allArtists.links.length-1].active}"
                >
                    <Link v-if="allArtists.links[allArtists.links.length-1].url" :href="allArtists.links[allArtists.links.length-1].url" v-html="allArtists.links[allArtists.links.length-1].label" class="px-2"></Link>
                    <span v-else v-html="allArtists.links[allArtists.links.length-1].label" class="text-gray-400"></span>
                </component >
            </td>
        </tr>-->
        </tbody>
    </v-table>

<!--    <v-carousel
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
    </v-carousel>-->
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
