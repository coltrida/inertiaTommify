<template>
    <Head title="All Artists" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">All Artists</div>
        <div style="width: 30%">
            <v-text-field v-model="search" label="Find"></v-text-field>
        </div>
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
            v-for="item in allArtists.data"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td class="">
                <Link :href="route('user.albumsOfArtist', item.id)">
                    <v-btn color="primary" title="albums">
                        <v-icon icon="mdi-music-box-multiple-outline"></v-icon>
                    </v-btn>
                </Link>
                <v-btn color="success mx-2" v-if="!item.userSales.includes($page.props.auth.user.id)">
                    <v-icon icon="mdi-cash"></v-icon>
                </v-btn>
            </td>
        </tr>
        <tr>
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
        </tr>
        </tbody>
    </v-table>
</template>

<script setup>
import {Link, router} from '@inertiajs/vue3';
import {ref, watch} from "vue";
let props = defineProps({
    allArtists: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    router.get('/user/allArtists', { search: value }, {
        preserveState: true,
        replace: true
    })
})

</script>

<style scoped>

</style>
