<template>
    <SidebarLinkGroup v-slot="parentLink" :activeCondition="active">
        <a class="block py-1 text-gray-200 hover:text-primary truncate transition duration-150" :class="active && 'hover:text-gray-200'" href="#0" @click.prevent="sidebarExpanded ? parentLink.handleClick() : expandSidebar(parentLink)">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <slot name="icon">
                        <i v-if="icon" :class="`${icon} ${active && 'text-primary'}`"></i>
                    </slot>
                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                        <slot name="title">
                            <span v-if="header">{{header}}</span>
                        </slot>
                    </span>
                </div>
                <!-- Icon -->
                <div class="flex shrink-0 ml-0">
                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" :class="parentLink.expanded && 'transform rotate-180'" viewBox="0 0 12 12">
                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg>
                </div>
            </div>
        </a>
        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
            <ul class="pl-2 mt-1" :class="!parentLink.expanded && 'hidden'">
                <slot/>
            </ul>
        </div>
    </SidebarLinkGroup>
</template>

<script lang="ts">
import SidebarLinkGroup from "@/partials/SidebarLinkGroup.vue";
import {nextTick} from "vue";
export default {
    name: "SidebarParentLink",
    components: {SidebarLinkGroup},
    emits: ['expandSidebar'],
    props: {
        active: Boolean,
        header: String,
        icon: String,
        sidebarExpanded: Boolean,
    },
    setup(props, {emit}) {
        const expandSidebar = (parentLink) => {
            emit("expandSidebar");
            nextTick(() => {
                parentLink.expandSubmenu();
            })
        }
        return {
            expandSidebar,
        }
    }
}
</script>

<style scoped>

</style>
