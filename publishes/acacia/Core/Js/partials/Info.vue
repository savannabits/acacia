<template>
  <div
    class="relative"
    @mouseenter="infoOpen = true"
    @mouseleave="infoOpen = false"
    @focusin="infoOpen = true"
    @focusout="infoOpen = false"    
  >
    <button
      class="block"
      aria-haspopup="true"
      aria-expanded="infoOpen"
      @click.prevent
    >
      <svg class="w-4 h-4 fill-current text-gray-400" viewBox="0 0 16 16">
        <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
      </svg>
    </button>
    <div class="z-10 absolute bottom-full left-1/2 transform -translate-x-1/2">
      <transition
        enter-active-class="transition ease-out duration-200 transform"
        enter-from-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-out duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-show="infoOpen" class="bg-white border border-gray-200 p-3 rounded shadow-lg overflow-hidden mb-2" :class="containerClass">
          <slot />
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'Info',
  props: ['containerClass'],
  setup() {
    const infoOpen = ref(false)
    return {
      infoOpen,
    }
  }
}
</script>