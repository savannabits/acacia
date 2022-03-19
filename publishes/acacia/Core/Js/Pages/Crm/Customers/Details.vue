<template>
    <Backend>
        <template #header>
            <div class="text-center bg-indigo-500 text-indigo-50">
                <h4 class="p-2 font-black text-2xl">Customer Details: {{model.email}}</h4>
            </div>
        </template>
        <div class="w-full mt-4">
            <Card class="mx-auto max-w-xl">
                <template #content>
                    <div>First Name: <strong>{{model.first_name}}</strong></div>
                    <Divider/>
                    <div>Middle Name: <strong>{{model.middle_name}}</strong></div>
                    <Divider/>
                    <div>Last Name: <strong>{{model.surname}}</strong></div>
                    <Divider/>
                    <div>Email: <strong>{{model.email}}</strong></div>
                    <Divider/>
                    <div>Phone No.: <strong>{{model.phone_number}}</strong></div>
                    <Divider/>
                </template>
            </Card>
        </div>
    </Backend>
</template>

<script lang="ts">
import Backend from "@/Layouts/Backend.vue";
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import Card from "primevue/card";
import Divider from "primevue/divider";
export default {
    name: "Details",
    components: {Backend, Card, Divider,},
    setup(props) {
        const model = computed(() => usePage().props.value.model);
        return {
            model,
        }
    }
}
</script>

<style scoped>

</style>
