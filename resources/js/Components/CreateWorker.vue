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
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Email
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(worker, index) in reverseWorkers"
              :key="index"
            >
              <td>{{ worker.name }}</td>
              <td>{{ worker.email }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <div class="flex items-center gap-4">
        <open-create-worker :groups="needGroups" @workerCreated="newWorker" />
      </div>
    </div>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import OpenCreateWorker from '@/Components/Dialog/OpenCreateWorker'
export default {
  components: {
    ContentLayout,
    OpenCreateWorker
  },
  data() {
    return {
      workers: [],
      dialog: false
    }
  },
  props: ['needGroups', 'groupingWorker'],
  computed: {
    reverseWorkers() {
      return [...this.workers.filter(data => data.group.created_by == this.groupingWorker.id)].reverse()
    }
  },
  mounted(){
    this.getWorkers()
  },
  methods: {
    async getWorkers() {
      await axios.get('/workers').then((result) => {
        this.workers = result.data.message
      }).catch((err) => {
        console.error(err)
      });
    },
    newWorker(value) {
      return this.getWorkers()
    }
  }
}
</script>
<style lang="css">
  .v-application--wrap {
    min-height: auto;
  }
</style>