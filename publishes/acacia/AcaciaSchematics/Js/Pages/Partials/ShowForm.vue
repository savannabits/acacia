<template>
    <dl class="gap-4" v-if="model?.can?.view">
        <AcaciaDd class="my-1">
            <template #dt>Id</template>
            {{ model?.id || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Table Name</template>
            {{ model?.table_name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Model Class</template>
            {{ model?.model_class || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Controller Class</template>
            {{ model?.controller_class || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Default Label Column</template>
            {{ model?.default_label_column || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Route Name</template>
            {{ model?.route_name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Generated At</template>
            <strong>{{
                model?.generated_at
                    ? dayjs(model?.generated_at).format("MMM DD, YYYY hh:mm A")
                    : "-"
            }}</strong>
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
    </dl>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "SchematicShowForm",
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
import AcaciaDatepicker from "@/Components/AcaciaDatepicker.vue";
</script>

<style scoped></style>
