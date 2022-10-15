<template>
    <button :type="type" v-bind="$attrs" :class="'btn btn-outline-'+ colorBgBtnClass  + ' waves-effect '+ sizeBtnClass">
        <slot>
        </slot>
    </button>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'button',
        },
        colorBgBtn: {
            type: String,
            default: 'primary',
        },
        sizeBtn: {
            type: String,
            default: '',
        },
    },
    computed: {
        colorBgBtnClass() {
            return {
                'primary': 'primary ',
                'danger': 'danger ',
            }[this.colorBgBtn]
        },
        sizeBtnClass() {
            return {
                'lg': ' btn-lg ',
                'sm': ' btn-sm ',
            }[this.sizeBtn]
        }
    }
})
</script>
