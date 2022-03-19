<template>
  <div class="bg-white shadow-lg rounded-sm border border-gray-200 p-4">
    <!-- Body -->
    <div class="mb-3">
      <!-- Title -->
      <h2 class="font-semibold text-gray-800 mb-1">Design new diagrams</h2>
      <!-- Content -->
      <div>
        <div class="text-sm">#7896 created by <a class="font-medium text-gray-800 hover:underline" href="#0">jerzy-wierzy</a></div>
      </div>
    </div>
    <!-- Footer -->
    <div class="flex items-center justify-between">
      <!-- Left side -->
      <div class="flex shrink-0 -space-x-3 -ml-px">
        <a class="block" href="#0">
          <img class="rounded-full border-2 border-white box-content" src="../../images/user-28-12.jpg" width="28" height="28" alt="User 12" />
        </a>
        <a class="block" href="#0">
          <img class="rounded-full border-2 border-white box-content" src="../../images/user-28-02.jpg" width="28" height="28" alt="User 02" />
        </a>
      </div>
      <!-- Right side -->
      <div class="flex items-center">
        <!-- Like button -->
        <button class="flex items-center text-gray-400 hover:text-indigo-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M14.682 2.318A4.485 4.485 0 0011.5 1 4.377 4.377 0 008 2.707 4.383 4.383 0 004.5 1a4.5 4.5 0 00-3.182 7.682L8 15l6.682-6.318a4.5 4.5 0 000-6.364zm-1.4 4.933L8 12.247l-5.285-5A2.5 2.5 0 014.5 3c1.437 0 2.312.681 3.5 2.625C9.187 3.681 10.062 3 11.5 3a2.5 2.5 0 011.785 4.251h-.003z" />
          </svg>
          <div class="text-sm text-gray-500">4</div>
        </button>
        <!-- Replies button -->
        <button class="flex items-center text-gray-400 hover:text-indigo-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
          </svg>
          <div class="text-sm text-gray-500">7</div>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Task06',
}
</script>