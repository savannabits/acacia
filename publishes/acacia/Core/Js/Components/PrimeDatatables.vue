<template>
    <DataTable
        class="p-datatable-sm"
        :value="records"
        :lazy="true"
        :auto-layout="true"
        :paginator="true"
        :rows="10"
        v-model:filters="filters"
        ref="dt"
        :loading="loading"
        :total-records="totalRecords"
        :globalFilterFields="searchableColumns"
        @page="onPage"
        @sort="onSort"
        @filter="onFilter"
        filter-display="row"
        responsive-layout="stack"
        breakpoint="960px"
        :state-key="stateKey"
        state-storage="session"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} records"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,15,25,50]"
    >
        <template #loading>
            Loading...
        </template>
        <template #header>
            <div class="flex flex-wrap gap-2 justify-between items-center">
                <div>
                    <div class="flex items-center gap-2">
                        <Button @click="loadLazyData" class="p-button-text p-button-plain" icon="pi pi-refresh"/>
                        <slot name="header">
                            <h5 class="font-semibold">{{title}}</h5>
                        </slot>
                    </div>
                </div>
                <div class="p-input-icon-left max-w-[360px]">
                    <i v-if="!filters['global'].value" class="pi pi-search" />
                    <i v-else v-if="filters['global'].value" class="pi pi-times" @click="filters['global'].value = null; onFilter()"></i>
                    <InputText v-model="filters['global'].value" @input="debounce(onFilter,500)" placeholder="Keyword Search" />
                </div>
            </div>
        </template>
        <template #empty>
            <p class="text-center">No records found.</p>
        </template>
        <slot></slot>
    </DataTable>
</template>

<script lang="ts">
import {defineComponent, onMounted, Ref, ref, toRef, watch} from "vue";
import {FilterMatchMode} from "primevue/api";
import {useDebounce} from "@/composables/debounce";
import axios from "axios";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Button from "primevue/button";

export default defineComponent({
    name: "PrimeDatatables",
    components: {
        DataTable,
        InputText,
        Button,
    },
    props: {
        apiUrl: String,
        title: String,
        refresh: String,
        defaultSortField: String,
        defaultSortDesc: {
            type: Boolean,
            default: true,
        },
        searchableColumns: {
            type: Array,
            default: [],
        },
        columnFilters: {
            required: true,
            type: Object,
            default: {}
        },
        stateKey: String,
    },
    setup(props) {
        onMounted(async () => {
            // loading.value = true;
            // console.log(filters.value);
            lazyParams.value = JSON.parse(sessionStorage.getItem(stateKey.value as string) as string);
            if (!lazyParams.value) {
                lazyParams.value = {
                    first: 0,
                    filters: filters.value,
                    rows: 10,
                }
            }
            lazyParams.value.page = Math.fround(parseInt(lazyParams.value.first)/parseInt(lazyParams.value.rows || 10))
            console.log(lazyParams.value);
            await loadLazyData();
        })

        const refresh = toRef(props, "refresh");
        watch(refresh,(val) => {
            loadLazyData();
        });

        const dt = ref();
        const debounce = useDebounce();
        const loading = ref(false);
        const totalRecords = ref(0);
        const records = ref();
        const filtersProp = toRef(props,"columnFilters");
        const filters = ref({});
        filters.value = {
            ...filtersProp.value,
            global: {value: '', matchMode: FilterMatchMode.CONTAINS}
        }
        const searchableColumns = toRef(props, "searchableColumns") as Ref<Array<string>>
        const lazyParams: Ref<any> = ref({});
        const apiUrl = toRef(props, "apiUrl") as Ref<string>;
        const stateKey = toRef(props,'stateKey');
        const loadLazyData = async () => {
            loading.value = true;
            lazyParams.value.filters = filters.value;
            if (!lazyParams.value.sortField) {
                lazyParams.value.sortField = toRef(props, "defaultSortField").value;
            }
            if (![-1,1].includes(lazyParams.value.sortOrder)) {
                lazyParams.value.sortOrder = toRef(props, "defaultSortDesc").value ? -1 : 1;
            }
            try {
                const res = await axios.get(apiUrl.value,{
                    params: {
                        dt_params: JSON.stringify(lazyParams.value),
                        searchable_columns: JSON.stringify(searchableColumns.value),
                    },
                });

                records.value = res.data.data ?? [];
                totalRecords.value = res.data.total;
                loading.value = false;
            } catch (e) {
                records.value = [];
                totalRecords.value = 0;
                loading.value = false;
            }
        };

        const onPage = (event) => {
            lazyParams.value = event;
            // lazyParams.value.filters = filters.value;
            loadLazyData();
        };
        const onSort = (event) => {
            lazyParams.value = event;
            loadLazyData();
        };
        const onFilter = () => {
            // lazyParams.value.filters = filters.value;
            //Reset pagination first
            // lazyParams.value.originalEvent = {first: 0, page: 0}
            // onPage(lazyParams.value);
            loadLazyData();
        }

        return {
            dt,
            loading,
            totalRecords,
            records,
            filters,
            lazyParams,
            loadLazyData,
            onPage,
            onSort,
            onFilter,
            debounce
        }
    }
});
</script>

<style scoped>

</style>
