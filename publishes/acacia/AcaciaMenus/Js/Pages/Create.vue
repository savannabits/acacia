<template>
    <Head :title="`New Menu`"> </Head>
    <Backend>
        <template #header>
            <div class="flex items-center flex-wrap gap-x-2">
                <BackLink :href="route('acacia.g-panel.acacia-menus.index')" />
                <h4 class="font-bold text-xl">New Menu</h4>
            </div>
        </template>
        <div
            class="mx-auto container max-w-4xl flex items-center justify-center mt-4"
        >
            <div class="rounded w-full p-2 bg-white">
                <CreateForm @created="onCreated" />
            </div>
        </div>
    </Backend>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "CreateMenu",
});
</script>
<script setup lang="ts">
import { computed, nextTick, Ref, ref } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import Backend from "@Acacia/Core/Js/Layouts/Backend.vue";
import BackLink from "@Acacia/Core/Js/Components/BackLink.vue";
import route from "ziggy-js";
import { Inertia } from "@inertiajs/inertia";
import CreateForm from "./Partials/CreateForm.vue";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const form = useForm({});

const confirm = useConfirm();
const toast = useToast();
const onCreated = (e) => {
    // console.log(e.payload);
    Inertia.visit(route("acacia.g-panel.acacia-menus.index"));
};
</script>
<style scoped></style>
