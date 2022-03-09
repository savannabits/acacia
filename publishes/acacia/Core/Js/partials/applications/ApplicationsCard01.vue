<template>
  <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-gray-200 overflow-hidden">
    <div class="flex flex-col h-full">
      <!-- Image -->
      <img class="w-full" :src="item.image" width="286" height="160" :alt="item.title" />
      <!-- Card Content -->
      <div class="grow flex flex-col p-5">
        <!-- Card body -->
        <div class="grow">
          <!-- Header -->
          <header class="mb-2">
            <h3 class="text-lg text-gray-800 font-semibold mb-1">{{item.title}}</h3>
            <div class="text-sm">{{item.content}}</div>
          </header>
          <!-- Rating -->
          <div class="flex items-center space-x-2 mb-4">
            <!-- Stars -->
            <div class="flex space-x-1">
              <button>
                <span class="sr-only">1 star</span>
                <svg class="w-4 h-4 fill-current" :class="Math.round(item.rating) > 0 ? 'text-yellow-500' : 'text-gray-300'" viewBox="0 0 16 16">
                  <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                </svg>
              </button>
              <button>
                <span class="sr-only">2 stars</span>
                <svg class="w-4 h-4 fill-current" :class="Math.round(item.rating) > 1 ? 'text-yellow-500' : 'text-gray-300'" viewBox="0 0 16 16">
                  <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                </svg>
              </button>
              <button>
                <span class="sr-only">3 stars</span>
                <svg class="w-4 h-4 fill-current" :class="Math.round(item.rating) > 2 ? 'text-yellow-500' : 'text-gray-300'" viewBox="0 0 16 16">
                  <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                </svg>
              </button>
              <button>
                <span class="sr-only">4 stars</span>
                <svg class="w-4 h-4 fill-current" :class="Math.round(item.rating) > 3 ? 'text-yellow-500' : 'text-gray-300'" viewBox="0 0 16 16">
                  <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                </svg>
              </button>
              <button>
                <span class="sr-only">5 stars</span>
                <svg class="w-4 h-4 fill-current" :class="Math.round(item.rating) > 4 ? 'text-yellow-500' : 'text-gray-300'" viewBox="0 0 16 16">
                  <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                </svg>
              </button>
            </div>
            <!-- Rate -->
            <div class="inline-flex text-sm font-medium bg-yellow-100 text-yellow-600 rounded-full text-center px-2.5 py-0.5">{{item.rating}}</div>
          </div>
          <!-- Features list -->
          <ul class="text-sm space-y-2 mb-5">
            <li v-if="item.feat01" class="flex items-center">
              <svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-3" viewBox="0 0 16 16">
                <path d="M15.686 5.695L10.291.3c-.4-.4-.999-.4-1.399 0s-.4.999 0 1.399l.6.599-6.794 3.697-1-1c-.4-.399-.999-.399-1.398 0-.4.4-.4 1 0 1.4l1.498 1.498 2.398 2.398L.6 13.988 2 15.387l3.696-3.697 3.997 3.996c.5.5 1.199.2 1.398 0 .4-.4.4-.999 0-1.398l-.999-1 3.697-6.694.6.6c.599.6 1.199.2 1.398 0 .3-.4.3-1.1-.1-1.499zM8.493 11.79L4.196 7.494l6.695-3.697 1.298 1.299-3.696 6.694z" />
              </svg>
              <div>{{item.feat01}}</div>
            </li>
            <li v-if="item.feat02" class="flex items-center">
              <svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-3" viewBox="0 0 16 16">
                <path d="M15 15V5l-5-5H2c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h12c.6 0 1-.4 1-1zM3 2h6v4h4v8H3V2z" />
              </svg>
              <div>{{item.feat02}}</div>
            </li>
            <li v-if="item.feat03" class="flex items-center">
              <svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-3" viewBox="0 0 16 16">
                <path d="M13 7h2v6a1 1 0 01-1 1H4v2l-4-3 4-3v2h9V7zM3 9H1V3a1 1 0 011-1h10V0l4 3-4 3V4H3v5z" />
              </svg>
              <div>{{item.feat03}}</div>
            </li>
            <li v-if="item.feat04" class="flex items-center">
              <svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-3" viewBox="0 0 16 16">
                <path d="M7.3 8.7c-.4-.4-.4-1 0-1.4l7-7c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-7 7c-.4.4-1 .4-1.4 0zm0 6c-.4-.4-.4-1 0-1.4l7-7c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-7 7c-.4.4-1 .4-1.4 0zm-7-5c-.4-.4-.4-1 0-1.4l7-7c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-7 7c-.4.4-1 .4-1.4 0z" />
              </svg>
              <div>{{item.feat04}}</div>
            </li>
          </ul>
        </div>
        <!-- Card footer -->
        <div>
          <router-link class="btn-sm w-full bg-indigo-500 hover:bg-indigo-600 text-white" :to="item.link">Install</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ApplicationsCard01',
  props: ['item'],
}
</script>