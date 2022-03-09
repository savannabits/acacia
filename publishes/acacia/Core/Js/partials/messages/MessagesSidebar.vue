<template>
  <div
    id="messages-sidebar"
    class="absolute z-20 top-0 bottom-0 w-full md:w-auto md:static md:top-auto md:bottom-auto -mr-px md:translate-x-0 transform transition-transform duration-200 ease-in-out"
    :class="msgSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <div class="sticky top-16 bg-white overflow-x-hidden overflow-y-auto no-scrollbar shrink-0 border-r border-gray-200 md:w-72 xl:w-80 h-[calc(100vh-64px)]">

      <!-- #Marketing group -->
      <div>
        <!-- Group header -->
        <div class="sticky top-0 z-10">
          <div class="flex items-center bg-white border-b border-gray-200 px-5 h-16">
            <div class="w-full flex items-center justify-between">
              <!-- Channel menu -->
              <ChannelMenu />
              <!-- Edit button -->
              <button class="p-1.5 shrink-0 rounded border border-gray-200 hover:border-gray-300 shadow-sm ml-2">
                <svg class="w-4 h-4 fill-current text-gray-500" viewBox="0 0 16 16">
                  <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Group body -->
        <div class="px-5 py-4">
          <!-- Search form -->
          <form class="relative">
            <label for="msg-search" class="sr-only">Search</label>
            <input id="msg-search" class="form-input w-full pl-9 focus:border-gray-300" type="search" placeholder="Search…" />
            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
              <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 group-hover:text-gray-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
              </svg>
            </button>
          </form>
          <!-- Direct messages -->
          <DirectMessages :msgSidebarOpen="msgSidebarOpen" @close-msgsidebar="$emit('close-msgsidebar')" />
          <!-- Channels -->
          <Channels :msgSidebarOpen="msgSidebarOpen" @close-msgsidebar="$emit('close-msgsidebar')" />
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import ChannelMenu from './ChannelMenu.vue'
import DirectMessages from './DirectMessages.vue'
import Channels from './Channels.vue'

export default {
  name: 'MessagesSidebar',
  props: ['msgSidebarOpen'],
  components: {
    ChannelMenu,
    DirectMessages,
    Channels
  },
}
</script>