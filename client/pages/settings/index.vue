<template>
  <container>
    <div class="md:flex md:-mx-1">
      <t-card 
        :header="$t('settings')" 
        class="md:mx-1 mb-2 md:mb-0 md:w-1/3 flex-shrink-0"
      >
        <ul class="flex flex-col">
          <li 
            v-for="tab in tabs" 
            :key="tab.route" 
          >
            <router-link 
              :to="{ name: tab.route }" 
              class="w-full block py-1 uppercase text-sm" 
              active-class="font-bold"
            >
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </t-card>

      <div class="md:mx-1 w-full">
        <transition 
          name="fade" 
          mode="out-in">
          <router-view/>
        </transition>
      </div>
    </div>
  </container>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>
