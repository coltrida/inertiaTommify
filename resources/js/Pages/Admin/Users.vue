<template>
    <Head title="Users" />
        <div class="text-h3">Users</div>

    <v-table theme="dark">
        <thead>
        <tr style="background: #9ca3af;">
            <th class="text-left text-black">
                Name
            </th>
            <th class="text-left text-black">
                Email
            </th>
            <th class="text-left text-black">
                Subscription
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in users.data"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.created }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <Component
                    v-for="link in users.links"
                    class="mx-2"
                    :class="{'text-gray-400': !link.url, 'font-bold': link.active}"
                >
                    <Link v-if="link.url" :href="link.url" v-html="link.label"></Link>
                    <span v-else v-html="link.label" class="text-gray-400"></span>
                </Component >

<!--                <v-pagination :length="users.links.length-2"></v-pagination>-->
            </td>
        </tr>
        </tbody>
    </v-table>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    users: Object
})

</script>

<style scoped>

</style>
