<template>
  <div
    id="inbox-sidebar"
    class="absolute z-20 top-0 bottom-0 w-full md:w-auto md:static md:top-auto md:bottom-auto -mr-px md:translate-x-0 transform transition-transform duration-200 ease-in-out"
    :class="inboxSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
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
            <label for="inbox-search" class="sr-only">Search</label>
            <input id="inbox-search" class="form-input w-full pl-9 focus:border-gray-300" type="search" placeholder="Search…" />
            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
              <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 group-hover:text-gray-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
              </svg>
            </button>
          </form>
          <!-- Tabs -->
          <div class="relative mt-4">
            <div class="absolute bottom-0 w-full h-px bg-gray-200" aria-hidden="true"></div>
            <ul class="relative text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
              <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="block pb-3 text-indigo-500 whitespace-nowrap border-b-2 border-indigo-500" href="#0">Primary</a>
              </li>
              <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="block pb-3 text-gray-500 hover:text-gray-600 whitespace-nowrap" href="#0">Social</a>
              </li>
              <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="block pb-3 text-gray-500 hover:text-gray-600 whitespace-nowrap" href="#0">Promotions</a>
              </li>
            </ul>
          </div>
          <!-- Inbox -->
          <div class="mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase mb-3">Inbox (44)</div>
            <ul class="mb-6">
              <li class="-mx-2">
                <button class="flex w-full p-2 rounded bg-indigo-100 text-left" @click.stop="$emit('close-inboxsidebar')">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-32-01.jpg" width="32" height="32" alt="User 01" />
                  <div class="grow truncate">
                    <div class="flex items-center justify-between mb-1.5">
                      <div class="truncate">
                        <span class="text-sm font-semibold text-gray-800">Dominik Lamakani</span>
                      </div>
                      <div class="text-xs text-gray-500 font-medium">4 Aug</div>
                    </div>
                    <div class="text-xs font-medium text-gray-800 truncate mb-0.5">Chill your mind with this amazing offer 🎉</div>
                    <div class="text-xs whitespace-normal">Lorem ipsum dolor sit amet, consecte adipiscing elit aute irure dolor…</div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="flex w-full p-2 rounded text-left" @click.stop="$emit('close-inboxsidebar')">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-32-05.jpg" width="32" height="32" alt="User 05" />
                  <div class="grow truncate">
                    <div class="flex items-center justify-between mb-1.5">
                      <div class="truncate">
                        <span class="text-sm font-semibold text-gray-800">Simona Lürwer</span>
                      </div>
                      <div class="text-xs text-gray-500 font-medium">4 Aug</div>
                    </div>
                    <div class="text-xs font-medium text-gray-800 truncate mb-0.5">🙌 Help us improve Mosaic by giving…</div>
                    <div class="text-xs whitespace-normal">Lorem ipsum dolor sit amet, consecte adipiscing elit aute irure dolor…</div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="flex w-full p-2 rounded text-left" @click.stop="$emit('close-inboxsidebar')">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-32-06.jpg" width="32" height="32" alt="User 05" />
                  <div class="grow truncate">
                    <div class="flex items-center justify-between mb-1.5">
                      <div class="truncate">
                        <span class="text-sm font-semibold text-gray-800">Mary Roszczewski</span>
                      </div>
                      <div class="text-xs text-gray-500 font-medium">1 Aug</div>
                    </div>
                    <div class="text-xs font-medium text-gray-800 truncate mb-0.5">[Urgent] Changes to links for public…</div>
                    <div class="text-xs whitespace-normal">👋 Lorem ipsum dolor sit amet, consecte adipiscing elit aute irure dolor…</div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="flex w-full p-2 rounded text-left" @click.stop="$emit('close-inboxsidebar')">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-32-04.jpg" width="32" height="32" alt="User 05" />
                  <div class="grow truncate">
                    <div class="flex items-center justify-between mb-1.5">
                      <div class="truncate">
                        <span class="text-sm font-semibold text-gray-800">Adrian Przetocki</span>
                      </div>
                      <div class="text-xs text-gray-500 font-medium">1 Aug</div>
                    </div>
                    <div class="text-xs font-medium text-gray-800 truncate mb-0.5">🙌 Help us improve Mosaic by giving…</div>
                    <div class="text-xs whitespace-normal">Lorem ipsum dolor sit amet, consecte adipiscing elit aute irure dolor…</div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="flex w-full p-2 rounded text-left" @click.stop="$emit('close-inboxsidebar')">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-32-02.jpg" width="32" height="32" alt="User 05" />
                  <div class="grow truncate">
                    <div class="flex items-center justify-between mb-1.5">
                      <div class="truncate">
                        <span class="text-sm font-semibold text-gray-800">Tisha Yanchev</span>
                      </div>
                      <div class="text-xs text-gray-500 font-medium">1 Aug</div>
                    </div>
                    <div class="text-xs font-medium text-gray-800 truncate mb-0.5">Re: Here’s an extra 25% OFF 🎉</div>
                    <div class="text-xs whitespace-normal">Excepteur sint occaecat cupidatat non proident sunt in culpa qui deserunt…</div>
                  </div>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import ChannelMenu from '../messages/ChannelMenu.vue'

export default {
  name: 'InboxSidebar',
  props: ['inboxSidebarOpen'],
  components: {
    ChannelMenu,
  },
}
</script>