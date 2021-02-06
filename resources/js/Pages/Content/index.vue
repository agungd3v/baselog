<template>
  <content-layout>
    <div class="h-screen overflow-y-hidden" style="background-color: rgba(243, 244, 246, 1)">
      <div class="my-5 px-5 flex justify-between items-center">
        <div class="flex items-center">
          <img src="/baseicon.png" alt="baseicon" class="w-8 mr-1">
          <a href="/" class="text-2xl black--text">BaseLog</a>
          <div class="bg-white rounded shadow-sm ml-3 pl-3">
            <div class="flex items-center">
              <span class="mdi mdi-filter text-sm"></span>
              <label for="filter" class="text-xs cursor-pointer ml-1">Filters</label>
              <v-combobox
                id="filter"
                class="custom-opts"
                v-model="filterBy"
                :items="usersofgroup.user"
                item-text="name"
                item-value="id"
                :deletable-chips="true"
                :hide-selected="true"
                :hide-details="true"
                flat
                dense
                small-chips
                solo
              >
              </v-combobox>
            </div>
          </div>
        </div>
        <div class="">
          <div class="flex items-center">
            <v-menu
              transition="slide-x-transition"
              bottom
              right
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  class="focus:outline-none px-1"
                  small
                  text
                  v-bind="attrs"
                  v-on="on"
                >
                  {{ user.name }}
                </v-btn>
              </template>

              <v-list subheader>
                <v-subheader>
                  <v-icon color="#f4ff1f" small>
                    mdi-star
                  </v-icon>
                  <span>{{ user.name }}</span>
                </v-subheader>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-avatar style="margin-right: 5px; min-width: 30px; height: 30px; width: 30px">
                    <v-icon
                      class="bg-blue-400"
                      dark
                      small
                    >
                      mdi-login-variant
                    </v-icon>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title class="cursor-pointer" @click="logout">Logout</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-menu>
            <div class="w-8 h-8 rounded-full bg-white flex justify-center items-center">
              <img :src="user.profile_photo_url" :alt="user.name" class="w-6 rounded-full">
            </div>
          </div>
        </div>
      </div>
      <div class="flex gap-4 mx-5 overflow-x-auto" style="height: 90vh">
        <div>
          <div
            class="border-b py-1 mb-3 relative"
          >
            <small class="font-semibold">{{ usersofgroup.name }} <sup class="primary--text font-normal">({{ usersofgroup.user.length }})</sup></small>
          </div>
          <div class="w-full py-1">
            <div
              v-for="(user, index) in usersofgroup.user"
              :key="index"
              style="width: 125px"
              class="px-1 py-1 truncate text-sm text-gray-500"
            >
              <img :src="user.profile_photo_url" :alt="user.name" class="w-8 h-8 rounded-full inline-block mr-1">
              {{ user.name }}
            </div>
          </div>
        </div>
        <div>
          <div class="border-b py-1 px-2 mb-3 relative">
            To Do
            <div class="count-items absolute text-xs" style="background-color: rgba(243, 244, 246, 1)">{{ toDo.length }}</div>
          </div>
          <div class="create-todos px-1 mb-2">
            <create-todos :progress="1" :anyUsers="usersofgroup.user" @newTodo="entryTodo" />
          </div>
          <div
            class="w-full flex h-20 flex-col gap-3 py-1 px-1 overflow-y-auto"
            style="width: 300px; height: 70vh"
            @drop="onDrop($event, 1)"
            @dragover.prevent
            @dragenter.prevent
          >
            <div
              v-for="(item, index) in toDo"
              :key="index"
              class="card px-5 py-2 bg-white rounded shadow cursor-pointer"
              draggable
              @dragstart="onDrag($event, item)"
              @click="updateOpen(item)"
            >
              <div class="flex items-center justify-between mb-3 mt-1">
                <div v-if="item.due_date != null" class="w-8 h-8 border rounded overflow-hidden">
                  <div class="text-center font-semibold bg-blue-600 text-white" style="font-size: 10px">{{ convertMonth(item.due_date.split('-')[1].toString()) }}</div>
                  <div class="text-center font-semibold bg-blue-200" style="font-size: 10px">{{ item.due_date.split('-')[2].toString() }}</div>
                </div>
                <span class="text-xs text-gray-400">{{ usersofgroup.name }}</span>
              </div>
              <h6 class="font-semibold leading-4 my-1">{{ item.title }}</h6>
              <div
                v-if="item.assign_to != null"
                class="text-xs text-gray-500 my-2"
              >
                <div
                  v-for="(user, index) in usersofgroup.user"
                  :key="index"
                >
                  <div
                    v-if="user.id === item.assign_to"
                    style="width: 250px"
                    class="truncate"
                  >
                    <img
                      :src="user.profile_photo_url"
                      :alt="user.name"
                      class="w-6 h-6 mb-1 rounded-full inline-block mr-1"
                    />
                    {{ user.name }} 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="border-b py-1 px-2 mb-3 relative">
            Backlog
            <div class="count-items absolute text-xs" style="background-color: rgba(243, 244, 246, 1)">{{ backLog.length }}</div>
          </div>
          <div class="create-todos px-1 mb-2">
            <create-todos :progress="2" :anyUsers="usersofgroup.user" @newTodo="entryTodo" />
          </div>
          <div
            class="w-full flex h-20 flex-col gap-3 py-1 px-1 overflow-y-auto"
            style="width: 300px; height: 70vh"
            @drop="onDrop($event, 2)"
            @dragover.prevent
            @dragenter.prevent
          >
            <div
              v-for="(item, index) in backLog"
              :key="index"
              class="card px-5 py-2 bg-white rounded shadow cursor-pointer"
              draggable
              @dragstart="onDrag($event, item)"
              @click="updateOpen(item)"
            >
              <div class="flex items-center justify-between mb-3 mt-1">
                <div v-if="item.due_date != null" class="w-8 h-8 border rounded overflow-hidden">
                  <div class="text-center font-semibold bg-blue-600 text-white" style="font-size: 10px">{{ convertMonth(item.due_date.split('-')[1].toString()) }}</div>
                  <div class="text-center font-semibold bg-blue-200" style="font-size: 10px">{{ item.due_date.split('-')[2].toString() }}</div>
                </div>
                <span class="text-xs text-gray-400">{{ usersofgroup.name }}</span>
              </div>
              <h6 class="font-semibold leading-4 my-1">{{ item.title }}</h6>
              <div
                v-if="item.assign_to != null"
                class="text-xs text-gray-500 my-2"
              >
                <div
                  v-for="(user, index) in usersofgroup.user"
                  :key="index"
                >
                  <div
                    v-if="user.id === item.assign_to"
                    style="width: 250px"
                    class="truncate"
                  >
                    <img
                      :src="user.profile_photo_url"
                      :alt="user.name"
                      class="w-6 h-6 mb-1 rounded-full inline-block mr-1"
                    />
                    {{ user.name }} 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="border-b py-1 px-2 mb-3 relative">
            In Progress
            <div class="count-items absolute text-xs" style="background-color: rgba(243, 244, 246, 1)">{{ inProgress.length }}</div>
          </div>
          <div class="create-todos px-1 mb-2">
            <create-todos :progress="3" :anyUsers="usersofgroup.user" @newTodo="entryTodo" />
          </div>
          <div
            class="w-full flex h-20 flex-col gap-3 py-1 px-1 overflow-y-auto"
            style="width: 300px; height: 70vh"
            @drop="onDrop($event, 3)"
            @dragover.prevent
            @dragenter.prevent
          >
            <div
              v-for="(item, index) in inProgress"
              :key="index"
              class="card px-5 py-2 rounded bg-white shadow cursor-pointer"
              draggable
              @dragstart="onDrag($event, item)"
              @click="updateOpen(item)"
            >
              <div class="flex items-center justify-between mb-3 mt-1">
                <div v-if="item.due_date != null" class="w-8 h-8 border rounded overflow-hidden">
                  <div class="text-center font-semibold bg-blue-600 text-white" style="font-size: 10px">{{ convertMonth(item.due_date.split('-')[1].toString()) }}</div>
                  <div class="text-center font-semibold bg-blue-200" style="font-size: 10px">{{ item.due_date.split('-')[2].toString() }}</div>
                </div>
                <span class="text-xs text-gray-400">{{ usersofgroup.name }}</span>
              </div>
              <h6 class="font-semibold leading-4 my-1">{{ item.title }}</h6>
              <div
                v-if="item.assign_to != null"
                class="text-xs text-gray-500 my-2"
              >
                <div
                  v-for="(user, index) in usersofgroup.user"
                  :key="index"
                >
                  <div
                    v-if="user.id === item.assign_to"
                    style="width: 250px"
                    class="truncate"
                  >
                    <img
                      :src="user.profile_photo_url"
                      :alt="user.name"
                      class="w-6 h-6 mb-1 rounded-full inline-block mr-1"
                    />
                    {{ user.name }} 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="border-b py-1 px-2 mb-3 relative">
            Complete
            <div class="count-items absolute text-xs" style="background-color: rgba(243, 244, 246, 1)">{{ complete.length }}</div>
          </div>
          <div
            class="w-full flex h-20 flex-col gap-3 py-1 px-1 overflow-y-auto"
            style="width: 300px; height: 70vh"
            @drop="onDrop($event, 4)"
            @dragover.prevent
            @dragenter.prevent
          >
            <div
              v-for="(item, index) in complete"
              :key="index"
              class="card px-5 py-2 rounded bg-white shadow cursor-pointer"
              draggable
              @dragstart="onDrag($event, item)"
              @click="updateOpen(item)"
            >
              <div class="flex items-center justify-between mb-3 mt-1">
                <div v-if="item.due_date != null" class="w-8 h-8 border rounded overflow-hidden">
                  <div class="text-center font-semibold bg-blue-600 text-white" style="font-size: 10px">{{ convertMonth(item.due_date.split('-')[1].toString()) }}</div>
                  <div class="text-center font-semibold bg-blue-200" style="font-size: 10px">{{ item.due_date.split('-')[2].toString() }}</div>
                </div>
                <span class="text-xs text-gray-400">{{ usersofgroup.name }}</span>
              </div>
              <h6 class="font-semibold leading-4 my-1">{{ item.title }}</h6>
              <div
                v-if="item.assign_to != null"
                class="text-xs text-gray-500 my-2"
              >
                <div
                  v-for="(user, index) in usersofgroup.user"
                  :key="index"
                >
                  <div
                    v-if="user.id === item.assign_to"
                    style="width: 250px"
                    class="truncate"
                  >
                    <img
                      :src="user.profile_photo_url"
                      :alt="user.name"
                      class="w-6 h-6 mb-1 rounded-full inline-block mr-1"
                    />
                    {{ user.name }} 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <update-todos :dialogOpen="openDialogUpdate" :dataTodo="existUpdate" :dataUser="usersofgroup.user" @closeUpdate="updateClose" />
        <div
          v-if="loader"
          class="fixed w-full h-screen top-0 left-0 px-5"
        >
          <transition-loader />
        </div>
      </div>
    </div>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import CreateTodos from '@/Components/CreateTodos'
