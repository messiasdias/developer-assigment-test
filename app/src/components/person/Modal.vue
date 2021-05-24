<template>
<div 
  class="modal fade" 
  :id="id"
  :aria-labelledby="`${id}Label`"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1" 
  role="dialog" 
  aria-hidden="true"
>
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <slot name="header" />
      </div>
      <div class="modal-body">
        <slot name="body" />
      </div>
      <div class="modal-footer">
        <slot name="footer" />
      </div>
    </div>
  </div>
</div>
</template>
<script>
export default {
  name: 'Form',
  props: {
    id: {
      type: String,
      default: 'addPerson'
    }
  },
}
</script>