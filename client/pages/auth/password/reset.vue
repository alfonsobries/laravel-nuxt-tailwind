<template>
  <container class="flex items-center justify-center">
    <form 
      class="max-w-md w-full"
      @submit.prevent="reset" 
      @keydown="form.onKeydown($event)">
      <t-card :header="$t('reset_password')">
        <t-alert
          :show="form.successful"
          variant="success"
          class="mb-3"
        >{{ status }}</t-alert>
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
            readonly
            class="w-full"
          />
        </t-input-group>
        <t-input-group
          :label="$t('password')"
          :status="form.errors.has('password') ? false : null"
          :feedback="form.errors.get('password')"
        >
          <t-input
            :disabled="form.busy"
            v-model="form.password"
            :status="form.errors.has('password') ? false : null"
            type="password"
            name="password"
            class="w-full"
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
            type="password"
            name="password_confirmation"
            class="w-full"
          />
        </t-input-group>
        <t-input-group>
          <t-button 
            :disabled="form.busy"
            type="submit"
            variant="primary"
          >{{ $t('reset_password') }}</t-button>
        </t-input-group>
      </t-card>
    </form>
  </container>
</template>

<script>
import Form from 'vform'

export default {
  head () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    reset () {
      this.form.post('/password/reset')
        .then(({ data }) => {
          this.status = data.status

          this.form.reset()
        })
    }
  }
}
</script>
