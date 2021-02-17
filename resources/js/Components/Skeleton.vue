<template>
  <content-layout>
    <v-sheet
      :color="`grey ${theme.isDark ? 'darken-2' : 'lighten-4'}`"
      class="pa-3"
    >
      <v-skeleton-loader
        class="mx-auto"
        max-width="100%"
        type="card"
      ></v-skeleton-loader>
    </v-sheet>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
export default {
  components: {
    ContentLayout,
  },
  inject: {
    theme: {
      default: { isDark: false },
    },
  },
}
</script>