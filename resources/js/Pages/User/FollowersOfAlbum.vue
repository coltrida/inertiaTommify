<template>
    <Head title="Followers of Album" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">Followers of album: {{albumConFollowers.name}}</div>
        <div>
            <Link :href="route('user.albumsOfArtist', albumConFollowers.artist_id)">
                <v-btn color="warning">Back</v-btn>
            </Link>

        </div>
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
            v-for="item in albumConFollowers.user_sales"
            :key="item.id"
        >
            <td>
                <v-avatar color="surface-variant mr-2">
                    <v-img
                        :src=item.avatar
                        alt="John"
                    ></v-img>
                </v-avatar>
                {{ item.name }}
            </td>
            <td class="">
                <v-btn color="primary" title="contact">
                    <v-icon icon="mdi-mail"></v-icon>
                </v-btn>
                <Link :href="route('user.allArtists.follower.user', [
                    idArtist = albumConFollowers.artist_id,
                    idUser = item.id,
                ])">
                    <v-btn color="success mx-2" title="info">
                        <v-icon icon="mdi-information"></v-icon>
                    </v-btn>
                </Link>
            </td>
        </tr>
        </tbody>

    </v-table>

</template>

<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    'albumConFollowers':Object
})

</script>

<style scoped>

</style>
