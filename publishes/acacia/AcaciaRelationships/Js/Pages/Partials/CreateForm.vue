<template>
    <form v-if="$page.props.can?.create" @submit.prevent="createModel">
        <div class="">
            <div class="my-2">
                <label>Type</label>
                <InputText class="block w-full" v-model="form.type" />
            </div>
            <div class="my-2">
                <label>Method</label>
                <InputText class="block w-full" v-model="form.method" />
            </div>
            <div class="my-2">
                <label>Related Key</label>
                <InputText class="block w-full" v-model="form.related_key" />
            </div>
            <div class="my-2">
                <label>Related Table</label>
                <InputText class="block w-full" v-model="form.related_table" />
            </div>
            <div class="my-2">
                <label>Local Key</label>
                <InputText class="block w-full" v-model="form.local_key" />
            </div>
            <div class="my-2">
                <label>Label Column</label>
                <InputText class="block w-full" v-model="form.label_column" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Is Recursive</label>
                <InputSwitch class="block" v-model="form.is_recursive" />
            </div>
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>Is Morph</label>
                <InputSwitch class="block" v-model="form.is_morph" />
            </div>
            <div class="my-2">
                <label>Morph Type Column</label>
                <InputText
                    class="block w-full"
                    v-model="form.morph_type_column"
                />
            </div>
            <div class="my-2">
                <label>Morph Id Column</label>
                <InputText
                    class="block w-full"
                    v-model="form.morph_id_column"
                />
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
            <div class="my-2 flex items-center flex-wrap gap-x-2">
                <label>In List</label>
                <InputSwitch class="block" v-model="form.in_list" />
            </div>
            <div class="my-2">
                <label>Related</label>
                <AcaciaRichSelect
                    v-model="form.related"
                    :class="`block w-full`"
                    :api-url="route('api.v1.acacia-schematics.index')"
                    label="table_name"
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
    name: "RelationshipCreate",
});
</script>
<script setup lang="ts">
import Button from "primevue/button";
import Dialog from "primevue/dialog";
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
import Textarea from "primevue/textarea";
import AcaciaRichSelect from "@/Components/AcaciaRichSelect.vue";
const emit = defineEmits(["created", "error"]);
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const form = useForm({
    type: null,
    method: null,
    related_key: null,
    related_table: null,
    local_key: null,
    label_column: null,
    is_recursive: false,
    is_morph: false,
    morph_type_column: null,
    morph_id_column: null,
    server_validation: null,
    in_list: false,
    related: null,
    schematic: null,
});
const createModel = async () => {
    form.post(route("acacia.g-panel.acacia-relationships.store"), {
        onSuccess: (res) => {
            const fl = res.props.flash as any;
            toast.add({
                severity: "success",
                summary: "Success",
                detail: fl?.success,
                life: 2000,
            });
            const payload = flash.value?.payload;
            emit("created", { payload: payload });
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
