<template>
    <div>
        <!-- Sidebar backdrop (mobile only) -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
             :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true"></div>

        <!-- Sidebar -->
        <div
            id="sidebar"
            ref="sidebar"
            class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-gray-800 p-4 transition-all duration-200 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
        >

            <!-- Sidebar header -->
            <div class="flex justify-between items-center mb-10 pr-3 sm:px-2">
                <!-- Close button -->
                <button
                    ref="trigger"
                    class="lg:hidden text-gray-500 hover:text-gray-400"
                    @click.stop="$emit('close-sidebar')"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Close sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"/>
                    </svg>
                </button>
                <!-- Logo -->
                <a class="block" :href="route('dashboard')">
                    <img alt="Acacia" :src="logo">
                </a>
<!--                <h4 class="font-black text-gray-100 uppercase" :class="!sidebarExpanded && 'hidden'">{{$page.props.acacia?.sidebar_heading}}</h4>-->
            </div>

            <!-- Links -->
            <div class="space-y-8">
                <!-- Pages group -->
                <div>
                    <h3 class="text-xs uppercase text-gray-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                              aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                    </h3>
                    <ul class="mt-3">
                        <slot :sidebarExpanded="sidebarExpanded" :expandSidebar="expandSidebar"/>
                    </ul>
                </div>
            </div>

            <!-- Expand / collapse button -->
            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
                <div class="px-3 py-2">
                    <button @click.prevent="sidebarExpanded = !sidebarExpanded">
                        <span class="sr-only">Expand / collapse sidebar</span>
                        <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                            <path class="text-gray-400"
                                  d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z"/>
                            <path class="text-gray-600" d="M3 23H1V1h2z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {ref, onMounted, onUnmounted, watch, reactive} from 'vue'
import logo from "@/images/logo.png"
import SidebarLinkGroup from '@/partials/SidebarLinkGroup.vue'

export default {
    name: 'Sidebar',
    props: ['sidebarOpen'],
    components: {
        SidebarLinkGroup,
    },
    emits: ['close-sidebar'],
    setup(props, {emit}) {

        const trigger = ref(null)
        const sidebar = ref(null)

        const storedSidebarExpanded = ref(localStorage.getItem('sidebar-expanded'))
        const sidebarExpanded = ref( storedSidebarExpanded.value === 'true')
        const currentRoute = route().current();

        // close on click outside
        const clickHandler = ({target}) => {
            if (!sidebar.value || !trigger.value) return
            if (
                !props.sidebarOpen ||
                sidebar.value.contains(target) ||
                trigger.value.contains(target)
            ) return
            emit('close-sidebar')
        }

        // close if the esc key is pressed
        const keyHandler = ({keyCode}) => {
            if (!props.sidebarOpen || keyCode !== 27) return
            emit('close-sidebar')
        }

        onMounted(() => {
            if (sidebarExpanded.value) {
                document.querySelector('body').classList.add('sidebar-expanded')
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded')
            }
            document.addEventListener('click', clickHandler)
            document.addEventListener('keydown', keyHandler)
        })

        watch(sidebarExpanded, () => {
            localStorage.setItem('sidebar-expanded', sidebarExpanded.value ?? "true")
            console.log("Toggling sidebar: "+sidebarExpanded.value);
            if (sidebarExpanded.value) {
                document.querySelector('body').classList.add('sidebar-expanded')
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded')
            }
        })

        const expandSidebar = () => {
            sidebarExpanded.value = true;
        }
        return {
            trigger,
            sidebar,
            sidebarExpanded,
            currentRoute,
            expandSidebar,
            logo,
        }
    },
}
</script>
