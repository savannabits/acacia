<template>
  <li
    class="relative"
    @mouseenter="dropdownOpen = true"
    @mouseleave="dropdownOpen = false"
    @focusin="dropdownOpen = true"
    @focusout="dropdownOpen = false"
  >
    <a
      class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-5 py-2 flex items-center transition duration-150 ease-in-out"
      href="#0"
      aria-haspopup="true"
      aria-expanded={dropdownOpen}
      @click.prevent
    >
      {{title}}
      <svg class="w-3 h-3 fill-current text-gray-400 cursor-pointer ml-1 flex-shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.28 4.305L5.989 8.598 1.695 4.305A1 1 0 00.28 5.72l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z" />
      </svg>
    </a>
    <transition
      enter-active-class="transition ease-out duration-200 transform"
      enter-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-out duration-200"
      leave-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <ul v-show="dropdownOpen" class="origin-top-right absolute top-full left-0 w-40 bg-white dark:bg-gray-800 shadow-lg py-2 ml-4 rounded">
        <slot />
      </ul>
    </transition>
  </li>
</template>
<script>
export default {
  name: 'Dropdown',
  props: {
    title: {
      type: String,
      default: null,
      required: true
    },
  },
  data: function () {
    return {
      dropdownOpen: false
    }
  },
}
</script>