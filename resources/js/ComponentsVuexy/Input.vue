<template>
  <input
  :min="min"
  v-bind="$attrs"
  :disabled="disabled"
  :type="type"
  maxlength="255"
  v-on:keyup="error.length=0"
  v-on:change="error.length=0"
  autocomplete="off"
  :placeholder="placeholder"
  class="form-control nygsoft-input"
  v-bind:class="[error.length==0 ? ' nygsoft-input ' : ' nygsoft-input-error ']"
  :value="modelValue"
  @input="$emit('update:modelValue', $event.target.value)"
  ref="input">
    <template v-if="error">
        <Error class="d-block mt-1" v-for="(item, index) in error" :key="index">{{ item }}</Error>
    </template>
</template>

<script>
import { defineComponent } from 'vue'
import Error from "./Error.vue";
export default defineComponent({
    props: {
        modelValue: {

        },
        placeholder: {
            type: String,
            default: ""
        },
        error: {
            type: Array,
            default: []
        },
        type: {
            type: String,
            default: "text"
        },
        disabled: {
            type: Boolean,
            default: false
        },
        min: {
            type: String,
        }
    },

    emits: ['update:modelValue'],
    components: {
        Error
    },
    created() {

    },
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
})
</script>
<style>
.nygsoft-input {
    /* border: 1px solid rgb(51, 49, 135) !important; */
    border: 1px solid #999 !important;
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25) !important;
}

.nygsoft-input-error {
    border: 1px solid rgb(202, 36, 36) !important;
}

.nygsoft-input-error:focus {
    box-shadow: 0 0 0 0.25rem rgba(202, 36, 36, 0.25) !important;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>
