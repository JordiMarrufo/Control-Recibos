<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">
                Lista de Inquilinos
            </h1>


        </div>


        <div class="overflow-hidden rounded-xl bg-white shadow">
            <table class="min-w-full">

                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Apellido</th>
                        <th class="px-4 py-3 text-left">DNI</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-left">Correo</th>
                        <th class="px-4 py-3 text-left">Cuota</th>
                        <th class="px-4 py-3 text-left">Ingreso</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>


                <tbody>

                    <tr v-for="inquilino in inquilinos" :key="inquilino.id" class="border-t hover:bg-slate-50">

                        <td class="px-4 py-3">
                            {{ inquilino.name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ inquilino.apellido }}
                        </td>

                        <td class="px-4 py-3">
                            {{ inquilino.dni }}
                        </td>

                        <td class="px-4 py-3">
                            {{ inquilino.telefono }}
                        </td>

                        <td class="px-4 py-3">
                            {{ inquilino.correo }}
                        </td>

                        <td class="px-4 py-3">
                            S/. {{ inquilino.cuota }}
                        </td>

                        <td class="px-4 py-3">
                            {{ inquilino.fecha_ingreso }}
                        </td>


                        <td class="px-4 py-3">
                            <div class="flex gap-2">

                                <UpdateInquilinos :inquilino="inquilino" @actualizado="obtenerInquilinos" />

                                <Delete_inquilino :inquilino="inquilino" @actualizado="obtenerInquilinos" />

                            </div>
                        </td>


                    </tr>


                    <tr v-if="inquilinos.length === 0">

                        <td colspan="8" class="py-6 text-center text-slate-500">
                            No hay inquilinos registrados.
                        </td>

                    </tr>


                </tbody>

            </table>
        </div>

    </div>
</template>


<script setup lang="ts">

import axios from "axios";
import { onMounted, ref } from "vue";
import UpdateInquilinos from "./UpdateInquilinos.vue";
import Delete_inquilino from "./Delete_inquilino.vue";


interface Inquilino {

    id: number;
    name: string;
    apellido: string;
    telefono: string;
    dni: string;
    correo: string;
    cuota: number;
    fecha_ingreso: string;

}



const inquilinos = ref<Inquilino[]>([]);



const obtenerInquilinos = async () => {

    try {

        const { data } = await axios.get("/inquilinosback");

        inquilinos.value = data;

    } catch (error) {

        console.error(error);

    }

};



onMounted(() => {

    obtenerInquilinos();

});


</script>