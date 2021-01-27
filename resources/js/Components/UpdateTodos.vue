<template>
  <div class="text-right">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="512"
    >
      <v-card>
        <v-card-title class="headline">
          Update Todo
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="cardExist.title"
            color="success"
            label="Todo Title"
            hint="For example, testing todos one"
          ></v-text-field>
          <v-textarea
            v-model="cardExist.description"
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
            @click="closeUpdate(false)"
          >
            Discard
          </v-btn>
          <v-btn
            class="focus:outline-none"
            color="green darken-1"
            text
            :loading="loading"
            :disabled="loading"
            @click="updateTodo"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    name: 'CreateTodos',
    props: ['dialogOpen', 'data'],
    data () {
      return {
        dialog: false,
        cardExist: {},
        // Loader
        loader: null,
        loading: false
      }
    },
    watch: {
      dialogOpen(open) {
        if (open != this.dialog) return this.dialog = !this.dialog
      },
      data(v) {
        return this.cardExist = v
      }
    },
    methods: {
      async updateTodo() {
        this.loader = 'loading'
        const l = this.loader
        this[l] = !this[l]
        await axios.post('/todos/updatetodos', this.cardExist).then((result) => {
          this[l] = false
          this.loader = null
          this.closeUpdate(false)
        }).catch((err) => {
          console.error(err)
        });
      },
      closeUpdate(value) {
        return this.$emit('closeUpdate', value)
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