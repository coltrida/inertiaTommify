<template>
    <Head title="Settings" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Settings - ({{userConTags.role}})</div>
    </div>

    <v-row class="mt-5">
        <v-row>
            <v-col cols="10">
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="userConTags.email"
                            label="E-mail"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-file-input
                            v-model="form.image"
                            label="File input"
                            @change="uploadFoto($event)"
                        ></v-file-input>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="userConTags.country"
                            label="Country"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="userConTags.city"
                            label="City"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col>
                <v-img
                    style="border: 2px solid black"
                    :width="120"
                    :src="userImage"
                ></v-img>
            </v-col>
        </v-row>
    </v-row>

    <v-row>
        <v-col v-for="tag in userConTags.tags" :key="tag.id">
            <v-chip
                style="width: 100px;"
                label
                class="shadow-lg"
            >
                {{tag.name}}
            </v-chip>
        </v-col>
    </v-row>

    <v-row v-if="userConTags.role == 'artist'">
        <v-chip
            style="width: 100px;"
            label
            class="shadow-lg"
        >
            {{userConTags.artist.tag.name}}
        </v-chip>
    </v-row>

    <v-row>
        <v-col class="text-center">
            <v-btn color="primary" @click="update">
                Update
            </v-btn>
        </v-col>
    </v-row>

    <v-snackbar
        :timeout="2000"
        color="deep-purple-accent-4"
        elevation="24"
        v-model="updateOk"
    >
        Update done
    </v-snackbar>
    </v-container>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import {ref, computed } from "vue";

let props = defineProps({
    'userConTags':Object,
    'fotoEsiste':Boolean,
})

let updateOk = ref(false);

const userImage = computed(() => {
    return props.fotoEsiste ? "/storage/users/"+props.userConTags.id+'.jpg' : "/storage/users/user.jpg"
})

let form = useForm({
    idUser: props.userConTags.id,
    email:props.userConTags.email,
    country:'',
    city:'',
    image:''
});

let uploadFoto = (e) => {
    form.post('/user/saveImage');
}

let update = () => {
    form.email = props.userConTags.email;
    form.country = props.userConTags.country;
    form.city = props.userConTags.city;
    form.post('/user/settings', {
        onSuccess: () => {
            props.fotoEsiste= true;
            updateOk.value = true;
        }
    });
}

</script>

<style scoped>

</style>
