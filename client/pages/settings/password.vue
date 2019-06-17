<template>
  <form 
    @submit.prevent="update" 
    @keydown="form.onKeydown($event)">
    <t-card 
      :header="$t('your_password')" 
      class="w-full">
      <t-alert
        :show="form.successful"
        variant="success"
        class="mb-3"
      >{{ $t('password_updated') }}</t-alert>

      <t-input-group
        :label="$t('new_password')"
        :status="form.errors.has('password') ? false : null"
        :feedback="form.errors.get('password')"
      >
        <t-input
          :disabled="form.busy"
          v-model="form.password"
          :status="form.errors.has('password') ? false : null"
          name="password"
          type="password"
        />
      </t-input-group>

      <t-input-group
        :label="$t('confirm_password')"
        :status="form.errors.has('password_confirmation') ? false : null"
        :feedback="form.errors.get('password_confirmation')"
      >
        <t-input
          :disabled="form.busy"
          v-model="form.password_confirmation"
          :status="form.errors.has('password_confirmation') ? false : null"
          name="password_confirmation"
          type="password"
        />
      </t-input-group>

      <t-input-group>
        <t-button 
          :disabled="form.busy"
          type="submit"
          variant="primary"
        >{{ $t('update') }}</t-button>
      </t-input-group>
    </t-card>
  </form>
</template>

<script>
import Form from 'vform'

export default {
  scrollToTop: false,

  head () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    update () {
      this.form.patch('/settings/password')
        .then(() => {
          this.form.reset()
        })
    }
  }
}
</script>
