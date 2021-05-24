<template>
 <div class="app-item">
    <img class="app-item-img" :src="person.img ? person.img : personImageDefault"/>
    <div class="app-item-footer"> 
      <h3>{{person.name}}</h3>

      <small><b><i class="fas fa-city"></i></b> {{person.city}}</small>
      <small><b><i class="fas fa-birthday-cake"></i></b> {{ formatDate(person.dateOfBirth) }}</small>
      <small><b><i class="fas fa-phone"></i></b> {{person.phone}}</small>
      <small><b><i class="fa fa-at"></i></b> {{person.email}}</small>

      <div class="actions">
        <a href="#" data-bs-toggle="modal" :data-bs-target="`#person${person.id}`" ><i class="fa fa-edit"></i></a>
        <a @click="deleteConfirmation()" ><i class="fas fa-trash"></i></a>
      </div>
    </div>

    <Form
      :person="person"
      :modalId="`person${person.id}`"
      @success="$emit('success', $event)"
      @error="$emit('error', $event)"
    />
</div>
</template>
<script>
import axios from 'axios'
import moment from 'moment'
import swal from 'sweetalert2'
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
      //showForm: false,
      //showModal: false,
    }
  },
  methods: {
    formatDate(date){
      return moment(date, "YYYYMMDD").format('DD/MM/YYYY')
    },
    deleteConfirmation(){
      let item = this
      swal.fire({
        title: 'Delete Person',
        text: 'Do you really want to delete the person data?',
        icon: 'warning',
        showConfirmButton: true,
        confirmButtonColor: '#7d2ae8',
        cancelButtonColor: '#ccc',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
      })
      .then(function(value) {
        if (value.isConfirmed && !value.isDismissed) {
          item.deletePerson()
        }
      })
    },
    deletePerson(){
      axios.delete(`${this.api}/person`, {params: {id: this.person.id}})
      .then((response) => {
        if (response.data.success) {
          this.$root.$emit(
              'msg',
              {
                type: 'success',
                title: 'Deleted!',
                text: `Data successfully deleted!`
              }
          )
          this.$emit('success')
        }
      })
      .catch((error) => {
         this.$emit('error')
         this.$root.$emit(
          'msg',
          {
            type: 'error',
            text: `You must fill in all mandatory fields!`
          }
        )
        this.$emit('cancel')
      })
    }
  },
  watch: {
    showForm(){
      //this.$emit('showOverlay', this.showForm)
    },
    showModal(){
      //this.$emit('showOverlay', this.showModal)
    }
  },
  mounted(){
    this.$parent.$on('overlayClick', () => {
      //this.showModal = false
      //this.showForm = false
    })
  }
}
</script>