import UpdateTodos from '@/Components/UpdateTodos'
import TransitionLoader from '@/Components/Loader/TransitionLoader'
export default {
  components: {
    ContentLayout,
    CreateTodos,
    UpdateTodos,
    TransitionLoader
  },
  props: ['todolists', 'usersofgroup', 'user'],
  data() {
    return {
      openDialogUpdate: false,
      existUpdate: {},
      loader: false,
      filterBy: null,
    }
  },
  computed: {
    toDo() {
      if (this.filterBy === null) return this.todolists.filter(data => data.progress === 1)
      return this.todolists.filter(data => data.progress === 1 && data.assign_to === this.filterBy.id)
    },
    backLog() {
      if (this.filterBy === null) return this.todolists.filter(data => data.progress === 2)
      return this.todolists.filter(data => data.progress === 2 && data.assign_to === this.filterBy.id)
    },
    inProgress() {
      if (this.filterBy === null) return this.todolists.filter(data => data.progress === 3)
      return this.todolists.filter(data => data.progress === 3 && data.assign_to === this.filterBy.id)
    },
    complete() {
      if (this.filterBy === null) return this.todolists.filter(data => data.progress === 4)
      return this.todolists.filter(data => data.progress === 4 && data.assign_to === this.filterBy.id)
    }
  },
  methods: {
    onDrag(evt, item) {
      evt.dataTransfer.dropEffect = 'move'
      evt.dataTransfer.effectAllowed = 'move'
      evt.dataTransfer.setData('id', item.id)
    },
    onDrop(evt, list) {
      this.loader = true
      const itemId = evt.dataTransfer.getData('id')
      const item = this.todolists.find(item => item.id == itemId)
      item.progress = list
      return this.changeTodo(item)
    },
    async changeTodo(obj) {
      await axios.post('/todos/changetodos', obj).then((result) => {
        this.loader = false
      }).catch((err) => {
        console.error(err)
      });
    },
    updateOpen(value) {
      this.openDialogUpdate = true
      this.existUpdate = value
    },
    updateClose(value) {
      this.openDialogUpdate = value
      this.existUpdate = {}
    },
    entryTodo(newValue) {
      return this.todolists.push(newValue)
    },
    convertMonth(entry) {
      if (entry == '01' || entry == '1') return 'Jan'
      if (entry == '02' || entry == '2') return 'Feb'
      if (entry == '03' || entry == '3') return 'Mar'
      if (entry == '04' || entry == '4') return 'Apr'
      if (entry == '05' || entry == '5') return 'May'
      if (entry == '06' || entry == '6') return 'Jun'
      if (entry == '07' || entry == '7') return 'Jul'
      if (entry == '08' || entry == '8') return 'Aug'
      if (entry == '09' || entry == '9') return 'Sep'
      if (entry == '10') return 'Oct'
      if (entry == '11') return 'Nov'
      if (entry == '12') return 'Dec'
    },
    logout() {
      this.$inertia.post(route('logout'));
    }
  }
}
</script>
<style lang="css">
  .count-items {
    bottom: -9px;
    right: 0;
    padding-left: 5px;
  }
  /* Scrollbar */

  /* Works on Firefox */
  * {
    scrollbar-width: thin;
    scrollbar-color: rgb(217, 221, 230) transparent;
  }

  /* Works on Chrome, Edge, and Safari */
  *::-webkit-scrollbar {
    width: 5px;
  }

  *::-webkit-scrollbar-track {
    background: transparent;
  }

  *::-webkit-scrollbar-thumb {
    background-color: rgb(217, 221, 230);
    border-radius: 10px;
    border: 1px solid transparent;
  }

  .custom-opts .v-input__control .v-input__slot .v-select__slot .v-select__selections input {
    min-width: 0 !important;
    width: 0 !important;
  }
  .custom-opts .v-input__control .v-input__slot:hover {
    cursor: pointer !important;
  }
</style>