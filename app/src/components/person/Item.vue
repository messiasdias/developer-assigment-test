<template>
 <div class="app-item">
    <img class="app-item-img" :src="person.img || personImageDefault"/>
    <div class="app-item-footer"> 
      <h3>{{person.name}}</h3>

      <small><b><i class="fas fa-city"></i></b> {{person.city}}</small>
      <small><b><i class="fas fa-birthday-cake"></i></b> {{ formatDate(person.dateOfBirth) }}</small>
      <small><b><i class="fas fa-phone"></i></b> {{person.phone}}</small>
      <small><b><i class="fa fa-at"></i></b> {{person.email}}</small>

      <div class="actions">
        <a @click="showForm = true" ><i class="fa fa-edit"></i></a>
        <a @click="showModal = true" ><i class="fas fa-trash"></i></a>
      </div>
    </div>

    <Form
      v-if="showForm === true" 
      :person="person"
      @success="$emit('success', $event)"
      @error="$emit('error', $event)"
      @cancel="showForm = false"
    />

    <Modal
      v-if="showModal === true"
      :person="person"
      @delete="$emit('success', $event)"
      @error="$emit('error', $event)"
      @cancel="showModal = false"
    />
</div>
</template>
<script>
import moment from 'moment'
import Form from '@/components/person/Form'
import Modal from '@/components/person/Modal'

export default {
  name: 'Item',
  props: {
    person: {
      type: Object,
      default: () => {
        return null
      }
    },
  },
  components: {
    Form,
    Modal
  },
  data(){
    return {
      api: process.env.VUE_APP_API,
      personImageDefault: require('@/assets/person.png'),
      showForm: false,
      showModal: false,
    }
  },
  methods: {
    formatDate(date){
      return moment(date, "YYYYMMDD").format('DD/MM/YYYY')
    },
  },
  watch: {
    showForm(){
      this.$emit('showOverlay', this.showForm)
    },
    showModal(){
      this.$emit('showOverlay', this.showModal)
    }
  },
  mounted(){
    this.$parent.$on('overlayClick', () => {
      this.showModal = false
      this.showForm = false
    })
  }
}
</script>