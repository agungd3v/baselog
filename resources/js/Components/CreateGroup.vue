<template>
  <content-layout>
    <div class="border-t">
      <v-simple-table
        fixed-header
        height="300px"
      >
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left" colspan="2">
                Name (Group title)
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(group, index) in reverseGroups"
              :key="index"
            >
              <td>{{ group.name }}</td>
              <td>
                <div class="flex justify-end items-center gap-2">
                  <update-group :group="group" @groupUpdated="groupChanges" />
                  <delete-group :group="group" @groupDeleted="groupDeleted" />
                </div>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <div class="flex items-center gap-4">
        <v-btn
          depressed
          small
          class="focus:outline-none mt-2"
          color="primary"
          :disabled="title == null || title == ''"
          @click="createGroup"
        >
          Create Group
        </v-btn>
        <v-text-field
          label="Create group title"
          class="mt-4"
          hint="Click on Create Group after type the title."
          v-model="title"
        ></v-text-field>
      </div>
    </div>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import UpdateGroup from '@/Components/UpdateGroup'
import DeleteGroup from '@/Components/DeleteGroup'
export default {
  components: {
    ContentLayout,
    UpdateGroup,
    DeleteGroup
  },
  props: ['userId'],
  data() {
    return {
      title: null,
      groups: []
    }
  },
  computed: {
    reverseGroups() {
      return [...this.groups].reverse()
    }
  },
  mounted() {
    this.getGroups()
  },
  methods: {
    async getGroups() {
      await axios.get('/groups').then((result) => {
        this.groups = result.data.message
        this.$emit('groups', result.data.message)
      }).catch((err) => {
        console.error(err)
      });
    },
    async createGroup() {
      await axios.post('/groups/create', {
        title: this.title,
        userId: this.userId
      }).then((result) => {
        this.title = null
        this.groups.push(result.data.message)
      }).catch((err) => {
        console.error(err)
      });
    },
    groupChanges(value) {
      const hasChanges = this.groups.find(data => data.id == value.id)
      hasChanges.name = value.name
    },
    groupDeleted(value) {
      return this.getGroups()
    }
  }
}
</script>
<style lang="css">
  .v-application--wrap {
    min-height: auto;
  }
  [type='text'], [type='email'], [type='url'], [type='password'], [type='number'], [type='date'], [type='datetime-local'], [type='month'], [type='search'], [type='tel'], [type='time'], [type='week'], [multiple], textarea, select {
    --tw-ring-shadow: none !important;
  }
</style>