<template>
    <Head title="Info User" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">
            Info of User: {{userConAlbumArtist.name}}
            <v-avatar color="surface-variant mr-2">
                <v-img
                    :src=userConAlbumArtist.avatar
                    alt="John"
                ></v-img>
            </v-avatar>
        </div>
        <div>
            <Link :href="route('user.allArtists.followers', userConAlbumArtist.album_sales[0].artist_id)">
                <v-btn color="warning">Back</v-btn>
            </Link>
        </div>
    </div>

    <v-row class="mt-5">
        <v-col>
            <v-sheet class="pa-5 rounded shadow-lg border-lg">
                Country: {{userConAlbumArtist.country}}
            </v-sheet>

        </v-col>
        <v-col>
            <v-sheet class="pa-5 rounded shadow-lg border-lg">
                City: {{userConAlbumArtist.city}}
            </v-sheet>
        </v-col>
    </v-row>

    <div class="text-h4 mt-8">
        Other Album of: <span style="color: red; font-size: 46px; font-weight: bold">{{userConAlbumArtist.album_sales[0].artist.user.name}}</span>
    </div>

    <v-table class="mt-6" theme="dark" style="border-collapse:separate;
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
            v-for="item in userConAlbumArtist.album_sales"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td class="">
                <v-btn color="primary" title="contact">
                    <v-icon icon="mdi-mail"></v-icon>
                </v-btn>
            </td>
        </tr>
        </tbody>
    </v-table>

    <div class="text-h4 mt-10">
        Other Album of:
        <span style="color: red; font-size: 46px; font-weight: bold">
            {{userConAlbumArtist.name}}
        </span>
    </div>

    <v-table class="mt-6" theme="dark" style="border-collapse:separate;
                    border:solid black 1px;
                    border-radius:6px;">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 50%">
                Name
            </th>
            <th class="text-left text-black">Artist</th>
            <th class="text-black">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in userConAlbumArtist.other_album_sales"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td>{{item.artist.user.name}}</td>
            <td class="">
                <v-btn color="primary" title="contact">
                    <v-icon icon="mdi-mail"></v-icon>
                </v-btn>
            </td>
        </tr>
        </tbody>
    </v-table>
    </v-container>
</template>

<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    'userConAlbumArtist':Object
})


</script>

<style scoped>

</style>
