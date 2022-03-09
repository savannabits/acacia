<template>
  <div class="bg-white shadow-lg rounded-sm border border-gray-200 p-4">
    <!-- Body -->
    <div class="mb-3">
      <!-- Title -->
      <h2 class="font-semibold text-gray-800 mb-1">Product Update - Q4 2021</h2>
      <!-- Content -->
      <div>
        <div class="text-sm">Dedicated form for a category of users that will perform actions.</div>
        <img class="w-full mt-3" src="../../images/task-image-01.jpg" width="259" height="142" alt="Task 01" />
      </div>
    </div>
    <!-- Footer -->
    <div class="flex items-center justify-between">
      <!-- Left side -->
      <div class="flex shrink-0 -space-x-3 -ml-px">
        <a class="block" href="#0">
          <img class="rounded-full border-2 border-white box-content" src="../../images/user-28-05.jpg" width="28" height="28" alt="User 05" />
        </a>
        <a class="block" href="#0">
          <img class="rounded-full border-2 border-white box-content" src="../../images/user-28-02.jpg" width="28" height="28" alt="User 02" />
        </a>
      </div>
      <!-- Right side -->
      <div class="flex items-center">
        <!-- Date -->
        <div class="flex items-center text-yellow-500 ml-3">
          <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
            <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
          </svg>
          <div class="text-sm text-yellow-600">Mar 27</div>
        </div>
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
  name: 'Task05',
}
</script>