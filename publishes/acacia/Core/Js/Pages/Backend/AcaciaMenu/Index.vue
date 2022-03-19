<template>
    <Head>
        <title>Manage Sidebar Menu</title>
    </Head>
    <Backend>
        <template #header>
            <h4 class="font-black text-2xl mx-2 px-3">Manage Sidebar Menu</h4>
        </template>
        <div class="border-t p-2 px-3 mt-4 mx-2">
            <Card>
                <template #content>
                    <OrderList v-model="$page.props.acacia.sidebar_menu" dataKey="id">
                        <template #item="{item}">
                            <Panel :collapsed="false" :toggleable="item.has_children">
                                <template #header>
                                    <div class="flex items-center justify-between w-full">
                                        <Avatar :icon="item.icon" class="bg-green-500" size="large" shape="square" />
                                        <div>
                                            <h4>{{item.title}}</h4>
                                            <small>{{item.href}}</small>
                                        </div>
                                        <div class="flex gap-x-2 items-center">
                                            <Button @click="$inertia.visit(route('acacia.backend.acacia-menu.edit',item.id))" label="Edit" icon="pi pi-pencil"/>
                                        </div>
                                    </div>
                                </template>
                                <OrderList v-if="item.has_children" v-model="item.children" dataKey="id">
                                    <template #item="child">
                                        <Panel :collapsed="false" :toggleable="child.item.has_children">
                                            <template #header>
                                                <div class="flex items-center justify-between w-full">
                                                    <Avatar :icon="child.item.icon" class="bg-green-500" size="large" shape="square" />
                                                    <div>
                                                        <h4>{{child.item.title}}</h4>
                                                        <small>{{child.item.href}}</small>
                                                    </div>
                                                    <div class="flex gap-x-2 items-center">
                                                        <Button @click="$inertia.visit(route('acacia.backend.acacia-menu.edit',child.item.id))" label="Edit" icon="pi pi-pencil"/>
                                                    </div>
                                                </div>
                                            </template>
                                        </Panel>
                                    </template>
                                </OrderList>
                            </Panel>
                        </template>
                    </OrderList>
                </template>
            </Card>
        </div>
    </Backend>
</template>

<script lang="ts">
import {defineComponent, Ref, ref} from "vue";
import Backend from "@/Layouts/Backend.vue";
import WelcomeBanner from "@/partials/dashboard/WelcomeBanner.vue";
import DashboardAvatars from "@/partials/dashboard/DashboardAvatars.vue";
import {Head} from "@inertiajs/inertia-vue3";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Button from "primevue/button";
import OrderList from "primevue/orderlist";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import Divider from "primevue/divider";
import Panel from "primevue/panel";

export default defineComponent({
    name: "Index",
    components: {
        DashboardAvatars,
        WelcomeBanner,
        Backend,
        Head,
        Card,
        OrderList,
        DataTable,
        Column,
        Button,
        Avatar,
        Divider,
        Panel,
    },
    setup() {
        const expandedRows = ref([]) as Ref;
        const onRowReorder = (e: Event) => {
            console.log(e);
        }
        return {expandedRows ,onRowReorder}
    }
})
</script>

<style scoped>

</style>
