<template>
  <div :class="selectedItems.length < 1 && 'hidden'">
    <div class="flex items-center">
      <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span>{{selectedItems.length}}</span> items selected</div>
      <button class="btn bg-white border-gray-200 hover:border-gray-300 text-red-500 hover:text-red-600">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteButton',
  props: ['selectedItems'],
}
</script>