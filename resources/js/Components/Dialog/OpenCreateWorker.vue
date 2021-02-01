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
        color="primary"
        dark
        class="focus:outline-none"
        v-bind="attrs"
        v-on="on"
      >
        Create Worker
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="headline">
        Create Worker
      </v-card-title>
      <validation-observer
        ref="observer"
        v-slot="{ invalid }"
      >
        <v-card-text>
          <form @submit.prevent="submit">
            <validation-provider
              v-slot="{ errors }"
              name="select"
              rules="required"
            >
              <v-select
                v-model="selectedGroup"
                :items="group"
                :menu-props="{ maxHeight: '400' }"
                :error-messages="errors"
                label="Group Worker"
                item-text="name"
                item-value="id"
                hint="Make sure you have created a group"
                persistent-hint
                required
              ></v-select>
            </validation-provider>
            <validation-provider
              v-slot="{ errors }"
              name="Name"
              rules="required|min:3"
            >
              <v-text-field
                v-model="name"
                :error-messages="errors"
                label="Name"
                required
              ></v-text-field>
            </validation-provider>
            <validation-provider
              v-slot="{ errors }"
              name="email"
              rules="required|email"
            >
              <v-text-field
                v-model="email"
                :error-messages="errors"
                label="E-mail"
                required
              ></v-text-field>
            </validation-provider>
            <validation-provider
              v-slot="{ errors }"
              name="password"
              rules="required|min:8"
            >
              <v-text-field
                v-model="password"
                :error-messages="errors"
                label="Password"
                type="password"
                required
              ></v-text-field>
            </validation-provider>
          </form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            class="focus:outline-none"
            @click="dialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            :disabled="invalid || name == '' || email == '' || password == '' || selectedGroup == null"
            color="primary"
            text
            class="focus:outline-none"
            @click="createWorker"
          >
            Save Changes
          </v-btn>
        </v-card-actions>
      </validation-observer>
    </v-card>
  </v-dialog>
</template>
<script>
import { required, email, min } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

extend('required', {
  ...required,
  message: '{_field_} can not be empty',
})

extend('min', {
  ...min,
  message: '{_field_} may not be greater than {length} characters',
})

extend('email', {
  ...email,
  message: 'Email must be valid',
})

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data: () => ({
    name: '',
    email: '',
    password: '',
    selectedGroup: null,
    dialog: false,
  }),
  props: ['groups'],
  computed: {
    group() {
      return this.groups
    }
  },
  methods: {
    async createWorker() {
      await axios.post('/workers/create', {
        name: this.name,
        email: this.email,
        password: this.password,
        iam: 'Worker',
        group: this.selectedGroup
      }).then((result) => {
        this.$emit('workerCreated', result.data.message)
        this.dialog = false
        this.clear()
      }).catch((err) => {
        console.err(err)
      })
    },
    clear () {
      this.name = ''
      this.email = ''
      this.password = ''
      this.selectedGroup = null
      this.$refs.observer.reset()
    }
  },
}
</script>
<style lang="css">
  .v-input .v-label {
    z-index: 1;
  }
</style>