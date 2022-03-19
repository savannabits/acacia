<template>
    <PrimeDatatables
        :api-url="apiUrl"
        :column-filters="{}"
        :searchable-columns="searchableCols"
        :state-key="stateKey"
        contextMenu
        v-model:contextMenuSelection="selectedRow"
        @row-contextmenu="showContextMenu"
        :row-hover="true"
        :refresh="refreshTime"
    >
        <Column field="model_class" header="Model" :sortable="true"/>
        <Column field="table_name" header="Table" :sortable="true"/>
        <Column field="generated_at" header="Status" :sortable="true">
            <template #body="{data}">
                <Badge severity="success" value="Generated" v-if="data.generated_at"/>
                <Badge severity="danger" value="Pending" v-else/>
            </template>
        </Column>
        <Column>
            <template #body="props">
                <Button class=""
                        @click="toggleOptions($event, props.data)"
                        icon-pos="right"
                        :class="'p-button-text'"
                        :icon="'pi pi-ellipsis-v'"
                        :label="'Actions'"
                />
            </template>
        </Column>
    </PrimeDatatables>
    <ContextMenu ref="contextMenu" :model="options"/>
</template>

<script lang="ts">
import {defineComponent} from "vue";
export default defineComponent({
    name: "Schematics",
    props: {}
})
</script>
<script lang="ts" setup>
import PrimeDatatables from "@/Components/PrimeDatatables.vue";
import Column from "primevue/column";
import Button from "primevue/button";
import ContextMenu from "primevue/contextmenu";
import Badge from "primevue/badge";
import route from "ziggy-js"
import {nextTick, Ref, ref} from "vue";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {Inertia} from "@inertiajs/inertia";
import axios from "axios";

const apiUrl = route('api.acacia.schematics.dt');
const stateKey = 'schematics-dt'
const searchableCols = ref(['id', 'table_name', 'model_class','controller_class','route_name']);
const selectedRow = ref(null) as Ref<any>;
const contextMenu = ref();
const options = ref([]) as Ref<any>;
const confirm = useConfirm();
const toast = useToast();
const refreshTime = ref(null) as Ref<string | null>;
const makeOptionsMenu = (row) => [
    {
        label: "Manage",
        icon: "pi pi-pencil",
        command: () => Inertia.get(route('acacia.g-panel.acacia-schematics.edit', row)),
        visible: () => true,
    },
    {
        label: "Delete",
        icon: "pi pi-trash",
        command: () => {
            confirm.require({
                message: "Are you sure you want to delete this record?",
                header: "Confirm Deletion",
                accept: () => deleteModel(row)
            })
        },
        visible: () => !!row.generated_at,
    },
];
const refresh = () => {
    refreshTime.value = new Date().toUTCString();
}
const toggleOptions = async (e, row) => {
    options.value = makeOptionsMenu(row);
    await nextTick();
    contextMenu.value.show(e);
}
const showContextMenu = async (e) => {
    options.value = makeOptionsMenu(e.data);
    await nextTick();
    contextMenu.value.show(e.originalEvent);
}
const deleteModel = async function (row) {
    try {
        const res = await axios.delete(route('api.acacia.schematics.destroy', row as any));
        toast.add({severity: 'success', detail: res.data.message});
        refresh();
    } catch (e: any) {
        const msg = e?.response?.data?.message || e?.data?.message || e?.message || e || "Server error";
        toast.add({severity: 'error', detail: msg, summary: 'Server Error'});
    }
}
</script>

<style scoped>

</style>
