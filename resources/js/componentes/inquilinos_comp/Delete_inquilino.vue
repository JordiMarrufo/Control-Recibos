<template>
    <div>

        <button
            @click="mostrarModal = true"
            class="rounded-lg bg-red-600 px-3 py-2 text-white hover:bg-red-700"
        >
            Eliminar
        </button>


        <!-- Modal -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        >

            <div class="w-96 rounded-xl bg-white p-6 shadow-lg">

                <h2 class="mb-4 text-xl font-bold text-slate-800">
                    Confirmar eliminación
                </h2>


                <p class="mb-6 text-slate-600">
                    ¿Seguro que deseas eliminar a
                    <b>{{ props.inquilino.name }} {{ props.inquilino.apellido }}</b>?
                </p>


                <div class="flex justify-end gap-3">

                    <button
                        @click="mostrarModal = false"
                        class="rounded-lg bg-gray-300 px-4 py-2 hover:bg-gray-400"
                    >
                        Cancelar
                    </button>


                    <button
                        @click="eliminarInquilino"
                        class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                    >
                        Eliminar
                    </button>

                </div>

            </div>

        </div>


    </div>
</template>


<script setup lang="ts">

import axios from "axios";
import { ref } from "vue";


interface Inquilino {

    id:number;
    name:string;
    apellido:string;
    telefono:string;
    dni:string;
    correo:string;
    cuota:number;
    fecha_ingreso:string;

}



const props = defineProps<{
    inquilino: Inquilino
}>();


const emit = defineEmits<{
    actualizado:[]
}>();


const mostrarModal = ref(false);



const eliminarInquilino = async()=>{


    try {


        await axios.delete(
            `/inquilinosback/${props.inquilino.id}`
        );


        mostrarModal.value = false;


        emit("actualizado");


    } catch(error) {


        console.error(error);

        alert("Error al eliminar");


    }


};


</script>