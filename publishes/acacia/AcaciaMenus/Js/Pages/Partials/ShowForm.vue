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
            <template #dt>Icon</template>
            {{ model?.icon || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Route</template>
            {{ model?.route || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Url</template>
            {{ model?.url || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Active</template>
            <Tag
                v-if="model?.active"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Active Pattern</template>
            {{ model?.active_pattern || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Position</template>
            {{ model?.position || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Permission Name</template>
            {{ model?.permission_name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Module Name</template>
            {{ model?.module_name || "-" }}
        </AcaciaDd>
        <AcaciaDd class="my-1">
            <template #dt>Description</template>
            {{ model?.description || "-" }}
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
            <template #dt>Parent</template>
            {{ model?.parent?.title || "-" }}
        </AcaciaDd>
    </dl>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "MenuShowForm",
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
import AcaciaRichSelect from "@/Components/AcaciaRichSelect.vue";
</script>

<style scoped></style>
