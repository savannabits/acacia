<template>
  <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-gray-200 overflow-hidden">
    <div class="flex flex-col h-full">
      <!-- Image -->
      <img class="w-full" :src="item.image" width="286" height="160" :alt="item.name" />
      <!-- Card Content -->
      <div class="grow flex flex-col p-5">
        <!-- Card body -->
        <div class="grow">
          <!-- Header -->
          <header class="mb-2">
            <h3 class="text-lg text-gray-800 font-semibold mb-1">{{item.title}}</h3>
            <div class="text-sm">{{item.content}}</div>
          </header>
          <!-- Price -->
          <div class="flex items-center space-x-2 mb-4">
            <div class="inline-flex text-sm font-medium bg-green-100 text-green-600 rounded-full text-center px-2.5 py-0.5">{{item.deal}}</div>
            <div class="inline-flex text-sm font-medium text-gray-500 line-through">{{item.price}}</div>
          </div>
        </div>
        <!-- Card footer -->
        <div>
          <router-link class="btn-sm w-full bg-indigo-500 hover:bg-indigo-600 text-white" :to="item.link">Buy Now</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ApplicationsCard02',
  props: ['item'],
}
</script>