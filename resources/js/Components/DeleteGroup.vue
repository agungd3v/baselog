<template>
  <v-dialog
    v-model="dialog"
    persistent
    max-width="310"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        depressed
        small
        color="error"
        dark
        class="focus:outline-none"
        v-bind="attrs"
        v-on="on"
      >
        Delete
      </v-btn>
    </template>
    <div class="text-center">
      <v-sheet
        class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block"
        color="blue-grey darken-3"
        dark
      >
        <div class="grey--text text--lighten-1 text-body-2 mb-4">
          Are you sure you want to delete this group?
        </div>

        <v-btn
          :disabled="loading"
          class="ma-1 focus:outline-none"
          color="grey"
          plain
        >
          Cancel
        </v-btn>

        <v-btn
          :loading="loading"
          class="ma-1 focus:outline-none"
          color="error"
          plain
          @click="remove"
        >
          Delete
        </v-btn>
      </v-sheet>
    </div>
  </v-dialog>
</template>
<script>
  export default {
    data () {
      return {
        dialog: false,
        loading: false
      }
    },
    props: ['group'],
    methods: {
      async remove () {
        this.loading = true
        
        await axios.post('/groups/clear', this.group).then((result) => {
          this.$emit('groupDeleted', 'ok')

          new Promise(resolve => setTimeout(resolve, 1000))
          
          this.loading = false
          this.dialog = false
          
        }).catch((err) => {
          console.error(err)
        });

      },
    }
  }
</script>