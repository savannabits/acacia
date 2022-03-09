<template>
    <PrimeDatatables
        :api-url="route('api.acacia.schematics.schematic.relationships',model.id)"
        :column-filters="{}"
        :searchable-columns="searchableCols"
        state-key="schematic-fields-dt"
        contextMenu
        v-model:contextMenuSelection="selectedRow"
        @row-contextmenu="showContextMenu"
        :row-hover="true"
        :refresh="refreshTime"
    >
        <Column field="method" header="Method" :sortable="true">
            <template #body="{data}">{{data.method}}()</template>
        </Column>
        <Column field="type" header="Relationship Type" :sortable="true"/>
        <Column field="related_table" header="Related Table" :sortable="true"/>
        <Column field="local_key" header="Local Key" :sortable="true"/>
        <Column field="related_key" header="Related Key" :sortable="true"/>
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
    name: "Relationships",
    props: {
        model: {required: true}
    }
})
</script>
<script lang="ts" setup>
import PrimeDatatables from "@/Components/PrimeDatatables.vue";
import Column from "primevue/column";
import Button from "primevue/button";
import ContextMenu from "primevue/contextmenu";
import route from "ziggy-js"
import {nextTick, Ref, ref} from "vue";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {Inertia} from "@inertiajs/inertia";
import axios from "axios";

const searchableCols = ref(['id', 'type', 'method', 'related_key']);
const selectedRow = ref(null) as Ref<any>;
const contextMenu = ref();
const options = ref([]) as Ref<any>;
const confirm = useConfirm();
const toast = useToast();
const refreshTime = ref(null) as Ref<string | null>;
const makeOptionsMenu = (row) => [
    {
        label: "Edit",
        icon: "pi pi-pencil",
        command: () => Inertia.get(route('sms.sending-sessions.show', row)),
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
        visible: () => true,
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
        const res = await axios.delete(route('api.sms.sending-sessions.destroy', row as any));
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
