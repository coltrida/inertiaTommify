<template>
    <Head title="Followers" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Followers of artist: {{artistConFollowers.user.name}}</div>
        <div>
            <Link :href="route('user.allArtists')">
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
            v-for="item in artistConFollowers.user_sales"
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
                    idArtist = artistConFollowers.id,
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
    </v-container>
</template>

<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    'artistConFollowers':Object
})

</script>

<style scoped>

</style>
