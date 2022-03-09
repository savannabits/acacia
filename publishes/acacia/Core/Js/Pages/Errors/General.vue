<template>
    <Error>
        <div class="flex items-center justify-center w-screen h-screen bg-gradient-to-r from-indigo-600 to-blue-400">
            <div class="px-40 py-20 bg-white rounded-md shadow-xl">
                <div class="flex flex-col items-center">
                    <h1 class="font-bold text-blue-600 text-9xl">{{$page.props.status}}</h1>
                    <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">
                        <span class="text-red-500">Oops!</span> {{ $page.props.summary }}
                    </h6>
                    <p class="mb-8 text-center text-gray-500 md:text-lg">
                        {{ $page.props.errorMessage }}
                    </p>
                    <div class="flex justify-center items-center gap-x-2">
                        <router-link v-if="$page.props.previousUrl" :href="$page.props.previousUrl"
                                     class="px-6 py-2 text-sm font-semibold text-red-500 bg-red-100">
                           <i class="pi pi-arrow-left"></i> Go Back
                        </router-link>
                        <router-link :href="route('dashboard')" class="px-6 py-2 text-sm font-semibold text-blue-800 bg-blue-100">
                            <i class="pi pi-home"></i> Go Home
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </Error>
</template>

<script lang="ts">
import Guest from "@/Layouts/Guest.vue";
import {defineComponent} from "vue";
import Backend from "@/Layouts/Backend.vue";
import Error from "@/Layouts/Error.vue";

export default defineComponent({
    name: "General",
    components: {
        Error,
    }
})
</script>

<style scoped>

</style>
