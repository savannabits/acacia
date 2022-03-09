<template>
  <fragment>
    <!-- Modal backdrop -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-out duration-100"
      leave-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-show="show" class="fixed inset-0 z-50 bg-black bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    </transition>

    <!-- Modal dialog -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-out duration-200"
      leave-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-show="show"
        :id="id"
        class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center transform px-4 sm:px-6"
        role="dialog"
        aria-modal="true"
        :aria-labelledby="ariaLabel"
      >
        <div class="bg-white overflow-auto max-w-6xl w-full max-h-full" ref="modalContent">          
          <slot />
        </div>
      </div>
    </transition>
  </fragment>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    id: {
      type: String,
      default: null
    },
    ariaLabel: {
      type: String,
      default: null
    },
    show: {
      type: Boolean,
      default: false,
      required: true
    },
  },
  methods: {
    clickOutside(e) {
      if (!this.show || this.$refs.modalContent.contains(e.target)) return
      this.$emit('handleClose')
    },
    keyPress() {
      if (!this.show || event.keyCode !== 27) return
      this.$emit('handleClose')
    }    
  },  
  mounted() {
    document.addEventListener('click', this.clickOutside)    
    document.addEventListener('keydown', this.keyPress)
  },
  beforeDestroy() {
    document.removeEventListener('click', this.clickOutside)
    document.removeEventListener('keydown', this.keyPress)
  }  
}
</script>