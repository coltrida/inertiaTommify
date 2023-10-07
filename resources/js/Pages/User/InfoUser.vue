<template>
    <Head title="Info User" />
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

</template>

<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    'userConAlbumArtist':Object
})


</script>

<style scoped>

</style>
