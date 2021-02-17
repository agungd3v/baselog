<template>
  <content-layout>
    <v-card>
      <v-card-title>
        {{ group.name }}
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="users.user"
        :search="search"
        :items-per-page="5"
      ></v-data-table>
    </v-card>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
export default {
  components: {
    ContentLayout
  },
  props: ['group'],
  data() {
    return {
      users: [],
      search: '',
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'In todo', value: 'in_todo' },
        { text: 'In backlog', value: 'in_backlog' },
        { text: 'In Progress', value: 'in_progress' },
        { text: 'In Complete', value: 'in_complete' },
        { text: 'Total of todo', value: 'todo.length' }
      ],
    }
  },
  mounted() {
    this.filterTodo()
  },
  methods: {
    filterTodo() {
      this.group.user.forEach(user => {
        user.in_todo = user.todo.filter(data => data.progress === 1).length
        user.in_backlog = user.todo.filter(data => data.progress === 2).length
        user.in_progress = user.todo.filter(data => data.progress === 3).length
        user.in_complete = user.todo.filter(data => data.progress === 4).length
      })
      this.users = this.group
    }
  }
}
</script>
<style lang="css">
</style>