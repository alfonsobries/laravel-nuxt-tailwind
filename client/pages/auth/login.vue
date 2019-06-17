<template>
  <container class="flex items-center justify-center">
    <form 
      class="max-w-md w-full"
      @submit.prevent="login" 
      @keydown="form.onKeydown($event)">
      <t-card 
        :header="$t('login')" 
        class="shadow-sm"
      >
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

        <t-input-group>
          <t-button 
            :disabled="form.busy"
            type="submit" 
            variant="primary"
          >
            <template v-if="form.busy">...</template>
            <template v-else>{{ $t('login') }}</template>
          </t-button>

          <login-with-github/>
        </t-input-group>

        <div class="flex justify-between text-sm">
          <label
            for="remember_me"
            class="flex py-1 items-center"
          >
            <t-checkbox
              id="remember_me"
              :disabled="form.busy"
              v-model="remember"
              name="remember_me"
            />
            <span class="ml-3">{{ $t('remember_me') }}</span>
          </label>

          <router-link :to="{ name: 'password.request' }" >
            {{ $t('forgot_password') }}
          </router-link>
        </div>
      </t-card>
    </form>
  </container>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  head () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      this.form.post('/login')
        .then(this.handleLogin)
        .catch(({ response }) => {
          if (response.status !== 422) {
            throw e
          }
        });
    },

    async handleLogin({ data }) {
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
