<template>
  <container class="flex items-center justify-center">
    <form 
      class="max-w-md w-full"
      @submit.prevent="register" 
      @keydown="form.onKeydown($event)">
      <t-card 
        :header="$t('register')" 
        class="shadow-sm"
      >
        <t-input-group
          :label="$t('name')"
          :status="form.errors.has('name') ? false : null"
          :feedback="form.errors.get('name')"
        >
          <t-input
            :disabled="form.busy"
            v-model="form.name"
            :status="form.errors.has('name') ? false : null"
            type="name"
            name="name"
            class="w-full"
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
            autocomplete="username"
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
            autocomplete="new-password"
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
            autocomplete="new-password"
            class="w-full"
          />
        </t-input-group>
        <t-input-group>
          <t-button 
            :disabled="form.busy"
            type="submit" 
            variant="primary"
          >
            <template v-if="form.busy">...</template>
            <template v-else>{{ $t('register') }}</template>
          </t-button>
          <login-with-github/>
        </t-input-group>
      </t-card>
    </form>
  </container>
</template>

<script>
import Form from 'vform'

export default {
  head () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async register () {
      try {
      // Register the user.
        const { data } = await this.form.post('/register')

        // Log in the user.
        const { data: { token } } = await this.form.post('/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      } catch (e) {
        if (e.response.status !== 422) {
          throw e
        }
      }
    }
  }
}
</script>
