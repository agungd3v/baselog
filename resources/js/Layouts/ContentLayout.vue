<template>
  <v-app>
    <slot />
  </v-app>
</template>
<script>
export default {
  name: 'ContentLayout'
}
</script>
<style lang="css">
  html {
    overflow-y: auto !important;
  }
</style>