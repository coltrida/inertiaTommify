<template>
    <Head title="MyAlbums"/>
    <div class="d-flex justify-space-between align-center">
        <div style="width: 100%">
            <v-form @submit.prevent="insertAlbum" enctype="multipart/form-data">
                <v-container class="mb-4">
                    <v-row>
                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="form.name"
                                label="Album name"
                                required
                                hide-details
                            ></v-text-field>
                            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-600"></div>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-file-input
                                v-model="form.cover"
                                accept="image/*"
                                label="Album Cover"
                            ></v-file-input>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-btn
                                color="primary"
                                type="submit"
                                class="mt-2"
                                :disabled="form.processing"
                            >
                                Insert
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </div>
        <div style="width: 30%">
            <v-text-field v-model="search" label="Find"></v-text-field>
        </div>
    </div>

    <v-chip
        class="ma-6"
        color="pink"
        label
        text-color="white"
    >
        <v-icon start icon="mdi-label"></v-icon>
        Every Album must have at least 5 songs to be visible!
    </v-chip>


    <v-table theme="dark">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 400px">
                Name
            </th>
            <th class="text-left text-black" style="width: 400px">
                cover
            </th>
            <th class="text-left text-black" style="width: 400px">
                Action
            </th>
            <th class="text-left text-black" style="width: 400px">
                Visible
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in artistConMyAlbums.data"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td>
                <v-img
                    :width="50"
                    aspect-ratio="16/9"
                    cover
                    :src="imgLink(item)"
                ></v-img>
            </td>
            <td>
                <Link :href="route('artist.myAlbums.addSongs', item.id)">
                    <v-badge :content="item.nrSongs" color="warning">
                        <v-btn color="#5865f2">
                            {{item.visible ? 'view Songs' : 'Add Songs'}}
                        </v-btn>
                    </v-badge>
                </Link>
            </td>
            <td>
                <v-chip
                    class="ma-2"
                    :color="item.visible ? 'green' : 'red'"
                    text-color="white"
                >
                    {{item.visible ? 'yes' : 'no'}}
                </v-chip>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <component
                    v-for="link in artistConMyAlbums.links"
                    class="mx-1 p-2" style="border: white 1px solid; border-radius: 5px"
                    :class="{'text-gray-400': !link.url, 'font-bold; bg-white': link.active}"
                >
                    <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-2"></Link>
                    <span v-else v-html="link.label" class="text-gray-400"></span>
                </component>
            </td>
        </tr>
        </tbody>
    </v-table>

    <v-snackbar
        :timeout="2000"
        color="deep-purple-accent-4"
        elevation="24"
        v-model="insertOk"
    >
        Album inserito
    </v-snackbar>
</template>

<script setup>
import {useForm, Link, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";

let props = defineProps({
    artistConMyAlbums: Object,
    filters: Object
});

let search = ref(props.filters.search);
let insertOk = ref(false);

let form = useForm({
    name: '',
    cover: []
});

watch(search, value => {
    router.get('myAlbums', {search: value}, {
        preserveState: true,
        replace: true
    })
})

let insertAlbum = () => {
    form.post('/artist/myAlbums/create', {
        onSuccess: () => {
            form.reset();
            insertOk.value = true;
        }
    });
}

let imgLink = (item) => {
    return '/storage/covers/' + item.id + '.jpg'
}

</script>

<style scoped>

</style>
