<template>
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar v-slot="slotProps" :sidebarOpen="sidebarOpen" @close-sidebar="closeSidebar">
            <template v-for="(menu, index) of $page.props.acacia.sidebar_menu" :key="index">
                <SidebarLink
                    v-if="!menu.has_children && menu.shown"
                    :href="menu.href" :active="menu.active">
                    <template #icon>
                        <i class="menu.icon" :class="[menu.active && 'text-primary', menu.icon]"></i>
                    </template>
                    {{ menu.title }}
                </SidebarLink>
                <SidebarParentLink v-else-if="menu.shown" :sidebar-expanded="slotProps.sidebarExpanded"
                                   @expandSidebar="slotProps.expandSidebar"
                                   :icon="menu.icon"
                                   :header="menu.title"
                                   :active="menu.active">
                    <template v-for="(child, idx) of menu.children"
                              :key="idx">
                        <SidebarLink v-if="!child.has_children && child.shown" :submenu="true" :href="child.href"
                                     :icon="child.icon"
                                     :active="child.active">
                            {{ child.title }}
                        </SidebarLink>
                        <SidebarParentLink v-else-if="child.shown" :submenu="true" :sidebar-expanded="slotProps.sidebarExpanded"
                                           @expandSidebar="slotProps.expandSidebar"
                                           :icon="child.icon"
                                           :header="child.title"
                                           :active="child.active">
                            <template v-for="(grandchild, idx) of child.children"
                                      :key="idx">
                                <SidebarLink v-if=" grandchild.shown" :submenu="true" :href="grandchild.href"
                                             :icon="grandchild.icon"
                                             :active="grandchild.active">
                                    {{ grandchild.title }}
                                </SidebarLink>

                            </template>
                        </SidebarParentLink>
                    </template>
                </SidebarParentLink>
            </template>
        </Sidebar>

        <!-- Content area -->
        <div class="bg-gray-100 relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>
            <main class="py-1">
                <Toast/>
                <ConfirmDialog/>
                <template v-if="$slots.header">
                    <div class="font-bold p-2 text-xl border-b">
                        <slot name="header"/>
                    </div>
                </template>
                <slot/>
            </main>

        </div>

    </div>
</template>

<script lang="ts">
import {computed, defineComponent, ref} from 'vue'
import Sidebar from '@/partials/Sidebar.vue'
import Header from '@/partials/Header.vue'
import WelcomeBanner from '@/partials/dashboard/WelcomeBanner.vue'
import DashboardAvatars from '@/partials/dashboard/DashboardAvatars.vue'
import FilterButton from '@/components/DropdownFilter.vue'
import Datepicker from '@/components/Datepicker.vue'
import SidebarLink from "@/partials/SidebarLink.vue";
import {usePage} from "@inertiajs/inertia-vue3";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import SidebarParentLink from "@/Components/SidebarParentLink.vue";

export default defineComponent({
    name: 'Backend',
    components: {
        SidebarParentLink,
        SidebarLink,
        Sidebar,
        Header,
        WelcomeBanner,
        DashboardAvatars,
        FilterButton,
        Datepicker,
        Toast,
        ConfirmDialog,
    },
    setup() {

        const sidebarOpen = ref(false)
        const closeSidebar = (e) =>  {
            console.log("closing sidebar");
            sidebarOpen.value = false
        }
        return {
            sidebarOpen,
            closeSidebar,
        }
    }
})
</script>
