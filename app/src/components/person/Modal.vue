<template>
<div class="app-modal">
  <p>Do you really want to delete the person's data?</p>
  <div>
    <a @click.prevent="$emit('cancel')" >Cancel</a>
    <a @click.prevent="deletePerson()" >OK</a>
  </div>
</div>
</template>
<script>
import Axios from 'axios'

export default {
  name: 'Modal',
  props: {
    person: {
      type: Object,
      default: () => {
        return null
      }
    },
  },
  data(){
    return {
      api: process.env.VUE_APP_API,
    }
  },
  methods: {
    deletePerson(){
      Axios.delete(`${this.api}/person`, {params: {id: this.person.id}})
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
          this.$emit('delete', this.person)
          this.$emit('cancel')
        }
      })
      .catch((error) => {
        console.error(error)

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
  }
}
</script>