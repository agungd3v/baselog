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
        color="success"
        dark
        class="focus:outline-none"
        v-bind="attrs"
        v-on="on"
      >
        Update
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="headline">
        Change group title
      </v-card-title>
      <v-card-text>
        <v-text-field
          label="Group title"
          v-model="group.name"
        ></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="green darken-1"
          text
          class="focus:outline-none"
          @click="dialog = false"
        >
          Cancel
        </v-btn>
        <v-btn
          color="green darken-1"
          text
          class="focus:outline-none"
          @click="updateGroup"
        >
          Save Changes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    data () {
      return {
        dialog: false,
      }
    },
    props: ['group'],
    methods: {
      async updateGroup() {
        await axios.post('/groups/update', this.group).then((result) => {
          this.dialog = false
          this.$emit('groupUpdated', result.data.item)
        }).catch((err) => {
          console.error(err)
        });
      }
    }
  }
</script>