<template>
    <TabView v-if="model?.can?.view">
        <TabPanel header="Basic Info">
            <dl class="gap-4">
                <AcaciaDd class="my-1">
                    <template #dt>Id</template>
                    {{ model?.id || "-" }}
                </AcaciaDd>
                <AcaciaDd class="my-1">
                    <template #dt>Name</template>
                    {{ model?.name || "-" }}
                </AcaciaDd>
                <AcaciaDd class="my-1">
                    <template #dt>Guard Name</template>
                    {{ model?.guard_name || "-" }}
                </AcaciaDd>
                <AcaciaDd class="my-1">
                    <template #dt>Created At</template>
                    <strong>{{
                        model?.created_at
                            ? dayjs(model?.created_at).format(
                                  "MMM DD, YYYY hh:mm A"
                              )
                            : "-"
                    }}</strong>
                </AcaciaDd>
                <AcaciaDd class="my-1">
                    <template #dt>Updated At</template>
                    <strong>{{
                        model?.updated_at
                            ? dayjs(model?.updated_at).format(
                                  "MMM DD, YYYY hh:mm A"
                              )
                            : "-"
                    }}</strong>
                </AcaciaDd>
            </dl>
        </TabPanel>
        <TabPanel header="Permissions"> Assigned Roles </TabPanel>
    </TabView>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "RoleShowForm",
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
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import InputText from "primevue/inputtext";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
</script>

<style scoped></style>
