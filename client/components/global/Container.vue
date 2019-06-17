<template>
  <component 
    :is="tagName" 
    class="container mx-auto"
  >
    <slot/>
  </component>
</template>

<script>
export default {
  name: 'Container',
  props: {
    tagName: {
      type: String,
      default: 'div'
    }
  }
}
</script>
