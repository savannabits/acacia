<template>
    <Head>
        <title>Admin Backend</title>
    </Head>
    <Backend>
        <template #header>
            <WelcomeBanner/>
        </template>
        <div class="mx-2">
            Here is the backend
        </div>
    </Backend>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Backend from "@/Layouts/Backend.vue";
import WelcomeBanner from "@/partials/dashboard/WelcomeBanner.vue";
import DashboardAvatars from "@/partials/dashboard/DashboardAvatars.vue";
import {Head} from "@inertiajs/inertia-vue3";

export default defineComponent({
    name: "Index",
    components: {DashboardAvatars, WelcomeBanner, Backend, Head}
})
</script>

<style scoped>

</style>
