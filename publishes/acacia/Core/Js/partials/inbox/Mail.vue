<template>
  <div class="py-6">
    <!-- Header -->
    <header class="flex items-start">
      <!-- Avatar -->
      <img class="rounded-full shrink-0 mr-3" :src="mail.image" width="40" height="40" :alt="mail.name" />
      <!-- Meta -->
      <div class="grow">
        <div class="sm:flex items-start justify-between mb-0.5">
          <!-- Message author -->
          <div class="xl:flex items-center mb-2 sm:mb-0">
            <button class="text-sm font-semibold text-gray-800 text-left truncate" @click.prevent="mail.open = !mail.open">Acme Inc.</button>
            <div class="text-sm text-gray-400 hidden xl:block mx-1" v-if="mail.open">·</div>
            <div class="text-xs" v-if="mail.open">{{mail.email}}</div>
          </div>
          <!-- Date -->
          <div class="text-xs font-medium text-gray-500 whitespace-nowrap mb-2 sm:mb-0">{{mail.date}}</div>
        </div>
        <!-- To -->
        <div class="text-xs font-medium text-gray-500" v-if="mail.open">To {{mail.recipients.join(', ')}}</div>
        <!-- Excerpt -->
        <div class="text-sm" v-if="!mail.open">{{mail.excerpt}}</div>
      </div>
    </header>
    <!-- Body -->
    <div class="text-sm text-gray-800 mt-4 space-y-2" v-html="mail.message" v-if="mail.open"></div>
  </div>
</template>

<script>
export default {
  name: 'Mail',
  props: ['mail'],
}
</script>