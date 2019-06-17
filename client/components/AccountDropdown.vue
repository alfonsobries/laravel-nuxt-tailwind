<template>
  <t-dropdown
    :text="user.name"
    :button-props="{ baseClass: 'flex items-center focus:outline-none', defaultClass: '', defaultSizeClass: ''}"
    tag-name="li"
    placement="bottom-start"
  >
    <ul>
      <li>
        <router-link 
          :to="{ name: 'settings.profile' }" 
          class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white" >
          {{ $t('settings') }}
        </router-link>
      </li>
      <li class="border-b"></li>
      <li>
        <a
          class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white" 
          href="#"
          @click.prevent="logout">
          {{ $t('logout') }}
        </a>
      </li>
    </ul>
  </t-dropdown>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  },

  computed: mapGetters({
    user: 'auth/user',
  }),
}
</script>
