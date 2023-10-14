<template>
    <Head title="Albums of Artist" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">Albums of artist: {{artistConAlbums.user.name}}</div>
    </div>

    <v-table theme="dark" style="border-collapse:separate;
                    border:solid black 1px;
                    border-radius:6px;">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 40%">
                Name
            </th>
            <th class="text-left text-black" style="width: 30%">
                Cover
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
            <td>
                <v-img
                    :width="100"
                    cover
                    :src=item.cover
                ></v-img>
            </td>
            <td class="">
                <Link :href="route('user.songsOfAlbum', item.id)">
                    <v-btn color="primary mx-2" title="songs">
                        <v-icon icon="mdi-music"></v-icon>
                    </v-btn>
                </Link>
                <Link :href="route('user.album.followers', item.id)">
                    <v-btn color="blue mx-2" title="followers">
                        <v-icon icon="mdi-account"></v-icon>
                    </v-btn>
                </Link>
<!--                <v-progress-circular
                    class="ml-5"
                    v-if="sendMail && idAlbumToBuy == item.id"
                    indeterminate
                    color="primary"
                ></v-progress-circular>-->
                <Link :href="route('user.paypal')">
                    <v-btn  @click="buyAlbum(item)" color="success mx-2" v-if="!item.user_sales.some(element => {
                    if(element.id === $page.props.auth.user.id) {
                        return true
                        }
                    })">
                        <v-icon icon="mdi-cash"></v-icon>
                    </v-btn>
                </Link>

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

    <v-snackbar
        :timeout="2000"
        color="deep-purple-accent-4"
        elevation="24"
        v-model="buyOk"
    >
        Album Bought
    </v-snackbar>

</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    'artistConAlbums' : Object
})

let sendMail = ref(false);
let buyOk = ref(false);
let idAlbumToBuy = ref();

let form = useForm({
    album: {},
});

let buyAlbum = (album) => {
    idAlbumToBuy.value = album.id;
    sendMail.value = true;
    form.album = album;
    form.get('/paypal');
    /*form.post('/user/buyAlbum', {
        onSuccess: () => {
            sendMail.value = false;
            buyOk.value = true;
        }
    });*/
}

</script>

<style scoped>

</style>
