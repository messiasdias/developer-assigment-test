<template>
<Modal :id="modalId">
  <template slot="header">
    <h5 class="modal-title" id="staticBackdropLabel">{{person ? `Edit ${person.name}` : 'Add Person'}}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" @click="cancelForm()"></button>
  </template>

  <template slot="body">
    <form
      @submit.prevent
      class="row"
    >
        <div class="col-12 col-lg-6 mb-3 form-group">
          <label for="name" class="form-label">Name</label>
          <input 
            name="name" type="text" class="form-control"
            v-model="$v.form.name.$model"
            @blur="$v.form.name.$touch()"
            :class="{'is-invalid': $v.form.name.$error || errors.name, 'is-valid': !$v.form.name.$invalid}" 
          >
          <div v-if="errors.name" class="form-text">
            <p v-for="(error, e) in errors.name" :key="e"> {{error}}</p>
          </div>
        </div>

        <div class="col-12 col-lg-6 mb-3 form-group">
          <label for="email" class="form-label">Email</label>
          <input 
            name="email" type="text" class="form-control"
            v-model="$v.form.email.$model"
            @blur="$v.form.email.$touch()"
            :class="{'is-invalid': $v.form.email.$error || errors.email, 'is-valid': !$v.form.email.$invalid}" 
          >
          <div v-if="errors.email" class="form-text">
            <p v-for="(error, e) in errors.email" :key="e"> {{error}}</p>
          </div>
        </div>
   
        <div class="col-12 col-lg-6 mb-3 form-group">
          <label for="dateOfBirth" class="form-label">Date Of Birth</label>
          <input 
            name="dateOfBirth" type="date" class="form-control"
            v-model="$v.form.dateOfBirth.$model"
            @blur="$v.form.dateOfBirth.$touch()"
            :class="{'is-invalid': $v.form.dateOfBirth.$error || errors.dateOfBirth, 'is-valid': !$v.form.dateOfBirth.$invalid}" 
          >
          <div v-if="errors.dateOfBirth" class="form-text">
            <p v-for="(error, e) in errors.dateOfBirth" :key="e"> {{error}}</p>
          </div>
        </div>

        <div class="col-12 col-lg-6 mb-3 form-group">
          <label for="phone">Phone</label>
          <input 
            name="phone" type="text" class="form-control"
            v-model="$v.form.phone.$model"
            @blur="$v.form.phone.$touch()"
            :class="{'is-invalid': $v.form.phone.$error || errors.phone, 'is-valid': !$v.form.phone.$invalid}"  
          >
          <div v-if="errors.phone" class="form-text">
            <p v-for="(error, e) in errors.phone" :key="e"> {{error}}</p>
          </div>
        </div>

        <div class="col-12 col-lg-6 mb-3 form-group">
          <label for="city">City</label>
          <input 
            name="city" type="text" class="form-control"
            v-model="$v.form.city.$model"
            @blur="$v.form.city.$touch()"
            :class="{'is-invalid': $v.form.city.$error || errors.city, 'is-valid': !$v.form.city.$invalid}"  
          >
          <div v-if="errors.city" class="form-text">
            <p v-for="(error, e) in errors.city" :key="e"> {{error}}</p>
          </div>
        </div>
    </form>
  </template>

  <template slot="footer">
    <button class="btn" type="button" data-bs-dismiss="modal" @click="cancelForm()" >Cancel</button>
    <button class="btn-primary" @click="submitForm()" type="submit" >Save</button>
  </template>
</Modal>
</template>
<script>
import axios from 'axios'
import Modal from './Modal'
import {required, minLength, maxLength, email} from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'

export default {
  name: 'Form',
  props: {
    person: {
      type: Object,
      default: () => {
        return null
      }
    },
    modalId: {
      type: String,
      default: 'addPerson'
    }
  },
  components: {
    Modal
  },
  mixins: [validationMixin],
  validations: {
    form: {
        name: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(100),
        },
        email: {
          required,
          email,
          minLength: minLength(4),
          maxLength: maxLength(100),
        },
        dateOfBirth: {
          required,
        },
        city: {
          required,
          minLength: minLength(4),
          maxLength: maxLength(100),
        },
        phone: {
          required,
          minLength: minLength(8),
          maxLength: maxLength(16),
        },
    }
  },
  data(){
    return {
      api: process.env.VUE_APP_API,
      form: {
        //id: null,
        name: null,
        email: null,
        dateOfBirth: null,
        city: null,
        phone: null,
        image: null,
      },
      errors: [],
    }
  },
  methods: {
    submitForm(){
      this.$v.form.$touch()
      
      if (!this.$v.form.$error) {
        axios({
          url: `${this.api}/person`,
          method: this.person ? 'PATCH' : 'POST',
          data: this.form
        })
        .then((response) => {
          console.log(response.data)
          if (response.data) {
            this.$root.$emit(
              'msg',
              {
                type: 'success',
                title: 'Save!',
                text: `Data saved successfully!`
              }
            )
            this.$emit('success')

            let modalClose = document.getElementsByClassName('btn-close')
            modalClose.forEach((close) => {
              close.click()
            })
            return
          }
          this.$emit('cancel')
        })
        .catch((error) => {
          this.$emit('error')

          if (error.data) {
            this.errors = error.data
            return
          }

          this.$root.$emit(
            'msg',
            {
              type: 'error',
              title: 'Error!',
              text: `An error occurred while trying to save the data!`
            }
          )
        })
        return
      }

      this.$root.$emit(
        'msg',
        {
          title: 'Warning!',
          text: `You must fill in all mandatory fields!`,
          type: 'warning'
        }
      )
      
    },
    cancelForm(){
      this.$emit('cancel')
    }
  },
  beforeMount(){
    if (this.person) {
      this.form = {...this.person}
      return
    }
    this.$v.form.$reset()
  }
}
</script>