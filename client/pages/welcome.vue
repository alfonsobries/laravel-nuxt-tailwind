<template>
  <container class="flex items-center">
    <div class="text-center w-2/3 mx-auto">
      <h1 class="font-semibold text-gray-900 text-4xl md:text-6xl">
        {{ title }}
      </h1>

      <div class="flex justify-between flex-col md:flex-row">
        <a 
          class="text-gray-800 uppercase p-2 hover:underline" 
          href="https://tailwindcss.com/">TailwindCSS</a>
        <a 
          class="text-gray-800 uppercase p-2 hover:underline" 
          href="https://laravel.com/">Laravel.com</a>
        <a 
          class="text-gray-800 uppercase p-2 hover:underline" 
          href="https://vuejs.org/">VueJs</a>
        <a 
          class="text-gray-800 uppercase p-2 hover:underline" 
          href="https://nuxtjs.org/">Nuxtjs</a>
        <a 
          class="text-gray-800 uppercase p-2 hover:underline" 
          href="https://vue-tailwind.com/">Vue Tailwind</a>
      </div>
    </div>
  </container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>
