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
          <v-combobox
            v-model="selectedAssign"
            :items="dataUser"
            item-text="name"
            item-value="id"
            label="Assign To"
            color="primary"
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
                  class="primary white--text"
                  left
                  v-text="data.item.name.slice(0, 1).toUpperCase()"
                ></v-avatar>
                {{ data.item.name }}
              </v-chip>
            </template>
          </v-combobox>
          <v-text-field
            v-model="cardExist.title"
            color="primary"
            label="Todo Title"
            hint="For example, testing todos one"
          ></v-text-field>
          <v-textarea
            v-model="cardExist.description"
            rows="3"
            color="primary"
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
              color="primary"
              :value="false"
            ></v-radio>
            <v-radio
              label="Set specific date"
              color="primary"
              :value="true"
              @click="openDate(true)"
            ></v-radio>
            <div
              v-if="dueDate"
              class="flex justify-end items-center text-sm"
            >
              <v-icon color="primary">mdi-calendar</v-icon>
              <span class="ml-1 text-primary">{{ new Date(cardExist.due_date).toISOString().substr(0, 10) }}</span>
            </div>
          </v-radio-group>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="focus:outline-none"
            color="primary darken-1"
            text
            @click="closeUpdate(false)"
          >
            Discard
          </v-btn>
          <v-btn
            class="focus:outline-none"
            color="primary darken-1"
            text
            :loading="loading"
            :disabled="loading"
            @click="updateTodo"
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
          <v-date-picker v-model="cardExist.due_date" color="primary" class="focus:outline-none"></v-date-picker>
        </v-card>
      </v-dialog>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    name: 'CreateTodos',
    props: ['dialogOpen', 'dataTodo', 'dataUser'],
    data () {
      return {
        // dialog
        dialog: false,
        dialogDueDate: false,
        // data
        cardExist: {},
        selectedAssign: null,
        selectedDueDate: new Date().toISOString().substr(0, 10),
        dueDate: false,
        // Loader
        loader: null,
        loading: false
      }
    },
    watch: {
      dialogOpen(open) {
        if (open != this.dialog) return this.dialog = !this.dialog
      },
      dataTodo(v) {
        this.cardExist = v
        this.selectedAssign = this.dataUser.find(data => data.id === this.cardExist.assign_to ? data : null)
        if (this.cardExist.due_date != null) {
          this.dueDate = true
        } else {
          this.dueDate = false
        }
      },
      dueDate(tf) {
        if (tf) return this.cardExist.due_date == null ? this.cardExist.due_date = this.selectedDueDate : this.selectedDueDate = this.cardExist.due_date
        this.cardExist.due_date = null
      },
      selectedAssign(sa) {
        if (sa == null) return this.cardExist.assign_to = null
        this.cardExist.assign_to = this.selectedAssign.id
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