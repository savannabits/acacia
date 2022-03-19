<template>
    <Authenticated>
        <template #header>
            <div class="flex items-center flex-wrap gap-x-2">
                <BackLink :href="route('app.sms.index')"/>
                File Upload SMS
            </div>
        </template>
        <Card class="my-2">
            <template #content>
                <a href="download">
                    <Button icon="pi pi-download" label="Download Template File"/>
                </a>
            </template>
        </Card>
        <Card class="my-2">
            <template #title>Compose Message </template>
            <template #content>
                <h5 class="font-bold text-lg">Available Template Variables <small><strong>(click any to insert to template)</strong></small></h5>
                <div class="flex flex-wrap gap-2 items-center">
                    <button v-for="item of templateVars" :key="item.variable" @click="insertToTemplate(item.variable)" >
                        <Tag>{{item.title}}</Tag>
                    </button>
                </div>
                <form @submit.prevent="" class="my-4">
                    <textarea class="p-inputtext w-full" placeholder="Type your message here" ref="messageEl" v-model="form.message"/>
                    <span>Chars: {{form.message?.length||0}}/{{maxMessageLength}} Remaining: {{remainingChars}}</span>
                </form>
            </template>
        </Card>
        <Divider/>
        <Card>
            <template #title>Upload Excel File</template>
            <template #content>
                <FileUpload
                    :disabled="loading"
                    :customUpload="true"
                    @uploader="submitFile"
                    name="sms_file" url="./upload"
                    accept="text/csv,application/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                    <template #empty>
                        <p>Drag and drop your excel here to upload.</p>
                    </template>
                </FileUpload>
            </template>
        </Card>
    </Authenticated>
</template>

<script lang="ts">
import Authenticated from "@/Layouts/Authenticated.vue";
import Button from "primevue/button";
import BackLink from "@/Components/BackLink.vue";
import Card from "primevue/card";
import FileUpload from "primevue/fileupload";
import {computed, defineComponent, nextTick, Ref, ref} from "vue";
import Divider from "primevue/divider";
import Tag from "primevue/tag";
import {useForm} from "@inertiajs/inertia-vue3";
import Textarea from "primevue/textarea";
import {useToast} from "primevue/usetoast";
import {ToastMessageOptions} from "primevue/toast";
import route from "ziggy-js";

export default defineComponent({
    name: "FileSms",
    components: {BackLink, Authenticated, Button, FileUpload,Card, Divider, Tag, Textarea},
    setup(props, {}) {
        const messageEl = ref() as Ref<HTMLInputElement>;
        const templateVars = ref([
            {variable: 'first_name', title: 'First Name'},
            {variable: 'middle_name', title: 'Middle Name'},
            {variable: 'surname_name', title: 'Surname'},
            {variable: 'bill_amount', title: 'Bill Amount'},
            {variable: 'bill_due_date', title: 'Bill Due Date'},
        ]);
        const form = useForm({
            message: '',
            file: null,
        });
        const toast = useToast();
        const loading = ref(false) as Ref<boolean>;
        const maxMessageLength = ref(160);
        const remainingChars = computed(() => maxMessageLength.value - (form.message?.length ?? 0))
        const insertToTemplate = (variable: string) => {
            typeInTextarea(`{{${variable}}}`, messageEl.value)
        }
        const typeInTextarea = async (newText, el = document.activeElement as HTMLInputElement) => {
            const [start, end] = [el.selectionStart, el.selectionEnd] as [number, number];
            el.setRangeText(newText, start, end, 'select');
            await nextTick();
            el.setSelectionRange(end+newText.length,end+newText.length);
            el.focus();
        }
        const submitFile = async (event) => {
            try {
                loading.value = true;
                form.file = event.files[0];
                if (!form.message) {
                    toast.add({
                        life: 3000,
                        summary: "Missing Message",
                        detail: "Please draft your message first before uploading the recipients file.",
                        severity: 'error'
                    } as ToastMessageOptions)
                    throw new Error("Missing Message")
                }
                await form.post(route("app.sms.file-upload"));
                loading.value = false;
            } catch (e) {
                loading.value = false;
            }
        }
        return {
            messageEl,
            templateVars,
            form,
            maxMessageLength,
            remainingChars,
            loading,
            insertToTemplate,
            submitFile,
        }
    }
})
</script>

<style scoped>

</style>
