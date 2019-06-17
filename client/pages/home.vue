<template>
  <container>
    <t-card 
      :header="$t('home')" 
      class="container">
      {{ $t('you_are_logged_in') }}
    </t-card>
  </container>
</template>

<script>
export default {
  middleware: 'auth',

  head () {
    return { title: this.$t('home') }
  }
}
</script>
