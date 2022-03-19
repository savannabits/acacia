<template>
  <div class="bg-white shadow-lg rounded-sm border border-gray-200 relative">
    <header class="px-5 py-4">
      <h2 class="font-semibold text-gray-800">All Orders <span class="text-gray-400 font-medium">442</span></h2>
    </header>
    <div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200">
          <!-- Table header -->
          <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-t border-gray-200">
            <tr>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                <div class="flex items-center">
                  <label class="inline-flex">
                    <span class="sr-only">Select all</span>
                    <input class="form-checkbox" type="checkbox" v-model="selectAll" @click="checkAll" />
                  </label>
                </div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Order</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Date</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Customer</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Total</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Status</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Items</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Location</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Payment type</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <span class="sr-only">Menu</span>
              </th>
            </tr>
          </thead>
          <!-- Table body -->
          <Order
            v-for="order in orders"
            :key="order.id"
            :order="order"
            v-model:selected="selected"
            :value="order.id"
          />
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from 'vue'
import Order from './OrdersTableItem.vue'

import Image01 from '../../images/icon-01.svg'
import Image02 from '../../images/icon-02.svg'
import Image03 from '../../images/icon-03.svg'

export default {
  name: 'OrdersTable',
  components: {
    Order,
  },  
  props: ['selectedItems'],
  setup(props, { emit }) {

    const selectAll = ref(false)
    const selected = ref([])

    const checkAll = () =>{
      selected.value = []
      if (!selectAll.value) {
        selected.value = orders.value.map(order => order.id)
      }
    }
    
    watch(selected, () => {
      selectAll.value = orders.value.length === selected.value.length ? true : false
      emit('change-selection', selected.value)
    })    
    
    const orders = ref([
      {
        id: '0',
        image: Image01,
        order: '#123567',
        date: '22/01/2021',
        customer: 'Patricia Semklo',
        total: '$129.00',
        status: 'Refunded',
        items: '1',
        location: '🇨🇳 Shanghai, CN',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '1',
        image: Image01,
        order: '#779912',
        date: '22/01/2021',
        customer: 'Dominik Lamakani',
        total: '$89.00',
        status: 'Approved',
        items: '2',
        location: '🇲🇽 Mexico City, MX',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '2',
        image: Image02,
        order: '#889924',
        date: '22/01/2021',
        customer: 'Ivan Mesaros',
        total: '$89.00',
        status: 'Approved',
        items: '2',
        location: '🇮🇹 Milan, IT',
        type: 'One-time',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '3',
        image: Image01,
        order: '#897726',
        date: '22/01/2021',
        customer: 'Maria Martinez',
        total: '$59.00',
        status: 'Pending',
        items: '1',
        location: '🇮🇹 Bologna, IT',
        type: 'One-time',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '4',
        image: Image03,
        order: '#123567',
        date: '22/01/2021',
        customer: 'Vicky Jung',
        total: '$39.00',
        status: 'Refunded',
        items: '1',
        location: '🇬🇧 London, UK',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '5',
        image: Image01,
        order: '#896644',
        date: '21/01/2021',
        customer: 'Tisho Yanchev',
        total: '$59.00',
        status: 'Approved',
        items: '1',
        location: '🇫🇷 Paris, FR',
        type: 'One-time',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '6',
        image: Image03,
        order: '#136988',
        date: '21/01/2021',
        customer: 'James Cameron',
        total: '$89.00',
        status: 'Approved',
        items: '1',
        location: '🇫🇷 Marseille, FR',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '7',
        image: Image03,
        order: '#442206',
        date: '21/01/2021',
        customer: 'Haruki Masuno',
        total: '$129.00',
        status: 'Approved',
        items: '2',
        location: '🇺🇸 New York, USA',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '8',
        image: Image02,
        order: '#764321',
        date: '21/01/2021',
        customer: 'Joe Huang',
        total: '$89.00',
        status: 'Pending',
        items: '2',
        location: '🇨🇳 Shanghai, CN',
        type: 'One-time',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      },
      {
        id: '9',
        image: Image01,
        order: '#908764',
        date: '21/01/2021',
        customer: 'Carolyn McNeail',
        total: '$59.00',
        status: 'Refunded',
        items: '1',
        location: '🇬🇧 Sheffield, UK',
        type: 'Subscription',
        description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
      }
    ])

    return {
      selectAll,
      selected,
      checkAll,
      orders,
    }
  }
}
</script>