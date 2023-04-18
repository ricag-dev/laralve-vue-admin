<template>
    <Head title="Peliculas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Turnos
                    <span v-if="pelicula" class="ml-1">/ {{pelicula.nombre}}</span>
                </h2>
                <div class="ml-auto">
                    <Button @click="newTurno" size="small" severity="secondary" text raised>Nueva Turno</Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable v-model:filters="filters" filterDisplay="row" :globalFilterFields="['activo']" :value="turnos" :rows="5" paginator :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                        <Column field="id" header="Id" class="text-sm" sortable></Column>
                        <Column field="turno" header="Turno" class="text-sm" sortable></Column>
                        <Column field="pelicula.nombre" header="Pelicula" class="text-sm" sortable></Column>
                        <Column :showFilterMenu="false" style="width: 20px;" field="activo" header="Estado" bodyStyle="text-align:center" class="text-sm">
                            <template #filter="{filterModel, filterCallback}">
                                <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="[0,1]" placeholder="Seleccioar" class="p-column-filter" style="min-width: 5rem" :showClear="true">
                                    <template #option="slotProps">
                                        <Tag :value="slotProps.option ? 'Activo': 'Desactivo'" :severity="slotProps.option ? 'success' : 'danger'" />
                                    </template>
                                </Dropdown>
                            </template>
                            <template #body="{data}">
                                <i class="pi" :class="{ 'pi-check-circle text-green-500': data.activo, 'pi-times-circle text-red-400': !data.activo }"></i>
                            </template>
                        </Column>
                        <Column style="width: 200px; min-width: 8rem" bodyStyle="text-align:center; padding:1rem 0">
                            <template #body="slotProps">
                                <span class="p-buttonset">
                                    <Button @click="edit(slotProps.data.id)" severity="secondary" title="Editar" icon="pi pi-pencil" size="small" text/>

                                    <Button @click="estado(slotProps.data.id, 1)" v-if="!slotProps.data.activo" severity="secondary" title="Activar" icon="pi pi-unlock" size="small" text/>
                                    <Button @click="estado(slotProps.data.id, 0)" v-else severity="secondary" title="Desactivar" icon="pi pi-lock" size="small" text/>

                                    <Button @click="del(slotProps.data.id)" severity="secondary" title="Delete" icon="pi pi-trash" size="small" text/>
                                </span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Image from 'primevue/image';
import Dropdown from "primevue/dropdown";
import Tag from "primevue/tag";
import {FilterMatchMode} from "primevue/api";
export default {
    name: "Index",
    components: {Head, AuthenticatedLayout, DataTable, Column, Button, Link, Image, Dropdown, Tag},
    props: {
        turnos: Array,
        pelicula: Object
    },
    data(){
        return {
            filters: {
                activo: { value: null, matchMode: FilterMatchMode.EQUALS }
            },
            form: this.$inertia.form({
                activo: null
            }),
        }
    },
    methods:{
        edit(id){
            const url = this.route('turno.edit',{id})
            this.$inertia.get(url)
        },
        newTurno(){
            const url = this.pelicula ? this.route('turno.peli.new',{pelicula:this.pelicula.id}) : this.route('turno.new')
            this.$inertia.get(url)
        },
        estado(id, value){
            if(confirm("Desea cambiar el estado de la turno?")){
                const url = this.route('turno.estado',{id})
                this.form.activo= value;
                this.form.put(url, {only: ['turnos']})
            }
        },
        del(id){
            if(confirm("Desea eliminar la turno?")){
                const url = this.route('turno.destroy',{id})
                this.$inertia.delete(url, {only: ['turnos']})
            }
        }
    }
}
</script>
