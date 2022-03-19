<template>
  <div class="bg-white shadow-lg rounded-sm border border-gray-200 p-4">
    <!-- Body -->
    <div class="mb-3">
      <!-- Title -->
      <h2 class="font-semibold text-gray-800 mb-1">User should receive a daily digest email</h2>
      <!-- Content -->
      <div>
        <div class="text-sm">Dedicated form for a category of users that will perform actions.</div>
      </div>
    </div>
    <!-- Footer -->
    <div class="flex items-center justify-between">
      <!-- Left side -->
      <button class="p-2 shrink-0 rounded-full bg-white border border-gray-200 hover:border-gray-300 text-indigo-500 transition duration-150">
        <span class="sr-only">Add</span>
        <svg class="w-3 h-3 fill-current" viewBox="0 0 12 12">
          <path d="M11 5H7V1a1 1 0 00-2 0v4H1a1 1 0 000 2h4v4a1 1 0 002 0V7h4a1 1 0 000-2z" />
        </svg>
      </button>
      <!-- Right side -->
      <div class="flex items-center">
        <!-- Date -->
        <div class="flex items-center text-yellow-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
          </svg>
          <div class="text-sm text-yellow-600">Mar 27</div>
        </div>
        <!-- Replies button -->
        <button class="flex items-center text-gray-400 hover:text-indigo-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
          </svg>
          <div class="text-sm text-gray-500">6</div>
        </button>
        <!-- Attach button -->
        <button class="text-gray-400 hover:text-indigo-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0zM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Task02',
}
</script>