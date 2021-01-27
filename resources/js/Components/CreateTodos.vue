<template>
  <div class="text-right">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="512"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          depressed
          small
          color="success"
          class="focus:outline-none"
          v-bind="attrs"
          v-on="on"
        >
          Create Todos
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="headline">
          Create Todo
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="title"
            color="success"
            label="Todo Title"
            hint="For example, testing todos one"
          ></v-text-field>
          <v-textarea
            v-model="description"
            rows="3"
            color="success"
          >
            <template v-slot:label>
              <div>
                Description <small>(optional)</small>
              </div>
            </template>
          </v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="focus:outline-none"
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Discard
          </v-btn>
          <v-btn
            class="focus:outline-none"
            color="green darken-1"
            text
            :loading="loading"
            :disabled="loading"
            @click="storeTodo"
          >
            Saved
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    name: 'CreateTodos',
    props: ['progress'],
    data () {
      return {
        dialog: false,
        title: '',
        description: '',
        // Loader
        loader: null,
        loading: false
      }
    },
    methods: {
      async storeTodo() {
        this.loader = 'loading'
        const l = this.loader
        this[l] = !this[l]
        await axios.post('/todos/store', {
          title: this.title,
          description: this.description,
          progress: this.progress
        }).then((result) => {
          this.$emit('newTodo', result.data.message)

          this.title = ''
          this.description = ''
          
          this[l] = false
          this.loader = null
          this.dialog = false
        }).catch((err) => {
          console.error(err)
        });
      }
    }
  }
</script>
<style lang="css">
  [type='text'], [type='email'], [type='url'], [type='password'], [type='number'], [type='date'], [type='datetime-local'], [type='month'], [type='search'], [type='tel'], [type='time'], [type='week'], [multiple], textarea, select {
    --tw-ring-shadow: none !important;
  }
  .custom-loader {
    animation: loader 1s infinite;
    display: flex;
  }
  @-moz-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-webkit-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-o-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>