<template>
    <Head :title="`Manage Schematics: ${model?.table_name}`">
    </Head>
    <Backend>
        <template #header>
            <div class="flex items-center flex-wrap gap-x-2">
                <BackLink :href="route('acacia.g-panel.index')"/>
                <h4 class="font-bold text-xl">Manage <strong>{{ model?.table_name }}</strong></h4>
            </div>
        </template>
        <div class="mx-auto container max-w-4xl flex items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <TabView ref="manageTabs" v-model:activeIndex="activeTab">
                    <TabPanel lazy header="General Info">
                        <div class="min-h-full flex items-center justify-center">
                            <div class="container max-w-3xl">
                                <div class="my-2">
                                    <label>Table</label>
                                    <span class="p-inputtext p-disabled block font-bold w-full">{{ form.table_name }}</span>
                                </div>
                                <div class="my-2">
                                    <label>Model</label>
                                    <InputText class="block w-full" v-model="form.model_class"/>
                                </div>
                                <div class="my-2">
                                    <label>Controller</label>
                                    <InputText class="block w-full" v-model="form.controller_class"/>
                                </div>
                                <div class="my-2">
                                    <label>Route Name</label>
                                    <InputText class="block w-full" v-model="form.route_name"/>
                                </div>
                                <div class="p-dialog-footer flex items-center justify-end">
                                    <Button label="Fields" icon="pi pi-arrow-right" @click="activeTab = 1" icon-pos="right"/>
                                </div>
                            </div>
                        </div>
                    </TabPanel>
                    <TabPanel lazy header="Fields">
                        <div class="min-h-full flex items-center justify-center">
                            <div class="container max-w-3xl">
                                <PrimeDatatables
                                    :api-url="route('api.acacia.schematics.schematic.fields',model.id)"
                                    :column-filters="{}"
                                    :searchable-columns="searchableCols"
                                    state-key="schematic-fields-dt"
                                    contextMenu
                                    v-model:contextMenuSelection="selectedRow"
                                    @row-contextmenu="showContextMenu"
                                    :row-hover="true"
                                    :refresh="refreshTime"
                                >
                                    <Column field="name" header="DB Column" :sortable="true"/>
                                    <Column field="title" header="Title"/>
                                    <Column field="db_type" header="DB Type"/>
                                    <Column field="html_type" header="HTML Type"/>
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
                            </div>
                        </div>
                    </TabPanel>
                    <TabPanel lazy header="Relationships">
                        <div class="min-h-full flex items-center justify-center">
                            <div class="container max-w-3xl">
                                <Relationships :model="model"/>
                            </div>
                        </div>
                    </TabPanel>
                </TabView>
            </div>
        </div>
    </Backend>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Backend from "@/Layouts/Backend.vue";
import TabPanel from "primevue/tabpanel";
import TabView from "primevue/tabview";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Column from "primevue/column";
import ContextMenu from "primevue/contextmenu";

export default defineComponent({
    name: "SchematicsManage",
    components: {Backend, TabView, TabPanel, InputText, Button, Column, ContextMenu},
})
</script>
<script setup lang="ts">
import {computed, nextTick, Ref, ref} from "vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import Label from "@/Components/Label.vue";
import BackLink from "@/Components/BackLink.vue";
import PrimeDatatables from "@/Components/PrimeDatatables.vue";
import axios from "axios";
import route from "ziggy-js";
import {Inertia} from "@inertiajs/inertia";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import Relationships from "@/Pages/GPanel/Schematics/components/Relationships.vue";

const searchableCols = ref(['id', 'name', 'title', 'db_type', 'html_type']);
const activeTab = ref(0);
const model = computed(() => usePage().props.value?.model);
const form = useForm({...model.value})

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
