<template>
  <t-card 
    :header="$t('your_info')" 
    class="w-full">
    <form 
      @submit.prevent="update" 
      @keydown="form.onKeydown($event)">
      <t-alert
        :show="form.successful"
        variant="success"
        class="mb-3"
      >{{ $t('info_updated') }}</t-alert>

      <t-input-group
        :label="$t('name')"
        :status="form.errors.has('name') ? false : null"
        :feedback="form.errors.get('name')"
      >
        <t-input
          :disabled="form.busy"
          v-model="form.name"
          :status="form.errors.has('name') ? false : null"
          name="name"
        />
      </t-input-group>

      <t-input-group
        :label="$t('email')"
        :status="form.errors.has('email') ? false : null"
        :feedback="form.errors.get('email')"
      >
        <t-input
          :disabled="form.busy"
          v-model="form.email"
          :status="form.errors.has('email') ? false : null"
          type="email"
          name="email"
        />
      </t-input-group>

      <t-input-group>
        <t-button 
          :disabled="form.busy"
          type="submit"
          variant="primary"
        >{{ $t('update') }}</t-button>
      </t-input-group>
    </form>
  </t-card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  head () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      this.form.patch('/settings/profile')
        .then(({ data }) => {
          this.$store.dispatch('auth/updateUser', { user: data })
        })
    }
  }
}
</script>
