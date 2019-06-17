<template>
  <layout-container class="text-gray-900 antialiased leading-normal">
    <layout-container col>
      <layout-navigation>
        <navbar />
      </layout-navigation>
      <layout-main class="flex-1 py-2">
        <nuxt/>
      </layout-main>
    </layout-container>
  </layout-container>
</template>

<script>
import { mapGetters } from 'vuex'
import Navbar from '@/components/Navbar'

export default {
  components: {
    Navbar
  },
}
</script>

