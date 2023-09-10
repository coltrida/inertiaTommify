<template>
    <Head title="MyAlbums" />

    <v-form @submit.prevent="insertAlbum">
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

    <v-table theme="dark">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black">
                Name
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in myAlbums"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
        </tr>
        </tbody>
    </v-table>

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

defineProps({
    myAlbums: Array,
});

let form = useForm({
    name: ''
});

let insertAlbum = () => {
    form.post('/myAlbums/create');
    form.reset()
}

</script>

<style scoped>

</style>
