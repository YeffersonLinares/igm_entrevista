<template>

    <div v-if="pantalla=='list'">
        <div class="row mt-4 mb-3">
            <div class="col-md-4 mb-3">
                <Label>Código</Label>
                <Input v-model="filtros.id" />
            </div>
            <div class="col-md-4 mb-3">
                <Label>NIT Emisor</Label>
                <Input v-model="filtros.emisor_nit" />
            </div>
            <div class="col-md-4 mb-3">
                <Label>NIT Receptor</Label>
                <Input v-model="filtros.receptor_nit" />
            </div>
            <div class="col-md-4 mb-3">
                <Label>Fecha Inicio</Label>
                <Input type="date" v-model="filtros.fecha_inicio" />
            </div>
            <div class="col-md-4 mb-3">
                <Label>Fecha Fin</Label>
                <Input type="date" v-model="filtros.fecha_fin" />
            </div>
        </div>

        <div class="container-fluid d-flex justify-content-center mb-3">
            <Button @click="getResults()">Filtrar</Button>
        </div>

        <div>
            <div class="d-flex justify-content-end me-5">
                <Button @click="pantalla='create'">Crear</Button>
            </div>
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Emisor</th>
                        <th>Receptor</th>
                        <th>Total a pagar</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i,index) in facturas" :key="index">
                        <td> {{i.id}} </td>
                        <td> {{i.emisor_nombre}} </td>
                        <td> {{i.receptor_nombre}} </td>
                        <td> {{i.valor_total}} </td>
                        <td> {{i.created_at}} </td>
                        <td>
                            <div class="d-flex">
                                <button class="btn btn-danger" @click="eliminar(i.id)">Eliminar</button>
                                <button class="btn btn-warning" @click="edit(i)">Editar</button>
                                <button class="btn btn-info" @click="detalles(i)">Detalles</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="pantalla=='create'">
        <div class="container mt-4 border p-3">
            <h5 class="text-center my-3">Factura</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <Label required="1">Nombre del emisor</Label>
                    <Input :error="errors.emisor_nombre" v-model="factura.emisor_nombre" :disabled="disabled" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">NIT del emisor</Label>
                    <Input :error="errors.emisor_nit" v-model="factura.emisor_nit" :disabled="disabled" @keypress="$isNumber($event, factura.emisor_nit)" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <Label required="1">Nombre del receptor</Label>
                    <Input :error="errors.receptor_nombre" v-model="factura.receptor_nombre" :disabled="disabled" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">NIT del receptor</Label>
                    <Input :error="errors.receptor_nit" v-model="factura.receptor_nit" :disabled="disabled" @keypress="$isNumber($event, factura.receptor_nit)" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <Label required="1">Valor sin IVA</Label>
                    <Input :error="errors.valor" v-model="factura.valor" @keyup="cal_valor_total()" :disabled="disabled" />
                </div>
                <div class="col-md-4 mb-3">
                    <Label required="1">IVA</Label>
                    <Input :error="errors.iva" v-model="factura.iva" @keyup="cal_valor_total()" :disabled="disabled" />
                </div>
                <div class="col-md-4 mb-3">
                    <Label required="1">Valor total</Label>
                    <Input :error="errors.valor_total" v-model="factura.valor_total" disabled />
                </div>
            </div>
        </div>

        <div class="container border mt-4 p-3">
            <h5 class="text-center my-3">Items de Factura</h5>
            <div class="row">
                <div class="col-md-6">
                    <Label required="1">Descripción del Item</Label>
                    <Input :disabled="disabled" />
                </div>
                <div class="col-md-6">
                    <Label required="1">Cantidad</Label>
                    <Input :disabled="disabled"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <Label required="1">Valor Unitario</Label>
                    <Input :disabled="disabled"/>
                </div>
                <div class="col-md-6">
                    <Label required="1">Valor Total</Label>
                    <Input :disabled="disabled"/>
                </div>
            </div>
            <div class="d-flex justify-content-center my-4" v-if="!disabled">
                <Button>Guardar Item</Button>
            </div>
        </div>

        <div class="d-flex justify-content-center my-4">
            <Button @click="store()" v-if="!disabled">Guardar</Button>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent } from "vue";
import Input from "../ComponentsVuexy/Input.vue";
import Label from "../ComponentsVuexy/Label.vue";
import Button from "../ComponentsVuexy/Button.vue";
export default defineComponent({
    components: {
        Input,
        Label,
        Button
    },
    props: {
        facturas_props: Array
    },
    data() {
        return {
            facturas: this.facturas_props,
            filtros: {},
            pantalla: 'list',
            factura: { id: '', valor_total: 0, iva: 0, valor: 0, items: [] },
            errors: {},
            disabled: false
        }
    },
    created() {
        // this.facturas =
        // alert('llego')
    },
    methods: {
        eliminar(id) {
            axios.post(route('web.factura.delete'), { id: id }).then(res => {
                this.$alert(res.data)
                this.getResults()
            })
        },
        edit(i) {
            this.factura = i
            this.pantalla = 'create'
        },
        detalles(i) {
            this.factura = i
            this.disabled = true
            this.pantalla = 'create'
        },
        getResults() {
            axios.post(route('web.factura.list', this.filtros)).then(res => {
                this.facturas = res.data
                this.factura = { id: '', valor_total: 0, iva: 0, valor: 0, items: [] }
                this.pantalla = 'list'
            })
        },
        store() {
            axios.post(route('web.factura.store'), this.factura).then(res => {
                this.$alert(res.data)
                this.getResults()
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            })
        },
        cal_valor_total() {
            this.factura.valor_total = parseInt(this.factura.valor) + (parseInt(this.factura.valor) * (parseInt(this.factura.iva) / 100))
        }
    },
})

</script>
