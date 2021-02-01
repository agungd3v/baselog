<template>
  <content-layout>
    <h2 class="text-3xl font-semibold text-center my-5">BASELOG</h2>
    <div class="flex gap-4 mx-5 overflow-x-auto">
      <div>
        <div
          class="border-b py-1 mb-3 relative"
        >
          <small class="font-semibold">{{ usersofgroup.name }} <sup class="success--text font-normal">({{ usersofgroup.user.length }})</sup></small>
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
          <div class="count-items absolute bg-white text-xs">{{ toDo.length }}</div>
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
          <div class="count-items absolute bg-white text-xs">{{ backLog.length }}</div>
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
          <div class="count-items absolute bg-white text-xs">{{ inProgress.length }}</div>
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
            class="card px-5 py-2 rounded shadow cursor-pointer"
            draggable
            @dragstart="onDrag($event, item)"
            @click="updateOpen(item)"
          >
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
          <div class="count-items absolute bg-white text-xs">{{ complete.length }}</div>
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
            class="card px-5 py-2 rounded shadow cursor-pointer"
            draggable
            @dragstart="onDrag($event, item)"
            @click="updateOpen(item)"
          >
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
    </div>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import CreateTodos from '@/Components/CreateTodos'
import UpdateTodos from '@/Components/UpdateTodos'
export default {
  components: {
    ContentLayout,
    CreateTodos,
    UpdateTodos
  },
  props: ['todolists', 'usersofgroup'],
  data() {
    return {
      openDialogUpdate: false,
      existUpdate: {}
    }
  },
  computed: {
    toDo() {
      return this.todolists.filter(data => data.progress === 1)
    },
    backLog() {
      return this.todolists.filter(data => data.progress === 2)
    },
    inProgress() {
      return this.todolists.filter(data => data.progress === 3)
    },
    complete() {
      return this.todolists.filter(data => data.progress === 4)
    }
  },
  methods: {
    onDrag(evt, item) {
      evt.dataTransfer.dropEffect = 'move'
      evt.dataTransfer.effectAllowed = 'move'
      evt.dataTransfer.setData('id', item.id)
    },
    onDrop(evt, list) {
      const itemId = evt.dataTransfer.getData('id')
      const item = this.todolists.find(item => item.id == itemId)
      item.progress = list
      return this.changeTodo(item)
    },
    async changeTodo(obj) {
      await axios.post('/todos/changetodos', obj).then((result) => {
        console.log(result)
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
    scrollbar-color: #EBF4FF transparent;
  }

  /* Works on Chrome, Edge, and Safari */
  *::-webkit-scrollbar {
    width: 5px;
  }

  *::-webkit-scrollbar-track {
    background: transparent;
  }

  *::-webkit-scrollbar-thumb {
    background-color: #EBF4FF;
    border-radius: 10px;
    border: 1px solid transparent;
  }
</style>