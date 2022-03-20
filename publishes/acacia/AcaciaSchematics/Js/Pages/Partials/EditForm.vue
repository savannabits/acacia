<template>
    <form v-if="model?.can?.update" @submit.prevent="updateModel">
        <div class="">
            <div class="my-2">
                <label>Table Name</label>
                <InputText class="block w-full" v-model="form.table_name" />
            </div>
            <div class="my-2">
                <label>Model Class</label>
                <InputText class="block w-full" v-model="form.model_class" />
            </div>
            <div class="my-2">
                <label>Controller Class</label>
                <InputText
                    class="block w-full"
                    v-model="form.controller_class"
                />
            </div>
            <div class="my-2">
                <label>Default Label Column</label>
                <InputText class="block w-full" v-model="form.default_label_column" />
            </div>
            <div class="my-2">
                <label>Route Name</label>
                <InputText class="block w-full" v-model="form.route_name" />
            </div>
            <div class="my-2">
                <label>Generated At</label>
                <AcaciaDatepicker
                    v-model="form.generated_at"
                    class="block w-full"
                    :data-disable-mobile="true"
                    data-date-format="Y-m-d H:i"
                    :data-enable-time="true"
                ></AcaciaDatepicker>
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
    name: "SchematicEditForm",
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
import AcaciaDatepicker from "@/Components/AcaciaDatepicker.vue";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
const form = useForm({ ...model });
const updateModel = async () => {
    form.put(route("acacia.g-panel.acacia-schematics.update", model), {
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
