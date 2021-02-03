<template>
  <div>
    <button
      class="px-5 py-2 text-sm font-semibold tracking-wider bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none"
      v-on:click="visiting"
    >
      {{ title }}
      <span class="mdi mdi-arrow-right"></span>
    </button>
    <transition-page v-if="waitPage" />
  </div>
</template>
<script>
import TransitionPage from '@/Components/Loader/TransitionPage'
export default {
  components: {
    TransitionPage
  },
  props: ['url', 'title'],
  data() {
    return {
      waitPage: false
    }
  },
  methods: {
    visiting() {
      return this.$inertia.visit(this.url, {
        methods: 'get',
        data: {},
        replace: false,
        preserveState: false,
        preserveScroll: false,
        only: [],
        headers: {},
        errorBag: null,
        onBefore: visit => { this.waitPage = true },
        onSuccess: page => { this.waitPage = false },
      })
    }
  }
}
</script>