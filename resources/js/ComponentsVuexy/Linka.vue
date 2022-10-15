<template>
    <Link :href="href" :class="' '+ (transparente ? '' : clase)">
      <slot></slot>
    </Link>
</template>

<script>
  import { defineComponent } from 'vue'
  import { Link } from '@inertiajs/inertia-vue3'

  export default defineComponent({
    components: {
      Link,
    },
    props: {
        href:{
            default:"#",
            type:String,
        },
        clase: {
            type: String,
            default: 'btn btn-outline-primary waves-effect',
        },
        transparente: {
            type: Boolean,
            default: false,
        },
    }
  })
</script>
<style scoped>
/* Button primary*/

.btn-nygsoft:hover {
  background-color: #266bbb;
}

.success{
background: #4ec1879a;
}
.success:hover{
background: #1258359a;
}
.danger{
background: #a23d3d;
}
.danger:hover{
background: #701616;
}
 </style>

