<template>
    <Head>
        <title>My Profile</title>
    </Head>
    <Authenticated>
        <template #header>My Profile</template>
        Here is your profile
    </Authenticated>
</template>

<script lang="ts">
import Authenticated from "@/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
export default {
    name: "Profile",
    components: {Authenticated, Head}
}
</script>

<style scoped>

</style>
