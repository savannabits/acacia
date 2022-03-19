<template>
    <Head>
        <title>Code Generation Panel</title>
    </Head>
    <Backend>
        <template #header>
            <h4 class="font-black text-2xl px-1 md:px-4">Code Generation Panel</h4>
        </template>
        <div class="mx-auto flex max-w-4xl items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <TabView ref="tabs">
                    <TabPanel :lazy="true" header="Current Schematics">
                        <Schematics/>
                    </TabPanel>
                    <TabPanel :lazy="true" header="New Module">
                        <SchematicsCreate/>
                    </TabPanel>
                </TabView>
            </div>
        </div>
    </Backend>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Backend from "@/Layouts/Backend.vue";
import WelcomeBanner from "@/partials/dashboard/WelcomeBanner.vue";
import DashboardAvatars from "@/partials/dashboard/DashboardAvatars.vue";
import {Head} from "@inertiajs/inertia-vue3";
import Column from "primevue/column";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import SchematicsCreate from "@/Pages/GPanel/Schematics/Create.vue"

export default defineComponent({
    name: "Index",
    components: {
        DashboardAvatars,
        WelcomeBanner,
        Backend,
        Head,
        Column,
        SchematicsCreate,
        TabView,
        TabPanel,
    },
    setup() {
        const onRowReorder = (e: Event) => {
            console.log(e);
        }
        return {onRowReorder}
    }
})
</script>
<script setup lang="ts">
import Schematics from "@/Pages/GPanel/Schematics/Index.vue"
</script>
<style scoped>

</style>
