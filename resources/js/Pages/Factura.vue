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
                <Button @click="pantalla='create'; disabled = false">Crear</Button>
            </div>
            <table class="table table-striped table-bordered" id="tabla">
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
                                <Button class="me-3" @click="eliminar(i.id)">Eliminar</Button>
                                <Button class="me-3" @click="edit(i)">Editar</Button>
                                <Button class="me-3" @click="detalles(i)">Detalles</Button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="pantalla=='create'">
        <div class="container-fluid my-3 d-flex justify-content-end">
            <Button @click="getResults()">Atrás</Button>
        </div>
        <div class="container mt-4 border p-3">
            <h5 class="text-center my-3">Factura</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <Label required="1">Nombre del emisor</Label>
                    <Input :error="errors.emisor_nombre" v-model="factura.emisor_nombre" :disabled="disabled" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">NIT del emisor</Label>
                    <Input :error="errors.emisor_nit" v-model="factura.emisor_nit" :disabled="disabled"
                        @keypress="$isNumber($event, factura.emisor_nit)" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <Label required="1">Nombre del receptor</Label>
                    <Input :error="errors.receptor_nombre" v-model="factura.receptor_nombre" :disabled="disabled" />
                </div>
                <div class="col-md-6 mb-3">
                    <Label required="1">NIT del receptor</Label>
                    <Input :error="errors.receptor_nit" v-model="factura.receptor_nit" :disabled="disabled"
                        @keypress="$isNumber($event, factura.receptor_nit)" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <Label required="1">Valor sin IVA</Label>
                    <Input :error="errors.valor" v-model="factura.valor" @keyup="cal_valor_total()" disabled />
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

        <div class="row border mt-4 p-3">
            <div class="col-md-6 border p-3">
                <h5 class="text-center my-3">Items de Factura</h5>
                <div class="row">
                    <div class="col-md-6">
                        <Label required="1">Descripción del Item</Label>
                        <Input :disabled="disabled" v-model="item.descripcion" :error="errors_item.descripcion" />
                    </div>
                    <div class="col-md-6">
                        <Label required="1">Cantidad</Label>
                        <Input :disabled="disabled" v-model="item.cantidad" @keyup="valor_item()"
                            @keypress="$isNumber($event, item.cantidad)" :error="errors_item.cantidad" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <Label required="1">Valor Unitario</Label>
                        <Input :disabled="disabled" v-model="item.valor_unitario" @keyup="valor_item()"
                            @keypress="$isNumber($event, item.valor_unitario)" :error="errors_item.valor_unitario" />
                    </div>
                    <div class="col-md-6">
                        <Label required="1">Valor Total</Label>
                        <Input disabled v-model="item.valor_total" :error="errors_item.valor_total" />
                    </div>
                </div>
                <div class="d-flex justify-content-center my-4" v-if="!disabled">
                    <Button @click="add_item()">Guardar Item</Button>
                </div>
            </div>
            <div class="col-md-6 border p-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Valor Unitario</th>
                            <th>Valor Total</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(i, index) in factura.items" :key="index">
                            <td>{{i.descripcion }}</td>
                            <td>{{i.cantidad}}</td>
                            <td>{{i.valor_unitario}}</td>
                            <td>{{i.valor_total}}</td>
                            <td>
                                <Button @click="delete_item(i, index)">Eliminar</Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
import ButtonSinFondo from "../ComponentsVuexy/ButtonSinFondo.vue";
import "datatables.net-bs4";
export default defineComponent({
    components: {
        Input,
        Label,
        Button,
        ButtonSinFondo
    },
    props: {
        facturas_props: Array
    },
    data() {
        return {
            facturas: this.facturas_props,
            filtros: {},
            pantalla: 'create',
            factura: { id: '', valor_total: 0, iva: 0, valor: 0, items: [] },
            errors: {},
            disabled: false,
            item: { id: '',valor_unitario: 0, cantidad: 0, descripcion: '' },
            errors_item: {}
        }
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
            this.disabled = false
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
                this.errors = {}
                this.errors_item = {}
            })
        },
        store() {
            axios.post(route('web.factura.store'), this.factura).then(res => {
                this.$alert(res.data)
                this.getResults()
                this.errors_item = {}
                this.errors = {}
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            })
        },
        cal_valor_total() {
            this.factura.valor_total = parseInt(this.factura.valor) + (parseInt(this.factura.valor) * (parseInt(this.factura.iva) / 100))
        },
        add_item() {
            if(!this.$validacionFormulario(this.item, ['id']).exito) {
                this.errors_item = this.$validacionFormulario(this.item).errors
                // console.log('this.errors_item ==> ', this.errors_item);
                return
            }
            this.factura.items.push(this.item)
            this.item = { valor_unitario: 0, cantidad: 0 }
            this.cal_valor_factura()
        },
        valor_item() {
            this.item.valor_total = parseInt(this.item.valor_unitario) * (parseInt(this.item.cantidad))
        },
        cal_valor_factura() {
            this.factura.valor = 0
            this.factura.items.forEach(element => {
                this.factura.valor += element.cantidad * element.valor_unitario
            });
            this.cal_valor_total()
        },
        delete_item(i, index) {
            this.factura.items.splice(index, 1)
        }
    },
})

</script>
