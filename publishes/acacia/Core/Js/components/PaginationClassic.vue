<template>
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
      <ul class="flex justify-center">
        <li class="ml-3 first:ml-0">
          <a class="btn bg-white border-gray-200 text-gray-300 cursor-not-allowed" href="#0" disabled>&lt;- Previous</a>
        </li>
        <li class="ml-3 first:ml-0">
          <a class="btn bg-white border-gray-200 hover:border-gray-300 text-indigo-500" href="#0">Next -&gt;</a>
        </li>
      </ul>
    </nav>
    <div class="text-sm text-gray-500 text-center sm:text-left">
      Showing <span class="font-medium text-gray-600">1</span> to <span class="font-medium text-gray-600">10</span> of <span class="font-medium text-gray-600">467</span> results
    </div>
  </div>
</template>

<script>
export default {
  name: 'PaginationClassic',
}
</script>