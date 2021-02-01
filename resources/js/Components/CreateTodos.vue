<template>
  <div class="text-left">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="512"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          depressed
          small
          color="white"
          class="focus:outline-none shadow"
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
          <v-combobox
            v-model="selectedAssign"
            :items="anyUsers"
            item-text="name"
            item-value="id"
            label="Assign To"
            color="success"
            clearable
            chips
          >
            <template v-slot:selection="data">
              <v-chip
                :key="JSON.stringify(data.item)"
                v-bind="data.attrs"
                :input-value="data.selected"
                :disabled="data.disabled"
                @click:close="data.parent.selectItem(data.item)"
              >
                <v-avatar
                  class="success white--text"
                  left
                  v-text="data.item.name.slice(0, 1).toUpperCase()"
                ></v-avatar>
                {{ data.item.name }}
              </v-chip>
            </template>
          </v-combobox>
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
          <v-label>Due Date</v-label>
          <v-radio-group
            v-model="dueDate"
            class="mt-1"
            mandatory
            row
          >
            <v-radio
              label="No specific date"
              color="success"
              :value="false"
            ></v-radio>
            <v-radio
              label="Set specific date"
              color="success"
              :value="true"
              @click="openDate(true)"
            ></v-radio>
            <div
              v-if="dueDate"
              class="flex justify-end items-center text-sm"
            >
              <v-icon color="success">mdi-calendar</v-icon>
              <span class="ml-1 text-success">{{ selectedDate }}</span>
            </div>
          </v-radio-group>
        </v-card-text>
        <!-- <v-divider></v-divider> -->
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
            :disabled="loading || title == ''"
            @click="storeTodo"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
      <v-dialog
        v-model="dialogDueDate"
        max-width="290"
      >
        <v-card>
          <v-date-picker v-model="selectedDate" color="success" class="focus:outline-none"></v-date-picker>
        </v-card>
      </v-dialog>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    name: 'CreateTodos',
    props: ['progress', 'anyUsers'],
    data () {
      return {
        // dialog
        dialog: false,
        dialogDueDate: false,
        // data
        title: '',
        description: '',
        selectedAssign: null,
        selectedDate: new Date().toISOString().substr(0, 10),
        dueDate: false,
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
          progress: this.progress,
          assign: this.selectedAssign,
          duedate: this.dueDate ? this.selectedDate : null
        }).then((result) => {
          this.$emit('newTodo', result.data.message)

          this.title = ''
          this.description = ''
          this.selectedAssign = null
          this.dueDate = false
          
          this[l] = false
          this.loader = null
          this.dialog = false
        }).catch((err) => {
          console.error(err)
        })
      },
      openDate(open) {
        return this.dialogDueDate = open
      }
    }
  }
</script>
<style lang="css">
  [type='text'], [type='email'], [type='url'], [type='password'], [type='number'], [type='date'], [type='datetime-local'], [type='month'], [type='search'], [type='tel'], [type='time'], [type='week'], [multiple], textarea, select {
    --tw-ring-shadow: none !important;
  }
  .v-input .v-label {
    z-index: 1;
  }
  .v-btn.v-btn--active.v-btn--rounded:focus,
  .v-btn.v-btn--active.v-btn--rounded:active,
  .v-btn.v-btn--active.v-btn--rounded {
    outline: none !important;
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