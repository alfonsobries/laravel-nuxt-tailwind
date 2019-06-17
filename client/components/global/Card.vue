<template>
  <div class="border bg-white">
    <slot/>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: {
      type: String,
      default: null
    }
  }
}
</script>
