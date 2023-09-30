<template>
    <Head title="Settings" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">Settings</div>
    </div>

    <v-row class="mt-5">
        <v-col>
            <v-text-field
                v-model="$page.props.auth.user.email"
                label="E-mail"
            ></v-text-field>
        </v-col>
        <v-col>
            <v-text-field
                v-model="password"
                :type="viewPassword ? 'text' : 'password'"
                label="Password"
                :append-icon="viewPassword ? 'mdi-eye' : 'mdi-eye-off-outline'"
                @click:append="toggleView"
            ></v-text-field>
        </v-col>
    </v-row>

    <v-row>
        <v-col class="text-center">
            <v-btn color="primary" @click="update">
                Update
            </v-btn>
        </v-col>
    </v-row>

</template>

<script setup>

import {ref} from "vue";

let password = ref()
let viewPassword = ref(false)

let toggleView = () => {
    viewPassword.value = !viewPassword.value
}

let update = () => {

}

</script>

<style scoped>

</style>
