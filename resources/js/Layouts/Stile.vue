<template>
    <Menu />
        <v-container>
            <div >
                <slot/>
<!--                <audio style="display: none" src="storage/songs/1.mp3" controls></audio>-->
            </div>

        </v-container>
</template>

<script setup>
import Menu from "@/Components/Menu.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<style>

</style>
