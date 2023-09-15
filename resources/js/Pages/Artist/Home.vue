<template>

        <v-row>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Nr. of Albums: {{infoArtistConAlbumEvendite.albums_count}}
                </v-sheet>
            </v-col>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Nr. of Clients: {{infoArtistConAlbumEvendite.user_sales_count}}
                </v-sheet>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Best Album Sales:
                    <v-chip
                        class="ma-2"
                        color="success"
                        variant="outlined"
                    >
                    {{BestAlbumSales.name}}
                    </v-chip>
                        with
                    <v-chip
                        class="ma-2"
                        color="success"
                        variant="outlined"
                    >
                    {{BestAlbumSales.user_sales_count}}
                    </v-chip>
                        clients
                </v-sheet>
            </v-col>
            <v-col>

            </v-col>
        </v-row>


</template>

<script setup>
defineProps({
    'infoArtistConAlbumEvendite' : Object,
    'BestAlbumSales' : Object,
})
</script>

<style scoped>

</style>
