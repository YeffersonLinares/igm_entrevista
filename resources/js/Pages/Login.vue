<template>
    <div class="container border mt-5 p-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <Label>Usuario</Label>
                <Input v-model="credentials.email" />
            </div>
            <div class="col-md-12 mb-3">
                <Label>Contraseña</Label>
                <Input type="password" v-model="credentials.password" />
            </div>
            <div class="col-12 d-flex justify-content-center">
                <Button @click="login()">Login</Button>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent } from "vue";
import Label from "../ComponentsVuexy/Label.vue";
import Input from "../ComponentsVuexy/Input.vue";
import Button from "../ComponentsVuexy/Button.vue";
export default defineComponent({
    components: {
        Input,
        Label,
        Button
    },
    data() {
        return {
            credentials: { email: '', password: '' }
        }
    },
    methods: {
        login() {
            axios.post(route('web.login'), this.credentials).then(res => {
                if (res.data.status == 200) {
                    window.location.href = '/facturas'
                } else if (res.data.status == 422) {
                    alert('credenciales incorrectas')
                }
            })
        }
    },
})
</script>
