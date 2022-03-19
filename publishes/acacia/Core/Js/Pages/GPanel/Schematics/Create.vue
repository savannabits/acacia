<template>
    <div class="gap-x-2 flex flex-wrap">
        <Button icon="pi pi-plus" @click="launchExistingTableDialog" label="From Existing Table"/>
        <Button icon="pi pi-plus" label="From Scratch" :disabled="true"/>
    </div>
    <Dialog :modal="true" v-model:visible="showModal" header="Create Module" class="w-full max-w-[600px]">
        <form @submit.prevent="createSchematic">
            <div class="p-dialog-content">
                <div class="my-2">
                    <label>Select Table</label>
                    <AutoComplete class="block w-full" :autoHighlight="true" v-model="form.table" :suggestions="existingTables" @complete="searchTable($event)" :dropdown="true" field="name" forceSelection/>
                </div>
                <div class="my-2 flex items-center flex-wrap gap-x-2">
                    <label>Recreate if Exists</label>
                    <InputSwitch class="block" v-model="form.recreate"/>
                </div>

            </div>

            <div class="p-dialog-footer border-t-2">
                <Button type="submit" icon="pi pi-plus" label="Next"/>
            </div>
        </form>
    </Dialog>
</template>
<script lang="ts">
import Button from "primevue/button";
import {defineComponent} from "vue";
import Dialog from "primevue/dialog";
import AutoComplete from "primevue/autocomplete";
import InputSwitch from "primevue/inputswitch";

export default defineComponent({
    name: "SchematicsCreate",
    components: {
        Button,
        Dialog,
        AutoComplete,
        InputSwitch,
    }
})
</script>
<script setup lang="ts">
import {useForm, usePage} from "@inertiajs/inertia-vue3";
    import {computed, nextTick, ref} from "vue";
    import axios from "axios";
    import route from "ziggy-js";
    import Label from "@/Components/Label.vue";
    import {useToast} from "primevue/usetoast";
import {Inertia} from "@inertiajs/inertia";

    const form = useForm({
        "existingTable": false,
        "table": null,
        "recreate": false,
    })
    const flash = computed(() => usePage().props?.value?.flash);
    const existingTables = ref([]);
    const showModal = ref(false);
    const toast = useToast();
    const launchExistingTableDialog = async () => {
        form.existingTable = true;
        await nextTick();
        showModal.value = !showModal.value;
    }
    const searchTable = async (event) => {
        axios.get(route('api.acacia.g-panel.tables.search', {q: event.query.trim()})).then(r => {
            existingTables.value = r.data
        })
    }
    const createSchematic = async () => {
        form.post(route('acacia.g-panel.acacia-schematics.store'),{
            onSuccess: (res) => {
                toast.add({severity: 'success', summary: 'Success',detail: res.props.flash?.success, life: 3000});
                showModal.value = false;
            },
            onError: (errors) => {
                toast.add({severity: 'error', summary: 'Error', detail: errors?.message, life: 3000});
            },
            onFinish: (res) => {
                const payload = flash.value?.payload;
                if (payload) {
                    setTimeout(() => {
                        Inertia.visit(route('acacia.g-panel.acacia-schematics.edit',payload.id));
                    },500)
                }
            }
        })
    }
</script>

<style scoped>

</style>
