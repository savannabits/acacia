<template>
  <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" :class="{'pl-0': submenu,'bg-gray-900': active&&!submenu, 'font-bold text-primary': active && submenu }">
    <router-link class="block text-gray-200 hover:text-white truncate transition duration-150"
                 :class="{'hover:text-primary-300': active ,'font-bold text-primary': active && submenu}"
                 :href="href">
      <div class="flex items-center">

        <slot name="icon">
          <i v-if="icon" :class="`${icon} ${active && 'text-primary'}`"></i>
        </slot>
        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
          <slot/>
        </span>
      </div>
    </router-link>
  </li>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
  name: "SidebarLink",
  props: {
    "submenu": Boolean,
    "active": {},
    "href": {},
    "icon": { type: String,default: null},
    "ajaxLoad": {default: true, type: Boolean}
  }
})
</script>

<style scoped>
</style>
