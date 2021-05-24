<template>
<div class="app">
  <div class="app-top">
    <!--  v-if="this.pagination.index > 1" -->
    <span v-if="this.pagination.index > 1" class="previus" @click="previusPage()">
      <i class="fas fa-chevron-circle-left"></i>
       <small>{{this.pagination.index - 1 }}</small>
    </span>
    <div class="person-scroll">
        <span 
          v-for="(person, i) in persons" :key="i"
          :class="{'active': personActive && personActive.id == person.id}"
          @click="jumpTo(person)"
        >
          <img 
            :src="person.img ? person.img : personImageDefault"
            :title="person.name"
            :class="{'active': personActive && personActive.id == person.id}"
            @click="jumpTo(person)"
          />
          <small>{{person.name}}</small>
        </span>
        <img class="active" v-if="persons.length === 0 && !loading" :src="personImageDefault"/>
    </div>
    <span v-if="this.pagination.hasNext" class="next" @click="nextPage()">
      <i class="fas fa-chevron-circle-right"></i>
      <small>{{this.pagination.index + 1}}</small>
    </span>
  </div>


  <div v-if="loading === true" class="app-body empty">
    <Loading />
  </div>

  <div v-else :class="`app-body ${persons.length === 0 ? 'empty' : ''}`">
    <template v-if="persons.length > 0" >
      <Item 
        v-for="(person, i) in persons" :key="i"
        :person="person"
        :id="`#person${person.id}`"
        @showOverlay="showOverlay = $event"
        @success="getPersons()"
        @error="getPersons()"
        :class="{'active': personActive && personActive.id == person.id}"
      />
    </template>

    <div v-if="persons.length === 0 && !loading" >
      <i class="fas fa-exclamation-triangle" size="5x"></i>
      <p>Oops! No people added yet</p>
    </div>
     <Form
      @success="getPersons()"
      @error="getPersons()"
    />
  </div>

  <div class="app-footer">
    <a 
      href="#"
      class="app-add-btn" 
      data-bs-toggle="modal"
      data-bs-target="#addPerson"
    >
      <i class="fas fa-plus"></i>
    </a>
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
import Loading from '@/components/Loading.vue'

export default {
  name: 'App',
  components: {
    Item,
    Form,
    Modal,
    Loading
  },
  data(){
    return {
      loading: true,
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
      pagination: {
        index: 1,
        hasNext: false,
        perPage: 10,
        total: 1,
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
      if (this.pagination.index > 1) {
        this.pagination.index--
      }
    },
    nextPage(){
      if (this.pagination.index >= 1 && this.pagination.hasNext) {
        this.pagination.index++
      }
    },
    getPersons(){
      Axios.get(`${this.api}/person/${this.pagination.index}/${this.pagination.perPage}`)
      .then((response) => {
        this.persons = []
        this.pagination.hasNext = response.data.hasNext
        this.persons = Object.values(response.data.items)
        setTimeout(() => {this.loading = false}, 300)
      })
      .catch(() => {
        this.pagination.hasNext = false
        this.persons = []
        this.pagination.index = 1
        this.pagination.perPage = 10
        this.pagination.total = 1
        setTimeout(() => {this.loading = false}, 300)
      })
    },
    setAxiosInterceptors(){
      if (this.secret) {
        let secret = this.secret
        let api = this.api
  
        Axios.interceptors.request.use((config) => {
          if (config.url.startsWith(api)) {
            config.headers.Authorization = secret
          } else {
            config.headers.Authorization = undefined
          }
          return config
        })

        Axios.interceptors.response.use((response) => {
          return Promise.resolve(response)
        }, (error) => {
          return Promise.reject(error.response)
        })
      }
    },
  },
  beforeMount(){
    let pagination = localStorage.pagination
    if(pagination) {
      this.pagination = JSON.parse(pagination)
    }

    let personActive = localStorage.personActive
     if(personActive) {
      this.personActive = JSON.parse(personActive)
    }
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
    "pagination.index"(){
      this.getPersons()
      localStorage.pagination = JSON.stringify(this.pagination)
    },
    personActive(){
      this.getPersons()
      localStorage.personActive = JSON.stringify(this.personActive)
    }
  }
}
</script>
