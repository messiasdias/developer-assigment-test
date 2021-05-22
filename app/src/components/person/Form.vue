<template>
<div class="app-form">
  <form
    @submit.prevent
    class="content"
  >
    <div class="app-form-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input 
          name="name" type="text" 
          v-model="$v.form.name.$model"
          @blur="$v.form.name.$touch()"
          :class="{'is-invalid': $v.form.name.$error || errors.name, 'is-valid': !$v.form.name.$invalid}" 
        >
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input 
          name="email" type="email" 
          v-model="$v.form.email.$model"
          @blur="$v.form.email.$touch()"
          :class="{'is-invalid': $v.form.email.$error || errors.email, 'is-valid': !$v.form.email.$invalid}" 
        >
      </div>

      <div class="form-group">
        <label for="dateOfBirth">Date Of Birth</label>
        <input 
          name="dateOfBirth" type="date" 
          v-model="$v.form.dateOfBirth.$model"
          @blur="$v.form.dateOfBirth.$touch()"
          :class="{'is-invalid': $v.form.dateOfBirth.$error || errors.dateOfBirth, 'is-valid': !$v.form.dateOfBirth.$invalid}" 
        >
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <input 
          name="phone" type="text" 
          v-model="$v.form.phone.$model"
          @blur="$v.form.phone.$touch()"
          :class="{'is-invalid': $v.form.phone.$error || errors.phone, 'is-valid': !$v.form.phone.$invalid}"  
        >
      </div>

      <div class="form-group">
        <label for="city">City</label>
        <input 
          name="city" type="text" 
          v-model="$v.form.city.$model"
          @blur="$v.form.city.$touch()"
          :class="{'is-invalid': $v.form.city.$error || errors.city, 'is-valid': !$v.form.city.$invalid}"  
        >
      </div>
    </div>

    <div class="form-actions">
      <button class="btn" type="button" @click="$emit('cancel')" >Cancel</button>
      <button class="btn-primary" @click="submitForm()" type="submit" >Save</button>
    </div>
  </form>
</div>
</template>
<script>
import Axios from 'axios'
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
    }
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
      },
      errors: [],
    }
  },
  methods: {
    submitForm(){
      this.$v.form.$touch()
      console.log(this.$v.form.$error, this.$v.form.$touch(), this.form)
      if (!this.$v.form.$error) {
        Axios({
          url: `${this.api}/person`,
          method: this.person ? 'PATCH' : 'POST',
          data: this.form
        })
        .then((response) => {
          if (response.data && response.data.name == this.form.name) {
            this.$root.$emit(
              'msg',
              {
                type: 'success',
                title: 'Save!',
                text: `Data saved successfully!`
              }
            )
            this.$emit('success')
          }
          this.$emit('cancel')
        })
        .catch((error) => {
          this.$emit('error')

          if (error.data && error.data.errors) {
            this.errors = error.data.errors
            return
          }

          console.error(error)
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