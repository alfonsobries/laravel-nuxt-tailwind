<template>
  <t-dropdown
    :text="locales[locale]"
    :button-props="{ baseClass: 'flex items-center focus:outline-none', defaultClass: '', defaultSizeClass: ''}"
    tag-name="li"
    placement="bottom-start"
  >
    <ul>
      <li 
        v-for="(value, key) in locales" 
        :key="key" >
        <a
          class="block no-underline px-4 py-2 hover:bg-blue-500 hover:text-white" 
          href="#"
          @click.prevent="setLocale(key)">
          {{ value }}
        </a>
      </li>
    </ul>
  </t-dropdown>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    }
  }
}
</script>
