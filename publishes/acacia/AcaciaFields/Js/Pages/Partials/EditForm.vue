<template>
    <form v-if="model?.can?.update" @submit.prevent="updateModel">
        <div class="">
            <div class="my-2">
                <label>Title</label>
                <InputText class="block w-full" v-model="form.title" />
            </div>
            <div class="my-2">
                <label>Name</label>
                <InputText class="block w-full" v-model="form.name" />
            </div>
            <div class="my-2">
                <label>Description</label>
                <InputText class="block w-full" v-model="form.description" />
            </div>
            <div class="my-2">
                <label>Db Type</label>
                <InputText class="block w-full" v-model="form.db_type" />
            </div>
            <div class="my-2">
                <label>Html Type</label>
                <InputText class="block w-full" v-model="form.html_type" />
            </div>
            <div class="my-2">
                <label>Server Validation</label>
                <Textarea
                    v-model="form.server_validation"
                    class="block w-full"
                    :autoResize="true"
                    rows="5"
                    cols="30"
                ></Textarea>
            </div>
            <div class="my-2">
                <label>Client Validation</label>
                <Textarea
                    v-model="form.client_validation"
                    class="block w-full"
                    :autoResize="true"
                    rows="5"
                    cols="30"
                ></Textarea>
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Is Vue</label>
                <InputSwitch class="block" v-model="form.is_vue" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Has Options</label>
                <InputSwitch class="block" v-model="form.has_options" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Is Guarded</label>
                <InputSwitch class="block" v-model="form.is_guarded" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Is Hidden</label>
                <InputSwitch class="block" v-model="form.is_hidden" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>In Form</label>
                <InputSwitch class="block" v-model="form.in_form" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>In List</label>
                <InputSwitch class="block" v-model="form.in_list" />
            </div>
            <div class="my-2">
                <label>Options Route Name</label>
                <InputText
                    class="block w-full"
                    v-model="form.options_route_name"
                />
            </div>
            <div class="my-2">
                <label>Options Label Field</label>
                <InputText
                    class="block w-full"
                    v-model="form.options_label_field"
                />
            </div>
            <div class="my-2">
                <label>Schematic</label>
                <AcaciaRichSelect
                    v-model="form.schematic"
                    :class="`block w-full`"
                    :api-url="route('api.v1.acacia-schematics.index')"
                    label="table_name"
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
    name: "FieldEditForm",
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
import Textarea from "primevue/textarea";
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
    form.put(route("acacia.g-panel.acacia-fields.update", model), {
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
