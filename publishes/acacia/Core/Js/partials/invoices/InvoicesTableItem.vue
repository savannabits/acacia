<template>
  <tr>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
      <div class="flex items-center">
        <label class="inline-flex">
          <span class="sr-only">Select</span>
          <input :id="invoice.id" class="form-checkbox" type="checkbox" :value="value" @change="check" :checked="checked" />
        </label>
      </div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div class="font-medium text-light-blue-500">{{invoice.invoice}}</div>
    </td>    
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div class="font-medium" :class="totalColor(invoice.status)">{{invoice.total}}</div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5" :class="statusColor(invoice.status)">{{invoice.status}}</div>
    </td>    
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div class="font-medium text-gray-800">{{invoice.customer}}</div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div>{{invoice.issueddate}}</div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div>{{invoice.paiddate}}</div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
      <div class="flex items-center">
        <div v-html="typeIcon(invoice.type)"></div>
        <div>{{invoice.type}}</div>
      </div>
    </td>
    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
      <div class="space-x-1">
        <button class="text-gray-400 hover:text-gray-500 rounded-full">
          <span class="sr-only">Edit</span>
          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
              <path d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
          </svg>
        </button>
        <button class="text-gray-400 hover:text-gray-500 rounded-full">
          <span class="sr-only">Download</span>
          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
              <path d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
          </svg>
        </button>
        <button class="text-red-500 hover:text-red-600 rounded-full">
          <span class="sr-only">Delete</span>
          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
              <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
              <path d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
          </svg>
        </button>
      </div>
    </td>
  </tr>  
</template>

<script>
import { computed } from 'vue'

export default {
  name: 'InvoicesTableItem',
  props: ['invoice', 'value', 'selected'],
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

    const totalColor = (status) => {
      switch (status) {
        case 'Paid':
          return 'text-green-500'
        case 'Due':
          return 'text-yellow-500'
        case 'Overdue':
          return 'text-red-500'          
        default:
          return 'text-gray-500'
      }
    }    

    const statusColor = (status) => {
      switch (status) {
        case 'Paid':
          return 'bg-green-100 text-green-600'
        case 'Due':
          return 'bg-yellow-100 text-yellow-600'
        case 'Overdue':
          return 'bg-red-100 text-red-500'          
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
      totalColor,
      statusColor,
      typeIcon,
    }
  },
}
</script>