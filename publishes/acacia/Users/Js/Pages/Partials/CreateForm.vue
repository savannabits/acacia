<template>
    <form v-if="$page.props.can?.create" @submit.prevent="createModel">
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
                        <p class="mt-2 font-bold">Password MUST have:</p>
                        <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
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
                <InputText class="block w-full" v-model="form.remember_token" />
            </div>
        </div>

        <div class="text-right min-w-[300px] pt-2 border-t-2">
            <Button type="submit" icon="pi pi-check" label="Save" />
        </div>
    </form>
    <Message v-else severity="error"
        >You are not authorized to perform this action</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "UserCreate",
});
</script>
<script setup lang="ts">
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import axios from "axios";
import route from "ziggy-js";
import Label from "@/Components/Label.vue";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
import Message from "primevue/message";
import InputText from "primevue/inputtext";
import AcaciaDatepicker from "@/Components/AcaciaDatepicker.vue";
import Password from "primevue/password";
const emit = defineEmits(["created", "error"]);
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const form = useForm({
    name: null,
    email: null,
    email_verified_at: null,
    password: null,
    remember_token: null,
});
const createModel = async () => {
    form.post(route("acacia.auth.users.store"), {
        onSuccess: (res) => {
            const fl = res.props.flash as any;
            toast.add({
                severity: "success",
                summary: "Success",
                detail: fl?.success,
                life: 2000,
            });
            const payload = flash.value?.payload;
            emit("created", { payload: payload });
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
