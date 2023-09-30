<template>
    <Head title="My Clients" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">My Clients</div>
    </div>
    <v-sheet rounded elevation="3" class="mt-4 p-3"
             v-for="client in myClients" :key="client.id">
            {{client.name}}
    </v-sheet>
</template>

<script setup>

defineProps({
    'myClients': Object
})

</script>

<style scoped>

</style>
