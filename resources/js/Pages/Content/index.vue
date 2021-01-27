<template>
  <content-layout>
    <h2 class="text-3xl font-semibold text-center my-5">BaseLog</h2>
    <div class="flex gap-4 mx-5 overflow-x-auto">
      <div>
        <div class="border-b py-1 px-2 mb-3 relative">
          To Do
          <div class="count-items absolute bg-white text-xs">{{ toDo.length }}</div>
        </div>
        <div
          class="w-full flex h-20 flex-col gap-3"
          style="width: 300px"
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
          >
            <h6 class="font-semibold leading-4">{{ item.title }}</h6>
            <span class="text-xs text-gray-600">{{ item.description }}</span>
          </div>
          <div class="create-todos">
            <create-todos :progress="1" @newTodo="entryTodo" />
          </div>
        </div>
      </div>
      <div>
        <div class="border-b py-1 px-2 mb-3 relative">
          Backlog
          <div class="count-items absolute bg-white text-xs">{{ backLog.length }}</div>
        </div>
        <div
          class="w-full flex h-20 flex-col gap-3"
          style="width: 300px"
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
          >
            <h6 class="font-semibold leading-4">{{ item.title }}</h6>
            <span class="text-xs text-gray-600">{{ item.description }}</span>
          </div>
          <div class="create-todos">
            <create-todos :progress="2" @newTodo="entryTodo" />
          </div>
        </div>
      </div>
      <div>
        <div class="border-b py-1 px-2 mb-3 relative">
          In Progress
          <div class="count-items absolute bg-white text-xs">{{ inProgress.length }}</div>
        </div>
        <div
          class="w-full flex h-20 flex-col gap-3"
          style="width: 300px"
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
          >
            <h6 class="font-semibold leading-4">{{ item.title }}</h6>
            <span class="text-xs text-gray-600">{{ item.description }}</span>
          </div>
          <div class="create-todos">
            <create-todos :progress="3" @newTodo="entryTodo" />
          </div>
        </div>
      </div>
      <div>
        <div class="border-b py-1 px-2 mb-3 relative">
          Complete
          <div class="count-items absolute bg-white text-xs">{{ complete.length }}</div>
        </div>
        <div
          class="w-full flex h-20 flex-col gap-3"
          style="width: 300px"
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
          >
            <h6 class="font-semibold leading-4">{{ item.title }}</h6>
            <span class="text-xs text-gray-600">{{ item.description }}</span>
          </div>
          <div class="create-todos">
            <create-todos :progress="4" @newTodo="entryTodo" />
          </div>
        </div>
      </div>
    </div>
  </content-layout>
</template>
<script>
import ContentLayout from '@/Layouts/ContentLayout'
import CreateTodos from '@/Components/CreateTodos'
export default {
  components: {
    ContentLayout,
    CreateTodos
  },
  props: ['todolists'],
  data() {
    return {}
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
</style>