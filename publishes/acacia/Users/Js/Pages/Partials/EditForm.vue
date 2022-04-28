<template>
    <TabView v-if="model?.can?.view">
        <TabPanel header="Basic Info">
            <form v-if="model?.can?.update" @submit.prevent="updateModel">
                <div class="">
                    <div class="my-2">
                        <label>Name</label>
                        <InputText class="block w-full" v-model="form.name" />
                    </div>
                    <div class="my-2">
                        <label>Email</label>
                        <InputText class="block w-full" v-model="form.email" />
                    </div>
                    <div class="my-2">
                        <label>Email Verified At</label>
                        <AcaciaDatepicker
                            v-model="form.email_verified_at"
                            class="block w-full"
                            :data-disable-mobile="true"
                            data-date-format="Y-m-d H:i"
                            :data-enable-time="true"
                        ></AcaciaDatepicker>
                    </div>
                    <div class="my-2">
                        <label>Password</label>
                        <Password
                            class="block w-full"
                            inputClass="w-full block"
                            v-model="form.password"
                            toggleMask
                        >
                            <template #footer>
                                <Divider />
                                <p class="mt-2 font-bold">
                                    Password MUST have:
                                </p>
                                <ul
                                    class="pl-2 ml-2 mt-0"
                                    style="line-height: 1.5"
                                >
                                    <li>At least one lowercase</li>
                                    <li>At least one uppercase</li>
                                    <li>At least one numeric</li>
                                    <li>Minimum 8 characters</li>
                                </ul>
                            </template>
                        </Password>
                    </div>
                    <div class="my-2">
                        <label>Repeat Password</label>
                        <Password
                            class="block w-full"
                            inputClass="w-full block"
                            v-model="form.password_confirmation"
                            toggleMask
                        ></Password>
                    </div>

                    <div class="my-2">
                        <label>Remember Token</label>
                        <InputText
                            class="block w-full"
                            v-model="form.remember_token"
                        />
                    </div>
                </div>

                <div class="text-right min-w-[300px] pt-2 border-t-2">
                    <Button type="submit" icon="pi pi-check" label="Save" />
                </div>
            </form>
        </TabPanel>
        <TabPanel header="Assign Roles">
            <template v-for="role in model.assigned_roles">
                <div class="field-checkbox flex items-center gap-2 gap-x-4">
                    <Checkbox @update:modelValue="toggleRole($event,role)"  :id="role.id" v-model="role.assigned" :binary="true" />
                    <label :for="role.id">{{role.name}}</label>
                </div>
                <Divider/>
            </template>
        </TabPanel>
    </TabView>
    <Message v-else severity="error"
        >You are not authorized to perform this action</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "UserEditForm",
});
</script>
<script setup lang="ts">
import Button from "primevue/button";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import axios from "axios";
import route from "ziggy-js";
import Label from "@/Components/Label.vue";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
import Message from "primevue/message";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import InputText from "primevue/inputtext";
import AcaciaDatepicker from "@/Components/AcaciaDatepicker.vue";
import Password from "primevue/password";
import Checkbox from "primevue/checkbox";
import Divider from "primevue/divider";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: Object });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
const form = useForm({ ...model });
const toggleRole = async (value,role) => {
    axios.post(route('api.v1.users.user.toggle-role',model),{role_id: role.id, assigned: value}).then(res => {
        toast.add({
            severity: "success",
            summary: `Role ${value ? 'Assigned': 'Revoked'}`,
            detail: `The role assignment has been successfully updated.`,
            life: 1000,
        });
    }).catch(err => {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: err?.response?.data?.message || err?.message || err,
            life: 2000,
        });
    })
}
const updateModel = async () => {
    form.put(route("acacia.auth.users.update", model), {
        onSuccess: (res) => {
            const fl = res.props.flash as any;
            toast.add({
                severity: "success",
                summary: "Success",
                detail: fl?.success,
                life: 2000,
            });
            const payload = flash.value?.payload;
            emit("updated", { payload: payload });
        },
        onError: (errors) => {
            let msg =
                flash.value?.error ||
                errors?.message ||
                errors?.error ||
                errors ||
                "A server error occurred.";
            toast.add({
                severity: "error",
                summary: "Error",
                detail: msg,
                life: 3000,
            });
            const payload = flash.value?.payload;
            emit("error", { payload: payload, message: msg });
        },
        onFinish: (res) => {},
    });
};
</script>

<style scoped></style>
