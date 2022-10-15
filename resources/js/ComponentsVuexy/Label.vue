<template>
    <label class="form-label">
        <slot>
        </slot>
        <b v-if="required=='1'" class="text-danger"> (*)</b>
    </label>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
        required: {
            type: String,
            default: '0'
        }
    }
  })
</script>
