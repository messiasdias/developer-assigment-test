<template>
<div class="app">
  <div class="app-top">
    <span v-if="this.page.index > 1" class="previus" @click="previusPage()">
      <i class="fas fa-chevron-circle-left"></i>
    </span>
    <img 
      v-for="(person, i) in persons" :key="i" 
      :src="person.img ? person.img : personImageDefault"
      :title="person.name"
      :class="{'active': personActive && personActive.id == person.id}"
      @click="jumpTo(person)"
    />
    <img class="active" v-if="persons.length === 0" :src="personImageDefault"/>
    <span v-if="this.page.hasNext" class="next" @click="nextPage()">
      <i class="fas fa-chevron-circle-right"></i>
    </span>
  </div>

  <div :class="`app-body ${persons.length === 0 ? 'empty' : ''}`">
    <template v-if="persons.length > 0" >
      <Item 
        v-for="(person, i) in persons" :key="i"
        :person="person"
        :id="`#person${person.id}`"
        @showOverlay="showOverlay = $event"
        @success="getPersons()"
        @error="getPersons()"
      />
    </template>

    <div v-if="persons.length === 0" >
      <i class="fas fa-exclamation-triangle" size="5x"></i>
      <p>Oops! No people added yet</p>
    </div>

    <Form 
      v-if="showFormAdd === true" 
      @success="getPersons()"
      @error="getPersons()"
      @cancel="showFormAdd = false"
    />
  </div>

  <div class="app-footer">
    <span class="app-add-btn" @click="addPerson()">
      <i class="fas fa-plus"></i>
    </span>
  </div>
  <div v-if="showOverlay" @click="$emit('overlayClick')" class="overlay" />
</div>
</template>
<script>
import Axios from 'axios'
import moment from 'moment'
import Swal from 'sweetalert2'
import Item from '@/components/person/Item'
import Form from '@/components/person/Form'
import Modal from '@/components/person/Modal'

export default {
  name: 'App',
  components: {
    Item,
    Form,
    Modal
  },
  data(){
    return {
      toast: Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      }),
      moment: moment,
      api: process.env.VUE_APP_API,
      secret: process.env.VUE_APP_API_SECRET,
      persons: [],
      showFormAdd: false,
      showOverlay: false, 
      showForm: false,
      showModal: false,
      personActive: null,
      personImageDefault: require('@/assets/person.png'),
      page: {
        index: 1,
        hasNext: false,
      }
    }
  },
  methods: {
    jumpTo(person){
      let elm = document.getElementById(`#person${person.id}`);
      elm.scrollIntoView();
      this.personActive = person
    },
    addPerson(){
      this.showFormAdd = true
    },
    handleSavePersonSuccess(){
      this.getPersons()
    },
    handleSavePersonError(){
      this.getPersons()
    },
    handleDeletePerson(person){
      this.personActive = null
      this.showModal = false
      this.persons = this.persons.filter(p => p.id !== person.id)
    },
    formatDate(date){
      return moment(date, "YYYYMMDD").format('DD/MM/YYYY')
    },
    previusPage(){
      if (this.page.index > 1) {
        this.page.index--
      }
    },
    nextPage(){
      if (this.page.index >= 1 && this.page.hasNext) {
        this.page.index++
      }
    },
    getPersons(){
      Axios.get(`${this.api}/person/${this.page.index}/18`)
      .then((response) => {
        this.persons = []
        this.page.hasNext = response.data.hasNext
        this.persons = Object.values(response.data.items)
      })
      .catch(() => {
        this.persons = []
      })
    },
    setAxiosInterceptors(){
      if (this.secret) {
        let secret = this.secret
        let api = this.api
  
        Axios.interceptors.request.use(function (config) {
          if (config.url.startsWith(api)) {
            config.headers.Authorization = secret
          } else {
            config.headers.Authorization = undefined
          }
          return config
        })

        Axios.interceptors.response.use(async (response) => {
          return Promise.resolve(response)
        }, (error) => {
          console.error(e)
          return Promise.reject(error)
        })
      }
    },
  },
  created(){
    this.setAxiosInterceptors()
    this.getPersons()
  },
  mounted() {
    this.$root.$on('msg' , function (payload) {
      Swal.fire(
        payload.title || '',
        payload.text,
        payload.type
      )
    })
  },
  watch: {
    showFormAdd(){
      this.showOverlay = this.showFormAdd
    },
    "page.index"(){
      this.getPersons()
    }
  }
}
</script>
