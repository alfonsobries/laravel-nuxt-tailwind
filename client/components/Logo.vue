<template>
  <span :class="['font-sans', 'text-black', `text-${fontSize}`]">
    {{ alt }}
  </span>
</template>

<script>
export default{
  props: {
    alt: {
      type: String,
      default: null,
    },
    fontSize: {
      type: String,
      default: 'xl'
    }
  }
}
</script>