<template>
    <v-container>
    <v-row>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                <BarChartUtenti :countOfUsersGroupByMonths="countOfUsersGroupByMonths"/>
            </v-sheet>
        </v-col>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                <BarChartArtist :countOfArtistGroupByMonths="countOfArtistGroupByMonths"/>
            </v-sheet>
        </v-col>
    </v-row>
    <v-row>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                Tot Users: {{totUsers}}
            </v-sheet>
        </v-col>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                Tot Artists: {{totArtists}}
            </v-sheet>
        </v-col>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                Tot Albums: {{totAlbums}}
            </v-sheet>
        </v-col>
        <v-col>
            <v-sheet rounded elevation="3" class="mt-2 p-3">
                Tot Songs: {{totSongs}}
            </v-sheet>
        </v-col>
    </v-row>
    </v-container>
</template>

<script setup>
import BarChartUtenti from "@/Components/GraficoUtenti.vue";
import BarChartArtist from "@/Components/GraficoArtist.vue";

defineProps({
    'countOfUsersGroupByMonths': Object,
    'countOfArtistGroupByMonths': Object,
    'totUsers': Number,
    'totArtists': Number,
    'totAlbums': Number,
    'totSongs': Number,
})
</script>
