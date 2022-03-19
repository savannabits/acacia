<template>
  <tbody class="text-sm">
    <!-- Row -->
    <tr>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
        <div class="flex items-center">
          <label class="inline-flex">
            <span class="sr-only">Select</span>
            <input :id="order.id" class="form-checkbox" type="checkbox" :value="value" @change="check" :checked="checked" />
          </label>
        </div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="flex items-center text-gray-800">
          <div class="w-10 h-10 shrink-0 flex items-center justify-center bg-gray-100 rounded-full mr-2 sm:mr-3">
            <img class="ml-1" :src="order.image" width="20" height="20" :alt="order.order" />
          </div>
          <div class="font-medium text-light-blue-500">{{order.order}}</div>
        </div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div>{{order.date}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="font-medium text-gray-800">{{order.customer}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-left font-medium text-green-500">{{order.total}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5" :class="statusColor(order.status)">{{order.status}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-center">{{order.items}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-left">{{order.location}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="flex items-center">
          <div v-html="typeIcon(order.type)"></div>
          <div>{{order.type}}</div>
        </div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
        <div class="flex items-center">
          <button
            class="text-gray-400 hover:text-gray-500 transform"
            :class="descriptionOpen && 'rotate-180'"
            :aria-expanded="descriptionOpen"
            @click.prevent="descriptionOpen = !descriptionOpen"
            :aria-controls="`description-${order.id}`"
          >
            <span class="sr-only">Menu</span>
            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
              <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z" />
            </svg>
          </button>
        </div>
      </td>
    </tr>
    <!--
    Example of content revealing when clicking the button on the right side:
    Note that you must set a "colSpan" attribute on the <td> element,
    and it should match the number of columns in your table
    -->
    <tr :id="`description-${order.id}`" role="region" :class="!descriptionOpen && 'hidden'">
      <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3">
        <div class="flex items-center bg-gray-50 p-3 -mt-3">
          <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 mr-2">
            <path d="M1 16h3c.3 0 .5-.1.7-.3l11-11c.4-.4.4-1 0-1.4l-3-3c-.4-.4-1-.4-1.4 0l-11 11c-.2.2-.3.4-.3.7v3c0 .6.4 1 1 1zm1-3.6l10-10L13.6 4l-10 10H2v-1.6z" />
          </svg>
          <div class="italic">{{order.description}}</div>
        </div>
      </td>
    </tr>
  </tbody>
</template>

<script>
import { ref, computed } from 'vue'

export default {
  name: 'OrdersTableItem',
  props: ['order', 'value', 'selected'],
  setup(props, context) {
    const checked = computed(() => props.selected.includes(props.value))

    function check() {
      let updatedSelected = [...props.selected]
      if (this.checked) {
        updatedSelected.splice(updatedSelected.indexOf(props.value), 1)
      } else {
        updatedSelected.push(props.value)
      }
      context.emit('update:selected', updatedSelected)
    }

    const descriptionOpen = ref(false)

    const statusColor = (status) => {
      switch (status) {
        case 'Approved':
          return 'bg-green-100 text-green-600'
        case 'Refunded':
          return 'bg-yellow-100 text-yellow-600'
        default:
          return 'bg-gray-100 text-gray-500'
      }
    }
    
    const typeIcon = (type) => {
      switch (type) {
        case 'Subscription':
          return (
            `<svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-2" viewBox="0 0 16 16">
              <path d="M4.3 4.5c1.9-1.9 5.1-1.9 7 0 .7.7 1.2 1.7 1.4 2.7l2-.3c-.2-1.5-.9-2.8-1.9-3.8C10.1.4 5.7.4 2.9 3.1L.7.9 0 7.3l6.4-.7-2.1-2.1zM15.6 8.7l-6.4.7 2.1 2.1c-1.9 1.9-5.1 1.9-7 0-.7-.7-1.2-1.7-1.4-2.7l-2 .3c.2 1.5.9 2.8 1.9 3.8 1.4 1.4 3.1 2 4.9 2 1.8 0 3.6-.7 4.9-2l2.2 2.2.8-6.4z" />
            </svg>`            
          )
        default:
          return (
            `<svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-2" viewBox="0 0 16 16">
              <path d="M11.4 0L10 1.4l2 2H8.4c-2.8 0-5 2.2-5 5V12l-2-2L0 11.4l3.7 3.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3l3.7-3.7L7.4 10l-2 2V8.4c0-1.7 1.3-3 3-3H12l-2 2 1.4 1.4 3.7-3.7c.4-.4.4-1 0-1.4L11.4 0z" />
            </svg>`
          )
      }
    }

    return {
      check,
      checked,
      statusColor,
      typeIcon,
      descriptionOpen,
    }
  },
}
</script>