<template>
  <div 
    :class="{
      'flex min-h-screen min-w-full': true,
      'flex-row': ! col,
      'flex-col': col,
  }">
    <slot/>
  </div>
</template>

<script>
export default {
  name: 'LayoutContainer',

  props: {
    col: {
      type: Boolean,
      default: false
    }
  },
}
</script>
