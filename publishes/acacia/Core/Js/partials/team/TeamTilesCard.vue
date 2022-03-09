<template>
  <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-gray-200">
    <div class="flex flex-col h-full">
      <!-- Card top -->
      <div class="grow p-5">
        <div class="flex justify-between items-start">
          <!-- Image + name -->
          <header>
            <div class="flex mb-2">
              <router-link class="relative inline-flex items-start mr-5" :to="item.link">
                <div class="absolute top-0 right-0 -mr-2 bg-white rounded-full shadow" aria-hidden="true">
                  <svg class="w-8 h-8 fill-current text-yellow-500" viewBox="0 0 32 32">
                    <path d="M21 14.077a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 010 1.5 1.5 1.5 0 00-1.5 1.5.75.75 0 01-.75.75zM14 24.077a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 110-2 4 4 0 004-4 1 1 0 012 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1z" />
                  </svg>
                </div>
                <img class="rounded-full" :src="item.image" width="64" height="64" :alt="item.name" />
              </router-link>
              <div class="mt-1 pr-1">
                <router-link class="inline-flex text-gray-800 hover:text-gray-900" :to="item.link">
                  <h2 class="text-xl leading-snug justify-center font-semibold">{{item.name}}</h2>
                </router-link>
                <div class="flex items-center"><span class="text-sm font-medium text-gray-400 -mt-0.5 mr-1">-&gt;</span> <span>{{item.location}}</span></div>
              </div>
            </div>
          </header>
          <!-- Menu button -->
          <EditMenu align="right" class="relative inline-flex shrink-0">
            <li>
              <router-link class="font-medium text-sm text-gray-600 hover:text-gray-800 flex py-1 px-3" to="#0">Option 1</router-link>
            </li>
            <li>
              <router-link class="font-medium text-sm text-gray-600 hover:text-gray-800 flex py-1 px-3" to="#0">Option 2</router-link>
            </li>
            <li>
              <router-link class="font-medium text-sm text-red-500 hover:text-red-600 flex py-1 px-3" to="#0">Remove</router-link>
            </li>
          </EditMenu>
        </div>
        <!-- Bio -->
        <div class="mt-2">
          <div class="text-sm">{{item.content}}</div>
        </div>
      </div>
      <!-- Card footer -->
      <div class="border-t border-gray-200">
        <div class="flex divide-x divide-gray-200r">
          <router-link class="block flex-1 text-center text-sm text-indigo-500 hover:text-indigo-600 font-medium px-3 py-4" to="/messages">
            <div class="flex items-center justify-center">
              <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                <path d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
              </svg>
              <span>Send Email</span>
            </div>
          </router-link>
          <router-link class="block flex-1 text-center text-sm text-gray-600 hover:text-gray-800 font-medium px-3 py-4 group" to="/settings/account">
            <div class="flex items-center justify-center">
              <svg class="w-4 h-4 fill-current text-gray-400 group-hover:text-gray-500 shrink-0 mr-2" viewBox="0 0 16 16">
                <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
              </svg>
              <span>Edit Profile</span>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EditMenu from '../../components/DropdownEditMenu.vue'

export default {
  name: 'TeamTilesCard',
  props: ['item'],
  components: {
    EditMenu,
  },  
}
</script>