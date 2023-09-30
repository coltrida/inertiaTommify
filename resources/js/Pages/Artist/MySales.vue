<template>
    <Head title="My Album Sales" />
    <div class="d-flex justify-space-between">
        <div class="text-h3">My Albums Sales</div>
    </div>
    <v-sheet rounded elevation="3" class="mt-4 p-3"
             v-for="album in myAlbumSales" :key="album.id">
            <div class="d-flex justify-space-between">
                <div>{{album.name}}</div>
                <div>Nr. of Sales: {{album.user_sales_count}}</div>
            </div>
    </v-sheet>
</template>

<script setup>

defineProps({
    'myAlbumSales': Array
})

</script>

<style scoped>

</style>
