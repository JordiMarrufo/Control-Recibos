<template>
    <div class="p-6">

        <!-- Cabecera -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Listado de Pagos Mensuales
                </h1>

                <p class="text-sm text-slate-500">
                    Historial de pagos de inquilinos
                </p>
            </div>
        </div>


        <!-- Tabla -->
        <div class="overflow-hidden rounded-xl bg-white shadow">

            <table class="w-full text-left">

                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3">Inquilino</th>
                        <th class="px-4 py-3">Agua</th>
                        <th class="px-4 py-3">Estado Agua</th>
                        <th class="px-4 py-3">Luz</th>
                        <th class="px-4 py-3">Estado Luz</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Botones</th>
                    </tr>
                </thead>


                <tbody>

                    <tr v-for="pago in pagos" :key="pago.id" class="border-b hover:bg-slate-50">

                        <td class="px-4 py-3 font-medium">
                            {{ pago.inquilino.name }}
                            {{ pago.inquilino.apellido }}
                        </td>


                        <td class="px-4 py-3">
                            S/ {{ pago.monto_agua }}
                        </td>


                        <td class="px-4 py-3">

                            <span v-if="pago.agua_pagado"
                                class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                                Pagado
                            </span>

                            <span v-else class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">
                                Pendiente
                            </span>

                        </td>


                        <td class="px-4 py-3">
                            S/ {{ pago.monto_luz }}
                        </td>


                        <td class="px-4 py-3">

                            <span v-if="pago.luz_pagado"
                                class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                                Pagado
                            </span>

                            <span v-else class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">
                                Pendiente
                            </span>

                        </td>


                        <td class="px-4 py-3">

                            <span v-if="pago.fecha_pago"
                                class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                                Pagado
                            </span>

                            <span v-else class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">
                                Pendiente
                            </span>

                        </td>
                        <td class="px-4 py-3">

                            <Update_pagos :pago="pago"  />

                        </td>


                    </tr>


                    <tr v-if="pagos.length === 0">
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            No hay pagos registrados
                        </td>
                    </tr>


                </tbody>

            </table>

        </div>

    </div>
</template>


<script setup lang="ts">

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { update } from '@/routes/profile';
import Update_pagos from './update_pagos.vue';


const pagos = ref<any[]>([]);


const obtenerPagos = async () => {

    try {

        const response = await axios.get('/pagoMensualinquilino');

        pagos.value = response.data;

    } catch (error: any) {
        
        console.log(error.response?.data);

    }

};



const formatearFecha = (fecha: string | null) => {

    if (!fecha)
        return '-';

    return new Date(fecha).toLocaleDateString('es-PE');

};



onMounted(() => {
    obtenerPagos();
});


</script>