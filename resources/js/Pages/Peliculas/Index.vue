<template>
    <Head title="Peliculas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Películas</h2>
                <div class="ml-auto">
                    <Button @click="newPelicula" size="small" severity="secondary" text raised>Nueva Película</Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable v-model:filters="filters" filterDisplay="row" :globalFilterFields="['estado']" :value="peliculas" :rows="5" paginator :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                        <Column field="id" header="Id" class="text-sm" sortable></Column>
                        <Column field="nombre" header="Nombre" class="text-sm" sortable></Column>
                        <Column header="Imagen" style="width: 100px;">
                            <template #body="slotProps">
                                <div class="flex justify-center">
                                    <Image v-if="slotProps.data.imagen" :src="slotProps.data.imagen" :alt="slotProps.data.nombre" width="50" />
                                </div>
                            </template>
                        </Column>
                        <Column field="fecha_publicacion" header="F. Plublicación" class="text-sm" style="width: 150px;" sortable></Column>
                        <Column :showFilterMenu="false" style="width: 20px;" field="estado" header="Estado" bodyStyle="text-align:center" class="text-sm">
                            <template #filter="{filterModel, filterCallback}">
                                <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="[0,1]" placeholder="Seleccioar" class="p-column-filter" style="min-width: 5rem" :showClear="true">
                                    <template #option="slotProps">
                                        <Tag :value="slotProps.option ? 'Activo': 'Desactivo'" :severity="slotProps.option ? 'success' : 'danger'" />
                                    </template>
                                </Dropdown>
                            </template>
                            <template #body="{data}">
                                <i class="pi" :class="{ 'pi-check-circle text-green-500': data.estado, 'pi-times-circle text-red-400': !data.estado }"></i>
                            </template>
                        </Column>
                        <Column style="width: 200px; min-width: 8rem" bodyStyle="text-align:center; padding:1rem 0">
                            <template #body="slotProps">
                                <span class="p-buttonset">
                                    <Button @click="edit(slotProps.data.id)" severity="secondary" title="Editar" icon="pi pi-pencil" size="small" text/>
                                    <Button @click="turnos(slotProps.data.id)" severity="secondary" title="Turnos" icon="pi pi-align-justify" size="small" text/>

                                    <Button @click="estado(slotProps.data.id, 1)" v-if="!slotProps.data.estado" severity="secondary" title="Activar" icon="pi pi-unlock" size="small" text/>
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
        peliculas: Array,
    },
    data(){
      return {
          filters: {
              estado: { value: null, matchMode: FilterMatchMode.EQUALS }
          },
          form: this.$inertia.form({
              estado: null
          }),
      }
    },
    methods:{
        edit(id){
            const url = this.route('pelicula.edit',{id})
            this.$inertia.get(url)
        },
        newPelicula(){
            const url = this.route('pelicula.new')
            this.$inertia.get(url)
        },
        turnos(id){
            const url = this.route('pelicula.turnos',{id})
            this.$inertia.get(url)
        },
        estado(id, value){
            if(confirm("Desea cambiar el estado de la pelicula?")){
                const url = this.route('pelicula.estado',{id})
                this.form.estado= value;
                this.form.put(url, {only: ['peliculas']})
            }
        },
        del(id){
            if(confirm("Desea eliminar la pelicula?")){
                const url = this.route('pelicula.destroy',{id})
                this.$inertia.delete(url, {only: ['peliculas']})
            }
        }
    }
}
</script>

<style scoped>

</style>
