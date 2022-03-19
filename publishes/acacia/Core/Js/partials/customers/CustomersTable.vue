<template>
  <div class="bg-white shadow-lg rounded-sm border border-gray-200 relative">
    <header class="px-5 py-4">
      <h2 class="font-semibold text-gray-800">All Customers <span class="text-gray-400 font-medium">248</span></h2>
    </header>
    <div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="table-auto w-full">
          <!-- Table header -->
          <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-t border-b border-gray-200">
            <tr>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                <div class="flex items-center">
                  <label class="inline-flex">
                    <span class="sr-only">Select all</span>
                    <input class="form-checkbox" type="checkbox" v-model="selectAll" @click="checkAll" />
                  </label>
                </div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                <span class="sr-only">Favourite</span>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Order</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Email</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Location</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Orders</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Last order</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Total spent</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Refunds</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <span class="sr-only">Menu</span>
              </th>
            </tr>
          </thead>
          <!-- Table body -->
          <tbody class="text-sm divide-y divide-gray-200">
            <Customer
              v-for="customer in customers"
              :key="customer.id"
              :customer="customer"
              v-model:selected="selected"
              :value="customer.id"
            />
          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from 'vue'
import Customer from './CustomersTableItem.vue'

import Image01 from '../../images/user-40-01.jpg'
import Image02 from '../../images/user-40-02.jpg'
import Image03 from '../../images/user-40-03.jpg'
import Image04 from '../../images/user-40-04.jpg'
import Image05 from '../../images/user-40-05.jpg'
import Image06 from '../../images/user-40-06.jpg'
import Image07 from '../../images/user-40-07.jpg'
import Image08 from '../../images/user-40-08.jpg'
import Image09 from '../../images/user-40-09.jpg'
import Image10 from '../../images/user-40-10.jpg'

export default {
  name: 'CustomersTable',
  components: {
    Customer,
  },  
  props: ['selectedItems'],
  setup(props, { emit }) {

    const selectAll = ref(false)
    const selected = ref([])

    const checkAll = () =>{
      selected.value = []
      if (!selectAll.value) {
        selected.value = customers.value.map(customer => customer.id)
      }
    }
    
    watch(selected, () => {
      selectAll.value = customers.value.length === selected.value.length ? true : false
      emit('change-selection', selected.value)
    })    
    
    const customers = ref([
      {
        id: '0',
        image: Image01,
        name: 'Patricia Semklo',
        email: 'patricia.semklo@app.com',
        location: '🇬🇧 London, UK',
        orders: '24',
        lastOrder: '#123567',
        spent: '$2,890.66',
        refunds: '-',
        fav: true
      },
      {
        id: '1',
        image: Image02,
        name: 'Dominik Lamakani',
        email: 'dominik.lamakani@gmail.com',
        location: '🇩🇪 Dortmund, DE',
        orders: '77',
        lastOrder: '#779912',
        spent: '$14,767.04',
        refunds: '4',
        fav: false
      },
      {
        id: '2',
        image: Image03,
        name: 'Ivan Mesaros',
        email: 'imivanmes@gmail.com',
        location: '🇫🇷 Paris, FR',
        orders: '44',
        lastOrder: '#889924',
        spent: '$4,996.00',
        refunds: '1',
        fav: true
      },
      {
        id: '3',
        image: Image04,
        name: 'Maria Martinez',
        email: 'martinezhome@gmail.com',
        location: '🇮🇹 Bologna, IT',
        orders: '29',
        lastOrder: '#897726',
        spent: '$3,220.66',
        refunds: '2',
        fav: false
      },
      {
        id: '4',
        image: Image05,
        name: 'Vicky Jung',
        email: 'itsvicky@contact.com',
        location: '🇬🇧 London, UK',
        orders: '22',
        lastOrder: '#123567',
        spent: '$2,890.66',
        refunds: '-',
        fav: true
      },
      {
        id: '5',
        image: Image06,
        name: 'Tisho Yanchev',
        email: 'tisho.y@kurlytech.com',
        location: '🇬🇧 London, UK',
        orders: '14',
        lastOrder: '#896644',
        spent: '$1,649.99',
        refunds: '1',
        fav: true
      },
      {
        id: '6',
        image: Image07,
        name: 'James Cameron',
        email: 'james.ceo@james.tech',
        location: '🇫🇷 Marseille, FR',
        orders: '34',
        lastOrder: '#136988',
        spent: '$3,569.87',
        refunds: '2',
        fav: true
      },
      {
        id: '7',
        image: Image08,
        name: 'Haruki Masuno',
        email: 'haruki@supermail.jp',
        location: '🇯🇵 Tokio, JP',
        orders: '112',
        lastOrder: '#442206',
        spent: '$19,246.07',
        refunds: '6',
        fav: false
      },
      {
        id: '8',
        image: Image09,
        name: 'Joe Huang',
        email: 'joehuang@hotmail.com',
        location: '🇨🇳 Shanghai, CN',
        orders: '64',
        lastOrder: '#764321',
        spent: '$12,276.92',
        refunds: '-',
        fav: true
      },
      {
        id: '9',
        image: Image10,
        name: 'Carolyn McNeail',
        email: 'carolynlove@gmail.com',
        location: '🇮🇹 Milan, IT',
        orders: '19',
        lastOrder: '#908764',
        spent: '$1,289.97',
        refunds: '2',
        fav: false
      }      
    ])

    return {
      selectAll,
      selected,
      checkAll,
      customers,
    }
  }
}
</script>