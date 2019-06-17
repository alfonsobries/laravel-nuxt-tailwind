<template>
  <nav :class="['flex', 'px-6', 'items-center', 'bg-white', 'border-b', 'border-gray-400', `h-${height}`]">
    <slot/>
  </nav>
</template>

<script>
export default {
  name: 'LayoutNavigation',

  props: {
    height: {
      type: String,
      default: '16'
    }
  }
}
</script>
