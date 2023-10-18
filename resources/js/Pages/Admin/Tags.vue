<template>
    <Head title="Tags" />
    <v-container>
    <div class="d-flex justify-space-between">
        <div class="text-h3">Tags</div>
        <div class="d-flex" style="width: 30%">
            <v-text-field v-model="form.name" label="tag"></v-text-field>
            <v-btn @click="insertTag" color="primary" style="width: 100px; height: 55px; margin-left: 10px">Insert</v-btn>
        </div>
    </div>

    <v-table theme="dark">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black" style="width: 400px">
                Name
            </th>
            <th class="text-left text-black">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in tags"
            :key="item.id"
        >
            <td width="70%">{{ item.name }}</td>
            <td>
                <v-btn color="red" @click="deleteTag(item.id)">
                    <v-icon icon="mdi-trash-can-outline"></v-icon>
                </v-btn>
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
        {{textMessage}}
    </v-snackbar>
    </v-container>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import {ref} from "vue";

let props = defineProps({
    tags: Object
})

let insertOk = ref(false);
let textMessage = ref();

let form = useForm({
    name: '',
});

let insertTag = () => {
    form.post('tags/insert', {
        onSuccess: () => {
            form.reset();
            insertOk.value = true;
            textMessage.value = "tag inserito";
        }
    });
}

let deleteTag = (idTag) => {
    form.delete('tags/delete/'+idTag, {
        onSuccess: () => {
            insertOk.value = true;
            textMessage.value = "tag eliminato";
        }
    });
}

</script>

<style scoped>

</style>
