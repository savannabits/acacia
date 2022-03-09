<template>
    <Head>
        <title>Customers</title>
    </Head>
    <Backend>
        <template #header>
            <h4 class="p-2 bg-indigo-500 text-indigo-50 border-b font-black text-2xl">Customers</h4>
        </template>
        <div class="p-2 mt-2">
            <PrimeDatatables
                class="p-datatable-sm"
                contextMenu
                v-model:contextMenuSelection="selectedRow"
                @row-contextmenu="showContextMenu"
                :row-hover="true"
                :refresh="refreshTime"
                :default-sort-desc="true"
                default-sort-field="id"
                state-key="customers-dt"
                :column-filters="{}"
                :searchable-columns="searchableColumns"
                :api-url="route('api.crm.customers.index')"
                :title="'List of Customers'"
            >
                <Column field="id" header="ID" :sortable="true"/>
                <Column field="first_name" header="First Name" :sortable="true"/>
                <Column field="middle_name" header="Middle Name" :sortable="true"/>
                <Column field="surname" header="Surname" :sortable="true"/>
                <Column field="email" header="Email" :sortable="true"/>
                <Column field="phone_number" header="Phone" :sortable="true"/>
                <Column field="active" header="Status" :sortable="true">
                    <template #body="props">
                        <Badge v-if="props.data.active" severity="success">Active</Badge>
                        <Badge v-else severity="danger">Inactive</Badge>
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
        </div>
    </Backend>
</template>

<script lang="ts">
import {defineComponent, nextTick, Ref, ref} from "vue";
import Backend from "@/Layouts/Backend.vue";
import {Head} from "@inertiajs/inertia-vue3";
import PrimeDatatables from "@/Components/PrimeDatatables.vue";
import Badge from "primevue/badge";
import Column from "primevue/column";
import axios from "axios";
import route from "ziggy-js";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import ContextMenu from "primevue/contextmenu";
import Button from "primevue/button";
import {Inertia} from "@inertiajs/inertia";

export default defineComponent({
    name: "Index",
    components: {
        PrimeDatatables,
        Backend,
        Head,
        Column,
        Badge,
        ContextMenu,
        Button
    },
    setup() {
        const selectedRow = ref(null) as Ref<any>;
        const optionsMenu = ref()  as Ref<any>;
        const contextMenu = ref();
        const options = ref([]) as Ref<any>;
        const confirm = useConfirm();
        const toast = useToast();
        const refreshTime = ref(null) as Ref<string|null>;
        const makeOptionsMenu = (row) => [
            {
                label: "Show",
                icon: "pi pi-eye",
                command: () => Inertia.get(route('crm.customers.show',row)),
                visible: () => row?.active,
            },
            {
                label: "Delete",
                icon: "pi pi-trash",
                command:() => {
                    confirm.require({
                        message: "Are you sure you want to delete this record?",
                        header: "Confirm Deletion",
                        accept: () =>deleteModel(row)
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
        const searchableColumns = ref(['first_name','middle_name','surname','email','phone_number']);
        const deleteModel = async function (row) {
            try {
                const res = await axios.delete(route('api.crm.customers.destroy',row as any));
                toast.add({severity: 'success', detail: res.data.message});
                refresh();
            }catch (e: any) {
                const msg = e?.response?.data?.message || e?.data?.message || e?.message || e || "Server error";
                toast.add({severity: 'error', detail: msg, summary: 'Server Error'});
            }
        }
        return {
            searchableColumns,
            optionsMenu,
            contextMenu,
            refreshTime,
            options,
            selectedRow,
            showContextMenu,
            refresh,
            toggleOptions,
        }
    }
})
</script>

<style scoped>

</style>
