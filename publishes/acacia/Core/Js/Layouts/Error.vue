<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <!--
      This example requires updating your template:

      ```
      <html class="h-full bg-gray-100">
      <body class="h-full">
      ```
    -->
    <div class="min-h-full">
        <main>
            <Toast/>
            <ConfirmDialog/>
            <slot/>
        </main>
    </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import route from "ziggy-js";
import {Link} from "@inertiajs/inertia-vue3";
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
export default {
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
        Link,
        Toast,
        ConfirmDialog,
    },
    setup() {
        return {
        }
    },
}
</script>
