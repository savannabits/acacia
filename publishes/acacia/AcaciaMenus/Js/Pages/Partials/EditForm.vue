<template>
    <form v-if="model?.can?.update" @submit.prevent="updateModel">
        <div class="">
            <div class="my-2">
                <label>Title</label>
                <InputText class="block w-full" v-model="form.title" />
            </div>
            <div class="my-2">
                <label>Icon</label>
                <InputText class="block w-full" v-model="form.icon" />
            </div>
            <div class="my-2">
                <label>Route</label>
                <InputText class="block w-full" v-model="form.route" />
            </div>
            <div class="my-2">
                <label>Url</label>
                <InputText class="block w-full" v-model="form.url" />
            </div>
            <div class="my-2">
                <label>Active Pattern</label>
                <InputText class="block w-full" v-model="form.active_pattern" />
            </div>
            <div class="my-2">
                <label>Position</label>
                <InputText class="block w-full" v-model="form.position" />
            </div>
            <div class="my-2">
                <label>Permission Name</label>
                <InputText
                    class="block w-full"
                    v-model="form.permission_name"
                />
            </div>
            <div class="my-2">
                <label>Module Name</label>
                <InputText class="block w-full" v-model="form.module_name" />
            </div>
            <div class="my-2">
                <label>Description</label>
                <InputText class="block w-full" v-model="form.description" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Active</label>
                <InputSwitch class="block" v-model="form.active" />
            </div>
            <div class="my-2">
                <label>Parent</label>
                <AcaciaRichSelect
                    v-model="form.parent"
                    :class="`block w-full`"
                    :api-url="route('api.v1.acacia-menus.index')"
                    label="title"
                />
            </div>
        </div>

        <div class="text-right min-w-[300px] pt-2 border-t-2">
            <Button type="submit" icon="pi pi-check" label="Save" />
        </div>
    </form>
    <Message v-else severity="error"
        >You are not authorized to perform this action</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "MenuEditForm",
});
</script>
<script setup lang="ts">
import Button from "primevue/button";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import axios from "axios";
import route from "ziggy-js";
import Label from "@/Components/Label.vue";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
import Message from "primevue/message";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import AcaciaRichSelect from "@/Components/AcaciaRichSelect.vue";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
const form = useForm({ ...model });
const updateModel = async () => {
    form.put(route("acacia.g-panel.acacia-menus.update", model), {
        onSuccess: (res) => {
            const fl = res.props.flash as any;
            toast.add({
                severity: "success",
                summary: "Success",
                detail: fl?.success,
                life: 2000,
            });
            const payload = flash.value?.payload;
            emit("updated", { payload: payload });
        },
        onError: (errors) => {
            let msg =
                flash.value?.error ||
                errors?.message ||
                errors?.error ||
                errors ||
                "A server error occurred.";
            toast.add({
                severity: "error",
                summary: "Error",
                detail: msg,
                life: 3000,
            });
            const payload = flash.value?.payload;
            emit("error", { payload: payload, message: msg });
        },
        onFinish: (res) => {},
    });
};
</script>

<style scoped></style>
