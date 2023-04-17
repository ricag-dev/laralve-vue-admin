<template>
    <Head title="Pelicula"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Película / {{ pelicula.nombre ?? 'Nueva' }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="update">
                        <div class="grid p-8">
                            <div>
                                <label for="frm_nombre">Nombre</label>
                                <InputText id="frm_nombre" v-model="form.nombre" type="text" class="w-full"
                                           :class="{ 'p-invalid': form.errors.nombre }" aria-describedby="text-error"/>
                                <small class="p-error" id="text-error">{{ form.errors.nombre || '&nbsp;' }}</small>
                            </div>

                            <div class="flex gap-4">
                                <div class="lg:w-1/2">
                                    <div>
                                        <label for="frm_fecha_publicacion">Fecha Publicación - {{form.fecha_publicacion}}</label>
                                        <Calendar id="frm_fecha_publicacion" dateFormat="yy-mm-dd" v-model="fecha_publicacion" showIcon class="w-full" :class="{ 'p-invalid': form.errors.fecha_publicacion }"/>
                                        <small class="p-error" id="text-error">{{
                                                form.errors.fecha_publicacion || '&nbsp;'
                                            }}</small>
                                    </div>

                                    <div>
                                        <label for="frm_estado">Estado</label>
                                        <Dropdown v-model="estado" :options="opt_estado" optionLabel="name" placeholder="Selecciona" class="w-full md:w-14rem" :class="{ 'p-invalid': form.errors.estado }" aria-describedby="text-error"/>
                                        <small class="p-error" id="text-error">{{ form.errors.estado || '&nbsp;' }}</small>
                                    </div>
                                </div>
                                <div class="lg:w-1/2">
                                    <div>
                                        <label for="frm_imagen">Imagen</label>
                                        <br>
                                        <input type="file" @input="form.imagen = $event.target.files[0]" />
                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>
                                        <small class="p-error" id="text-error">{{ form.errors.imagen || '&nbsp;' }}</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            <div>
                                <Button v-if="pelicula.id" text severity="danger" tabindex="-1" type="button" @click="destroy">Eliminar
                                    Película
                                </Button>
                            </div>
                            <div class="ml-auto">
                                <Button :loading="form.processing" type="submit">Guardar Película</Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";

export default {
    name: "Edit",
    components: {Head, AuthenticatedLayout, InputText, Button, Dropdown, Calendar},
    props: {
        pelicula: Object,
    },
    data() {
        const opt_estado= [{ name: 'Activo', val: 1 },{ name: 'Desactivado', val: 0 }]
        const estado = opt_estado.filter(e => e.val == this.pelicula.estado)
        if(!this.pelicula.fecha_publicacion){
            const f = new Date();
            this.pelicula.fecha_publicacion = `${f.getFullYear()}-${f.getMonth()}-${f.getDate()}`
        }
        const fecha_publicacion = new Date(this.pelicula.fecha_publicacion)
        return {
            fecha_publicacion,
            opt_estado,
            estado,
            form: this.$inertia.form({
                nombre: this.pelicula.nombre,
                fecha_publicacion: this.pelicula.fecha_publicacion,
                imagen: this.pelicula.imagen,
                estado: this.pelicula.estado,
            }),
        }
    },
    watch:{
      estado({val}){
        this.form.estado = val;
      },
        fecha_publicacion(val){
          const f = new Date(val);
          this.form.fecha_publicacion = `${f.getFullYear()}-${f.getMonth()}-${f.getDate()}`
        }
    },
    methods: {
        update() {
            this.pelicula.estado = this.estado.val
            if(this.pelicula.id){
                this.form.put(`/pelicula/${this.pelicula.id}`)
            }else{
                this.form.post('/pelicula')
            }
        },
        destroy() {
            if (confirm('Are you sure you want to delete this organization?')) {
                this.$inertia.delete(`/pelicula/${this.pelicula.id}`)
            }
        },
    }
}
</script>
