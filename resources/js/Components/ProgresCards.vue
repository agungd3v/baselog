<template>
  <content-layout>
    <v-card style="box-shadow: none !important">
      <v-toolbar
        flat
        color="primary"
        dark
      >
        <v-toolbar-title>Prgoress of workers</v-toolbar-title>
      </v-toolbar>
      <skeleton-loader v-if="loader" />
      <v-tabs v-else vertical>
        <v-tab
          v-for="(group, index) in todos"
          :key="index"
        >
          <v-icon left>
            mdi-account-group
          </v-icon>
          {{ group.name }}
        </v-tab>

        <v-tab-item
          v-for="(group, index) in todos"
          :key="index"
        >
          <v-card flat>
            <v-card-text>
              <table-todo :group="filterByGroup(group.id)" />
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs>
    </v-card>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import TableTodo from '@/Components/TableTodos'
import SkeletonLoader from '@/Components/Skeleton'
export default {
  components: {
    ContentLayout,
    TableTodo,
    SkeletonLoader
  },
  props: ['user'],
  data() {
    return {
      todos: [],
      loader: true
    }
  },
  mounted() {
    this.getTodos()
  },
  methods: {
    getTodos() {
      axios.get('/todo/json?created_by=' + this.user.id).then((result) => {
        this.todos = result.data.message
        this.loader = false
      }).catch((err) => {
        console.error(err)
      });
    },
    filterByGroup(groupId) {
      return this.todos.find(data => data.id === groupId)
    }
  }
}
</script>
<style lang="css">
  .v-tab {
    justify-content: flex-start;
  }
</style>