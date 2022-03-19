<template>
    <dl class="gap-4" v-if="model?.can?.view">
        <AcaciaDd class="my-1">
            <template #dt>Id</template>
            {{ model?.id || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Title</template>
            {{ model?.title || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Name</template>
            {{ model?.name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Description</template>
            {{ model?.description || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Db Type</template>
            {{ model?.db_type || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Html Type</template>
            {{ model?.html_type || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Server Validation</template>
            {{ model?.server_validation || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Client Validation</template>
            {{ model?.client_validation || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Is Vue</template>
            <Tag
                v-if="model?.is_vue"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Has Options</template>
            <Tag
                v-if="model?.has_options"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Is Guarded</template>
            <Tag
                v-if="model?.is_guarded"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Is Hidden</template>
            <Tag
                v-if="model?.is_hidden"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>In Form</template>
            <Tag
                v-if="model?.in_form"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>In List</template>
            <Tag
                v-if="model?.in_list"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Options Route Name</template>
            {{ model?.options_route_name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Options Label Field</template>
            {{ model?.options_label_field || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Created At</template>
            <strong>{{
                model?.created_at
                    ? dayjs(model?.created_at).format("MMM DD, YYYY hh:mm A")
                    : "-"
            }}</strong>
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Updated At</template>
            <strong>{{
                model?.updated_at
                    ? dayjs(model?.updated_at).format("MMM DD, YYYY hh:mm A")
                    : "-"
            }}</strong>
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Schematic</template>
            {{ model?.schematic?.table_name || "-" }}
        </AcaciaDd>
    </dl>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "FieldShowForm",
});
</script>
<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import dayjs from "dayjs";
import Tag from "primevue/tag";
import { useToast } from "primevue/usetoast";
import Message from "primevue/message";
import AcaciaDd from "@/Components/AcaciaDd.vue";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import InputSwitch from "primevue/inputswitch";
import AcaciaRichSelect from "@/Components/AcaciaRichSelect.vue";
</script>

<style scoped></style>
