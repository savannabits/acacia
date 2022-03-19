<template>
    <Head>
        <title>Fields</title>
    </Head>
    <Backend>
        <template #header>
            <h4 class="font-black text-2xl px-1 md:px-4">Fields</h4>
        </template>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <div class="flex flex-wrap items-center justify-end gap-2">
                    <Button
                        v-if="$page.props.can?.create"
                        @click="createModal = true"
                        aria-label="New Comment"
                        label="New Field"
                        icon="pi pi-plus"
                    />
                </div>
                <PrimeDatatables
                    v-if="$page.props.can?.viewAny"
                    :apiUrl="apiUrl"
                    :columnFilters="{}"
                    :searchableColumns="searchableCols"
                    :stateKey="stateKey"
                    defaultSortField="id"
                    contextMenu
                    v-model:contextMenuSelection="selectedRow"
                    @row-contextmenu="showContextMenu"
                    :rowHover="true"
                    :refresh="refreshTime"
                >
                    <Column field="schematic.model_class" header="Model" :sortable="true" />
                    <Column field="name" header="DB Column" :sortable="true" />
                    <Column field="title" header="Title" :sortable="true" />
                    <Column field="db_type" header="DB Type" :sortable="true" />
                    <Column
                        field="html_type"
                        header="Html Type"
                        :sortable="true"
                    />
                    <Column field="in_form" header="In Form" :sortable="true">
                        <template #body="{ data }">
                            <Badge
                                severity="success"
                                v-if="data.in_form"
                                value="YES"
                            />
                            <Badge severity="danger" v-else value="NO" />
                        </template>
                    </Column>
                    <Column
                        field="created_at"
                        header="Created At"
                        :sortable="true"
                    >
                        <template #body="{ data }">
                            <span>{{
                                data.created_at
                                    ? dayjs(data.created_at).format(
                                          "MMM DD, YYYY hh:mm a"
                                      )
                                    : "-"
                            }}</span>
                        </template>
                    </Column>
                    <Column>
                        <template #body="props">
                            <Button
                                class=""
                                @click="toggleOptions($event, props.data)"
                                icon-pos="right"
                                :class="'p-button-text'"
                                :icon="'pi pi-ellipsis-v'"
                                :label="'Options'"
                            />
                        </template>
                    </Column>
                </PrimeDatatables>
                <Message v-else severity="error"
                    >You are not authorized to access this content</Message
                >
            </div>
        </div>
        <ContextMenu ref="contextMenu" :model="options" />
        <Dialog
            position="top"
            :maximizable="true"
            v-model:visible="createModal"
            :modal="true"
            :breakpoints="{
                '1600px': '50vw',
                '960px': '75vw',
                '540px': '100vw',
            }"
            :style="{ width: '35vw' }"
        >
            <template #header>
                <h4 class="font-black text-xl">New Field</h4>
            </template>
            <CreateForm @created="onCreated" v-if="createModal" />
            <template #footer>
                <Button
                    label="Open in a Page"
                    icon="pi pi-window"
                    @click="
                        $inertia.visit(route('acacia.g-panel.acacia-fields.create'))
                    "
                    class="p-button-text"
                />
                <Button
                    label="Close"
                    icon="pi pi-times"
                    @click="createModal = false"
                    class="p-button-text"
                />
            </template>
        </Dialog>
        <Dialog
            position="top"
            :maximizable="true"
            v-model:visible="showModal"
            :modal="true"
            :breakpoints="{
                '1600px': '50vw',
                '960px': '75vw',
                '540px': '100vw',
            }"
            :style="{ width: '35vw' }"
        >
            <template #header>
                <h4 class="font-black text-xl">Field Details</h4>
            </template>
            <ShowForm :model="currentModel" v-if="showModal && currentModel" />
            <template #footer>
                <Button
                    label="Open in a Page"
                    icon="pi pi-window"
                    @click="
                        $inertia.visit(
                            route('acacia.g-panel.acacia-fields.show', currentModel)
                        )
                    "
                    class="p-button-text"
                />
                <Button
                    label="Close"
                    icon="pi pi-times"
                    @click="(showModal = false), (currentModel = null)"
                    class="p-button-text"
                />
            </template>
        </Dialog>
        <Dialog
            position="top"
            :maximizable="true"
            v-model:visible="editModal"
            :modal="true"
            :breakpoints="{
                '1600px': '50vw',
                '960px': '75vw',
                '540px': '100vw',
            }"
            :style="{ width: '35vw' }"
        >
            <template #header>
                <h4 class="font-black text-xl">Edit Single Field</h4>
            </template>
            <EditForm
                :model="currentModel"
                @updated="onUpdated"
                v-if="editModal && currentModel"
            />
            <template #footer>
                <Button
                    label="Open in a Page"
                    icon="pi pi-window"
                    @click="
                        $inertia.visit(
                            route('acacia.g-panel.acacia-fields.edit', currentModel)
                        )
                    "
                    class="p-button-text"
                />
                <Button
                    label="Close"
                    icon="pi pi-times"
                    @click="(editModal = false), (currentModel = null)"
                    class="p-button-text"
                />
            </template>
        </Dialog>
    </Backend>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "FieldsIndex",
});
</script>
<script lang="ts" setup>
import Head from "@inertiajs/inertia-vue3";
import Backend from "@Acacia/Core/Js/Layouts/Backend.vue";
import PrimeDatatables from "@Acacia/Core/Js/Components/PrimeDatatables.vue";
import Column from "primevue/column";
import Button from "primevue/button";
import ContextMenu from "primevue/contextmenu";
import Badge from "primevue/badge";
import dayjs from "dayjs";
import route from "ziggy-js";
import { nextTick, Ref, ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import Dialog from "primevue/dialog";
import CreateForm from "./Partials/CreateForm.vue";
import EditForm from "./Partials/EditForm.vue";
import ShowForm from "./Partials/ShowForm.vue";
import Message from "primevue/message";

const apiUrl = route("api.v1.acacia-fields.dt");
const stateKey = "fields-dt";
const searchableCols = ref([
    "id",
    "title",
    "name",
    "description",
    "db_type",
    "html_type",
    "is_vue",
    "has_options",
    "is_guarded",
    "is_hidden",
    "in_form",
    "in_list",
    "options_route_name",
    "options_label_field",
    "created_at",
    "updated_at",
]);
const selectedRow = ref(null) as Ref<any>;
const contextMenu = ref();
const options = ref([]) as Ref<any>;
const confirm = useConfirm();
const toast = useToast();
const refreshTime = ref(null) as Ref<string | null>;
const createModal = ref(false);
const editModal = ref(false);
const showModal = ref(false);
const currentModel = ref(null) as Ref<any>;
const makeOptionsMenu = (row) => [
    {
        label: "Details",
        icon: "pi pi-eye",
        command: async () => {
            currentModel.value = null;
            await fetchModel(row);
            showModal.value = true;
        },
        visible: () => row?.can?.view,
    },
    {
        separator: true,
    },
    {
        label: "Edit",
        icon: "pi pi-pencil",
        command: async () => {
            currentModel.value = null;
            await fetchModel(row);
            editModal.value = true;
        },
        visible: () => row?.can?.update,
    },
    {
        label: "Delete",
        icon: "pi pi-trash",
        command: () => {
            confirm.require({
                message: "Are you sure you want to delete this record?",
                header: "Confirm Deletion",
                accept: () => deleteModel(row),
            });
        },
        visible: () => row?.can?.delete,
    },
];
const fetchModel = async (row) => {
    axios
        .get(route("api.v1.acacia-fields.show", row))
        .then((res) => {
            currentModel.value = res.data?.payload;
        })
        .catch((err) => {
            console.error(err);
            currentModel.value = null;
        });
};
const refresh = () => {
    refreshTime.value = new Date().toUTCString();
};
const toggleOptions = async (e, row) => {
    options.value = makeOptionsMenu(row);
    await nextTick();
    contextMenu.value.show(e);
};
const showContextMenu = async (e) => {
    options.value = makeOptionsMenu(e.data);
    await nextTick();
    contextMenu.value.show(e.originalEvent);
};
const deleteModel = async function (row) {
    try {
        const res = await axios.delete(
            route("api.v1.acacia-fields.destroy", row as any)
        );
        toast.add({
            severity: "success",
            detail: res.data.message,
            life: 3000,
        });
        refresh();
    } catch (e: any) {
        console.log(e);
        const msg =
            e?.response?.data?.message ||
            e?.data?.message ||
            e?.message ||
            e ||
            "Server error";
        toast.add({
            severity: "error",
            detail: msg,
            summary: "Server Error",
            life: 10000,
        });
    }
};
const onCreated = (e) => {
    // console.log(e.payload);
    createModal.value = false;
    refresh();
};
const onUpdated = (e) => {
    // console.log(e.payload);
    editModal.value = false;
    refresh();
};
</script>

<style scoped></style>
