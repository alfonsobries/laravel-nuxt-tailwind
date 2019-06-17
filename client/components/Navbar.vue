<template>
  <container class="flex">
    <nuxt-link 
      :to="{ name: authenticated ? 'home' : 'welcome' }"
      class="no-underline">
      <logo :alt="appName" />
    </nuxt-link>

    <ul class="ml-auto hidden md:flex">
      <locale-dropdown class="ml-6" />
      <account-dropdown 
        v-if="authenticated" 
        class="ml-6"
      />
      <template v-else>
        <li class="ml-6">
          <router-link :to="{ name: 'login' }">
            {{ $t('login') }}
          </router-link>
        </li>
        <li class="ml-6">
          <router-link :to="{ name: 'register' }">
            {{ $t('register') }}
          </router-link>
        </li>
      </template>
    </ul>

    <ul class="ml-auto flex md:hidden">
      <t-dropdown
        :button-props="{ baseClass: 'flex items-center focus:outline-none', defaultClass: '', defaultSizeClass: ''}"
        :text="$t('menu')"
        tag-name="li"
        placement="bottom-end"
      >
        <ul>
          <template v-if="authenticated">
            <li>
              <router-link 
                :to="{ name: 'home' }" 
                class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white">
                {{ $t('home') }}
              </router-link>
            </li>
            <li>
              <router-link 
                :to="{ name: 'settings.profile' }" 
                class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white" >
                {{ $t('settings') }}
              </router-link>
            </li>
            <li class="border-b" />
            <li>
              <a 
                href="#" 
                class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white"
                @click.prevent="logout">
                {{ $t('logout') }}
              </a>
            </li>
          </template>
          <template v-else>
            <li>
              <router-link 
                :to="{ name: 'login' }" 
                class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white">
                {{ $t('login') }}
              </router-link>
            </li>
            <li>
              <router-link 
                :to="{ name: 'register' }" 
                class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </t-dropdown>
    </ul>
  </container>
</template>

<script>
import { mapGetters } from 'vuex'
import Logo from './Logo'
import LocaleDropdown from './LocaleDropdown'
import AccountDropdown from './AccountDropdown'

export default {
  components: {
    Logo,
    LocaleDropdown,
    AccountDropdown
  },

  data: () => ({
    appName: process.env.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
  }),
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
