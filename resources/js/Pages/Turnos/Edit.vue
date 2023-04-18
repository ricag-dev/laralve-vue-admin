<template>
    <Head title="Pelicula"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Turno / {{ turno.pelicula ? turno.pelicula.nombre : 'Nuevo' }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="update">
                        <div class="grid p-8">
                            <div>
                                <label for="frm_nombre">Turno</label>
                                <Calendar timeOnly id="frm_nombre" dateFormat="yy-mm-dd" v-model="hora" showIcon class="w-full" :class="{ 'p-invalid': form.errors.turno }"/>
                                <small class="p-error" id="text-error">{{ form.errors.turno || '&nbsp;' }}</small>
                            </div>

                            <div class="flex gap-4">
                                <div class="lg:w-1/2">
                                    <div>
                                        <label for="frm_fecha_publicacion">Película</label>
                                        <br>
                                        <AutoComplete v-model="pelicula" optionLabel="nombre" dropdown :suggestions="peliculas_list" @complete="search" />
                                        <br>
                                        <small class="p-error" id="text-error">{{
                                                form.errors.pelicula_id || '&nbsp;'
                                            }}</small>
                                    </div>


                                </div>
                                <div class="lg:w-1/2">
                                    <div>
                                        <label for="frm_estado">Estado</label>
                                        <Dropdown v-model="estado" :options="opt_estado" optionLabel="name" placeholder="Selecciona" class="w-full md:w-14rem" :class="{ 'p-invalid': form.errors.activo }" aria-describedby="text-error"/>
                                        <small class="p-error" id="text-error">{{ form.errors.activo || '&nbsp;' }}</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            <div>
                                <Button v-if="turno.id" text severity="danger" tabindex="-1" type="button" @click="del">
                                    Eliminar Turno
                                </Button>
                            </div>
                            <div class="ml-auto">
                                <Button :loading="form.processing" type="submit">Guardar Turno</Button>
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
import AutoComplete from "primevue/autocomplete";
import Calendar from "primevue/calendar";

export default {
    name: "Edit",
    components: {Head, AuthenticatedLayout, InputText, Button, Dropdown, AutoComplete, Calendar},
    props: {
        turno: Object,
        peliculas: Array,
    },
    data() {
        //PLICAR ACTIVO DEFAULT
        const opt_estado= [{ name: 'Activo', val: 1 },{ name: 'Desactivado', val: 0 }]
        this.turno.activo = this.turno.activo ?? 1
        let estado = opt_estado.filter(e => e.val == this.turno.activo)
        estado = estado ? estado[0] : null

        //APLICAR TURNO DEFAULT
        const hora = new Date()
        if(this.turno.turno && this.turno.turno.indexOf(':')> -1){
            const [h, m] = this.turno.turno.split(':')
            hora.setHours(h)
            hora.setMinutes(m)
        }else{
            this.turno.turno = this.getTurno(hora)
        }

        //APLICAR PELICULA_ID DEFAULT
        let pelicula = null
        if(this.turno.pelicula_id){
            pelicula = this.peliculas.filter(e => this.turno.pelicula_id == e.id)[0]
        }
        return {
            hora,
            peliculas_list: this.peliculas,
            pelicula,
            opt_estado,
            estado,
            form: this.$inertia.form({
                turno: this.turno.turno,
                activo: this.turno.activo,
                pelicula_id: this.turno.pelicula_id,
            }),
        }
    },
    watch:{
        estado({val}){
            this.form.activo = val;
        },
        pelicula({id}){
            this.form.pelicula_id = id;
        },
        hora(val){
            const f = new Date(val);
            this.form.turno = this.getTurno(f)
        }
    },
    methods: {
        getTurno(date){
            return `${this.timeFormat(date.getHours())}:${this.timeFormat(date.getMinutes())}`
        },
        timeFormat(time){
            return time.toString().padStart(2, '0')
        },
        search(event){
            this.pelicula = event.query

            if (!event.query.trim().length) {
                this.peliculas_list = [...this.peliculas];
            } else {
                this.peliculas_list = this.peliculas.filter((pelicula) => {
                    return pelicula.nombre.toLowerCase().startsWith(event.query.toLowerCase());
                });
            }
        },
        update() {
            this.form.pelicula = this.peliculas_list.id
            if(this.turno.id){
                this.form.post(`/turno/${this.turno.id}`)
            }else{
                this.form.post('/turno')
            }
        },
        del(){
            if(confirm("Desea eliminar la turno?")){
                const url = this.route('turno.destroy',{id: this.turno.id})
                this.$inertia.delete(url, {only: ['turnos']})
            }
        }
    }
}
</script>
