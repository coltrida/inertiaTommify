<template>

<!--    {{infoStripe}}-->
    <v-container>
        <v-row>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Nr. of Albums:
                    <v-chip
                        class="ma-2"
                        color="primary"
                        variant="outlined"
                    >

                        {{infoArtistConAlbumEvendite.albums_count}}
                    </v-chip>
                </v-sheet>
            </v-col>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Nr. of Clients:
                    <Link :href="route('artist.myClients')">
                        <v-chip
                            style="cursor: pointer"
                            class="ma-2"
                            color="primary"
                            variant="outlined"
                        >
                            {{infoArtistConAlbumEvendite.user_sales_count}}
                        </v-chip>
                    </Link>
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
                    {{BestAlbumSales?.name}}
                    </v-chip>
                        with
                    <v-chip
                        class="ma-2"
                        color="success"
                        variant="outlined"
                    >
                    {{BestAlbumSales?.user_sales_count}}
                    </v-chip>
                        clients
                </v-sheet>
            </v-col>
            <v-col>
                <v-sheet rounded elevation="3" class="mt-2 p-3">
                    Total Sales:
                    <Link :href="route('artist.myAlbumSales')">
                        <v-chip
                            style="cursor: pointer"
                            class="ma-2"
                            color="success"
                            variant="outlined"
                        >
                            {{totAlbumVendite}}
                        </v-chip>
                    </Link>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>

</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    'infoStripe' : Object,
    'infoArtistConAlbumEvendite' : Object,
    'BestAlbumSales' : Object,
    'totAlbumVendite' : Number,
})
</script>

<style scoped>

</style>
