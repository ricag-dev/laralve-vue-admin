<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :value="peliculas" showGridlines :rows="5" paginator :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                        <Column field="id" header="Id" class="text-sm"></Column>
                        <Column field="nombre" header="Nombre" class="text-sm"></Column>
                        <Column field="fecha_publicacion" header="F. Plublicación" class="text-sm"></Column>
                        <Column header="Estado" bodyStyle="text-align:center" class="text-sm">
                            <template #body="slotProps">
                                <i class="pi" :class="{ 'pi-check-circle text-green-500': slotProps.data.estado, 'pi-times-circle text-red-400': !slotProps.data.estado }"></i>
                            </template>
                        </Column>
                        <Column style="width: 200px; min-width: 8rem" bodyStyle="text-align:center; padding:1rem 0">
                            <template #body="slotProps">
                                <span class="p-buttonset">
                                    <Button severity="secondary" title="Save" icon="pi pi-pencil" size="small" text/>
                                    <Button severity="secondary" title="Turnos" icon="pi pi-align-justify" size="small" text/>
                                    <Button severity="secondary" title="Delete" icon="pi pi-unlock" size="small" text/>
                                    <Button severity="secondary" title="Delete" icon="pi pi-lock" size="small" text/>
                                    <Button severity="secondary" title="Delete" icon="pi pi-trash" size="small" text/>
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
import { Head } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
export default {
    name: "Index",
    components: {Head, AuthenticatedLayout, DataTable, Column, Button},
    props: {
        peliculas: Array,
    },
    data(){
        return {
            edit: null
        }
    }
}
</script>

<style scoped>

</style>
