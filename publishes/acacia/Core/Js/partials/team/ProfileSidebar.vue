<template>
  <div
    id="profile-sidebar"
    class="absolute z-20 top-0 bottom-0 w-full md:w-auto md:static md:top-auto md:bottom-auto -mr-px md:translate-x-0 transform transition-transform duration-200 ease-in-out"
    :class="profileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <div class="sticky top-16 bg-white overflow-x-hidden overflow-y-auto no-scrollbar shrink-0 border-r border-gray-200 md:w-72 xl:w-80 h-[calc(100vh-64px)]">

      <!-- Profile group -->
      <div>
        <!-- Group header -->
        <div class="sticky top-0 z-10">
          <div class="flex items-center bg-white border-b border-gray-200 px-5 h-16">
            <div class="w-full flex items-center justify-between">
              <!-- Profile image -->
              <div class="relative">
                <div class="grow flex items-center truncate">
                  <img class="w-8 h-8 rounded-full mr-2" src="../../images/user-avatar-32.png" width="32" height="32" alt="Group 01" />
                  <div class="truncate">
                    <span class="font-semibold text-gray-800">Acme Inc.</span>
                  </div>
                </div>
              </div>
              <!-- Add button -->
              <button class="p-1.5 shrink-0 rounded border border-gray-200 hover:border-gray-300 shadow-sm ml-2">
                <svg class="w-4 h-4 fill-current text-indigo-500" viewBox="0 0 16 16">
                  <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1Z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Group body -->
        <div class="px-5 py-4">
          <!-- Search form -->
          <form class="relative">
            <label for="profile-search" class="sr-only">Search</label>
            <input id="profile-search" class="form-input w-full pl-9 focus:border-gray-300" type="search" placeholder="Search…" />
            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
              <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 group-hover:text-gray-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
              </svg>
            </button>
          </form>
          <!-- Team members -->
          <div class="mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase mb-3">Team members</div>
            <ul class="mb-6">
              <li class="-mx-2">
                <button class="w-full p-2 rounded bg-indigo-100" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-08.jpg" width="32" height="32" alt="User 08" />
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Carolyn McNeail</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-06.jpg" width="32" height="32" alt="User 06" />
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Mary Roszczewski</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-03.jpg" width="32" height="32" alt="User 03" />
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Jerzy Wierzy</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-02.jpg" width="32" height="32" alt="User 02" />
                      <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Tisha Yanchev</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-05.jpg" width="32" height="32" alt="User 05" />
                      <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Simona Lürwer</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-04.jpg" width="32" height="32" alt="User 04" />
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Adrian Przetocki</span>
                    </div>
                  </div>
                </button>
              </li>
              <li class="-mx-2">
                <button class="w-full p-2 rounded" @click.stop="$emit('close-profilesidebar')">
                  <div class="flex items-center truncate">
                    <div class="relative mr-2">
                      <img class="w-8 h-8 rounded-full" src="../../images/user-32-01.jpg" width="32" height="32" alt="User 01" />
                      <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="truncate">
                      <span class="text-sm font-medium text-gray-800">Brian Halligan</span>
                    </div>
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
export default {
  name: 'ProfileSidebar',
  props: ['profileSidebarOpen'],
}
</script>