<template>
    <router-link :href="href">
        <Button class="p-button-text" icon="pi pi-arrow-left" label="Back"/>
    </router-link>
</template>

<script>
import Button from "primevue/button";

export default {
    name: "BackLink",
    props: {
        href: String,
    },
    components: {
        Button
    }
}
</script>

<style scoped>

</style>
