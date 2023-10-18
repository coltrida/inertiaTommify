<template>
    <Head title="Albums" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Albums</div>
        <div style="width: 30%">
            <v-text-field v-model="search" label="Find"></v-text-field>
        </div>
    </div>

    <v-table theme="dark">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 400px">
                Name
            </th>
            <th class="text-left text-black" style="width: 400px">
                Artist
            </th>
            <th class="text-left text-black">
                nr. of Songs
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in albums.data"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td>{{ item.artist }}</td>
            <td>{{ item.nrSongs }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <component
                    v-for="link in albums.links"
                    class="mx-1 p-2" style="border: white 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !link.url, 'font-bold; bg-white': link.active}"
                >
                    <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-2"></Link>
                    <span v-else v-html="link.label" class="text-gray-400"></span>
                </component >


            </td>
        </tr>
        </tbody>
    </v-table>
    </v-container>
</template>

<script setup>
import {Link, router} from '@inertiajs/vue3';
import {ref, watch} from "vue";

let props = defineProps({
    albums: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    router.get('albums', { search: value }, {
        preserveState: true,
        replace: true
    })
})
</script>

<style scoped>

</style>
