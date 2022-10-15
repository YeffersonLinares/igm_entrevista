<template>
    <div class="card">
        <div class="card-header">
            <slot name="header" />
        </div>
        <div class="card-body">
          <slot />
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
    }
})
</script>

<style lang="css">
.card-body-nygsoft {
    background-color: rgb(255, 254, 254);
}

.card-header-nygsoft {

    background-color: rgb(255, 255, 255);
}
</style>
