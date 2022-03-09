<template>
    <Authenticated>
        <template #header>
            SMS
        </template>
        <Link :href="route('app.sms.file-upload')">
            <Button label="Send SMS via File Upload"/>
        </Link>
    </Authenticated>
</template>

<script lang="ts">
import Authenticated from "@/Layouts/Authenticated.vue";
import { Link } from "@inertiajs/inertia-vue3";
import {defineComponent} from "vue";
import Button from "primevue/button";

export default defineComponent({
    name: "Index",
    components: {Authenticated, Link, Button}
})
</script>

<style scoped>

</style>
