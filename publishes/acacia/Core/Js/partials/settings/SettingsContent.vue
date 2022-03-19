<template>
  <div class="flex-grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
      <!-- Picture -->
      <section>
        <h2 class="text-xl text-gray-800 font-bold mb-5">Picture</h2>
        <div class="flex items-center">
          <div class="mr-4">
            <img class="w-20 h-20 rounded-full" src="../../images/user-avatar-80.png" width="80" height="80" alt="User upload" />
          </div>
          <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Change</button>
        </div>
      </section>
      <!-- Business Profile -->
      <section>
        <h2 class="text-xl text-gray-800 font-bold mb-1">Business Profile</h2>
        <div class="text-sm">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</div>
        <div class="sm:flex sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-5">
          <div class="sm:w-1/3">
            <label class="block text-sm font-medium mb-1" for="name">Business Name</label>
            <input id="name" class="form-input w-full" type="text" />
          </div>
          <div class="sm:w-1/3">
            <label class="block text-sm font-medium mb-1" for="business-id">Business ID</label>
            <input id="business-id" class="form-input w-full" type="text" />
          </div>
          <div class="sm:w-1/3">
            <label class="block text-sm font-medium mb-1" for="location">Location</label>
            <input id="location" class="form-input w-full" type="text" />
          </div>
        </div>
      </section>
      <!-- Email -->
      <section>
        <h2 class="text-xl text-gray-800 font-bold mb-1">Email</h2>
        <div class="text-sm">Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia.</div>
        <div class="flex flex-wrap mt-5">
          <div class="mr-2">
            <label class="sr-only" for="email">Business email</label>
            <input id="email" class="form-input" type="email" />
          </div>
          <button class="btn border-gray-200 hover:border-gray-300 shadow-sm text-indigo-500">Change</button>
        </div>
      </section>
      <!-- Password -->
      <section>
        <h2 class="text-xl text-gray-800 font-bold mb-1">Password</h2>
        <div class="text-sm">You can set a permanent password if you don't want to use temporary login codes.</div>
        <div class="mt-5">
          <button class="btn border-gray-200 shadow-sm text-indigo-500">Set New Password</button>
        </div>
      </section>
      <!-- Smart Sync -->
      <section>
        <h2 class="text-xl text-gray-800 font-bold mb-1">Smart Sync update for Mac</h2>
        <div class="text-sm">With this update, online-only files will no longer appear to take up hard drive space.</div>
        <div class="flex items-center mt-5">
          <div class="form-switch focus-within:shadow-outline">
            <input type="checkbox" id="toggle" class="sr-only" v-model="sync" true-value="On" false-value="Off" />
            <label class="bg-gray-400" for="toggle">
              <span class="bg-white shadow-sm" aria-hidden="true"></span>
              <span class="sr-only">Enable smart sync</span>
            </label>
          </div>
          <div class="text-sm text-gray-400 italic ml-2">{{sync}}</div>
        </div>
      </section>
    </div>
    <!-- Panel footer -->
    <footer>
      <div class="flex flex-col px-6 py-5 border-t border-gray-200">
        <div class="flex self-end">
          <button class="btn border-gray-200 hover:border-gray-300 text-gray-600">Cancel</button>
          <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3">Save Changes</button>
        </div>
      </div>
    </footer>
  </div>  
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'SettingsContent',
  setup() {

  const sync = ref('Off')

    return {
      sync
    }
  }
}
</script>