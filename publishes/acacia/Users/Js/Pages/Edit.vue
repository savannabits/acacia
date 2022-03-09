<template>
    <Head :title="`Edit User`"> </Head>
    <Backend>
        <template #header>
            <div class="flex items-center flex-wrap gap-x-2">
                <BackLink :href="route('acacia.backend.users.index')" />
                <h4 class="font-bold text-xl">Edit User</h4>
            </div>
        </template>
        <div
            class="mx-auto container max-w-4xl flex items-center justify-center mt-4"
        >
            <div class="rounded w-full p-2 bg-white">Edit Form goes here</div>
        </div>
    </Backend>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "EditUser",
});
</script>
<script setup lang="ts">
import { computed, nextTick, Ref, ref } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import Backend from "@Acacia/Core/Js/Layouts/Backend.vue";
import BackLink from "@Acacia/Core/Js/Components/BackLink.vue";
import route from "ziggy-js";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const model = computed(() => usePage().props.value?.model);
const form = useForm({ ...model.value });

const confirm = useConfirm();
const toast = useToast();
</script>
<style scoped></style>
