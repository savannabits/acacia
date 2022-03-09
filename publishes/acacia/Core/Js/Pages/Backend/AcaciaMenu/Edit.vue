<template>
    <Head>
        <title>Edit {{model?.title}}</title>
    </Head>
    <Backend>
        <template #header>
            <div class="flex items-center">
                <BackLink :href="route('acacia.backend.acacia-menu.index')"/>
                <h4 class="font-black px-3 mx-2 text-2xl">Edit {{model?.title}}</h4>
            </div>
        </template>
    </Backend>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: "Edit",
})
</script>
<script setup lang="ts">
    import {computed} from "vue";
    import {usePage} from "@inertiajs/inertia-vue3";
    import Backend from "@/Layouts/Backend.vue";
    import BackLink from "@/Components/BackLink.vue";

    const model = computed(() => usePage().props.value?.model);
</script>

<style scoped>

</style>
