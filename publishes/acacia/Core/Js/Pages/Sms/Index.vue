<template>
    <Backend>
        <template #header>
            <h4 class="font-black text-2xl">SMS Module</h4>
        </template>
        The SMS Module
    </Backend>
</template>

<script lang="ts">
import Backend from "@/Layouts/Backend.vue";
import {defineComponent} from "vue";
export default defineComponent({
    name: "Index",
    components: {Backend}
})
</script>

<style scoped>

</style>
