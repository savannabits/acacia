<template>
    <Head :title="`User Details`"> </Head>
    <Backend>
        <template #header>
            <div class="flex items-center flex-wrap gap-x-2">
                <BackLink :href="route('acacia.auth.users.index')" />
                <h4 class="font-bold text-xl">User Details</h4>
            </div>
        </template>
        <div
            class="mx-auto container max-w-4xl flex items-center justify-center mt-4"
        >
            <div class="rounded w-full p-2 bg-white">
                <ShowForm :model="model" @updated="onUpdated" />
            </div>
        </div>
    </Backend>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "ShowUser",
});
</script>
<script setup lang="ts">
import { computed, nextTick, Ref, ref } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import Backend from "@Acacia/Core/Js/Layouts/Backend.vue";
import BackLink from "@Acacia/Core/Js/Components/BackLink.vue";
import route from "ziggy-js";
import { Inertia } from "@inertiajs/inertia";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import ShowForm from "@Acacia/Users/Js/Pages/Partials/ShowForm.vue";
const model = computed(() => usePage().props.value?.model);

const confirm = useConfirm();
const toast = useToast();

const onUpdated = (e) => {
    // console.log(e.payload);
    Inertia.visit(route("acacia.auth.users.index"));
};
</script>
<style scoped></style>
