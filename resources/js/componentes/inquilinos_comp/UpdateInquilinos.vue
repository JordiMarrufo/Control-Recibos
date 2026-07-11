<template>
  <div>
    <!-- Botón editar dentro de la tabla -->
    <button
      @click="abrirModal"
      class="rounded-lg bg-yellow-500 px-3 py-2 text-white hover:bg-yellow-600"
    >
      Editar
    </button>


    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
    >
      <div class="w-full max-w-2xl rounded-xl bg-white p-6 shadow-2xl">

        <div class="mb-6 flex items-center gap-2">
          <User class="h-6 w-6 text-blue-600" />

          <h2 class="text-xl font-semibold">
            Editar Inquilino
          </h2>
        </div>


        <form
          @submit.prevent="actualizarInquilino"
          class="grid grid-cols-2 gap-4"
        >

          <div>
            <label class="mb-1 block text-sm font-medium">
              Nombre 
            </label>

            <input
              v-model="form.nombre"
              type="text"
              required
              class="w-full rounded-lg border p-2" 
            />
          </div>


          <div>
            <label class="mb-1 block text-sm font-medium">
              Apellido
            </label>

            <input
              v-model="form.apellido"
              type="text"
              required
              class="w-full rounded-lg border p-2"
            />
          </div>


          <div>
            <label class="mb-1 block text-sm font-medium">
              Teléfono
            </label>

            <input
              v-model="form.telefono"
              type="text"
              required
              class="w-full rounded-lg border p-2"
              maxlength="9"
            />
          </div>


          <div>
            <label class="mb-1 block text-sm font-medium">
              DNI
            </label>

            <input
              v-model="form.dni"
              type="text"
              required
              class="w-full rounded-lg border p-2"
              maxlength="8"
            />
          </div>


          <div>
            <label class="mb-1 block text-sm font-medium">
              Correo
            </label>

            <input
              v-model="form.correo"
              type="email"
              required
              class="w-full rounded-lg border p-2"
            />
          </div>


          <div>
            <label class="mb-1 block text-sm font-medium">
              Cuota
            </label>

            <input
              v-model="form.cuota"
              type="number"
              required
              class="w-full rounded-lg border p-2"
            />
          </div>


          <div class="col-span-2">

            <label class="mb-1 block text-sm font-medium">
              Fecha de ingreso
            </label>

            <input
              v-model="form.fecha_ingreso"
              type="date"
              required
              class="w-full rounded-lg border p-2"
            />

          </div>



          <div class="col-span-2 mt-4 flex justify-end gap-3">

            <button
              type="button"
              @click="showModal=false"
              class="rounded-lg border px-5 py-2"
            >
              Cancelar
            </button>


            <button
              type="submit"
              :disabled="loading"
              class="rounded-lg bg-blue-600 px-5 py-2 text-white"
            >
              {{ loading ? "Actualizando..." : "Actualizar" }}
            </button>

          </div>


        </form>

      </div>
    </div>



    <!-- Mensaje -->
    <div
      v-if="mensaje.show"
      class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40"
    >

      <div class="rounded-xl bg-white p-6 shadow-xl">

        <h3 class="text-lg font-bold">
          {{ mensaje.titulo }}
        </h3>


        <p class="mt-2 whitespace-pre-line text-slate-600">
          {{ mensaje.texto }}
        </p>


        <button
          @click="mensaje.show=false"
          class="mt-5 rounded-lg bg-blue-600 px-5 py-2 text-white"
        >
          Aceptar
        </button>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import { reactive, ref } from "vue";
import axios from "axios";
import { User } from "@lucide/vue";


const props = defineProps<{
  inquilino:{
    id:number;
    name:string;
    apellido:string;
    telefono:string;
    dni:string;
    correo:string;
    cuota:number;
    fecha_ingreso:string;
  }
}>();


const emit = defineEmits([
  "actualizado"
]);


const showModal = ref(false);
const loading = ref(false);


const form = reactive({
  nombre:"",
  apellido:"",
  telefono:"",
  dni:"",
  correo:"",
  cuota:"",
  fecha_ingreso:""
});


const mensaje = ref({
  show:false,
  titulo:"",
  texto:""
});


const abrirModal = ()=>{

  form.nombre = props.inquilino.name;
  form.apellido = props.inquilino.apellido;
  form.telefono = props.inquilino.telefono;
  form.dni = props.inquilino.dni;
  form.correo = props.inquilino.correo;
  form.cuota = String(props.inquilino.cuota);

  // convertir ISO a formato input date
form.fecha_ingreso = formatoFecha(props.inquilino.fecha_ingreso);

  showModal.value=true;

};



const actualizarInquilino = async()=>{

  loading.value=true;


  const datos:any={};


  if(form.nombre !== props.inquilino.name)
    datos.name=form.nombre;


  if(form.apellido !== props.inquilino.apellido)
    datos.apellido=form.apellido;


  if(form.telefono !== props.inquilino.telefono)
    datos.telefono=form.telefono;


  if(form.dni !== props.inquilino.dni)
    datos.dni=form.dni;


  if(form.correo !== props.inquilino.correo)
    datos.correo=form.correo;


  if(form.cuota !== String(props.inquilino.cuota))
    datos.cuota=form.cuota;


if(
  form.fecha_ingreso !== formatoFecha(props.inquilino.fecha_ingreso)
){
    datos.fecha_ingreso=form.fecha_ingreso;
}


  try{


    await axios.put(
      `/inquilinosback/${props.inquilino.id}`,
      datos
    );


    showModal.value=false;


    mensaje.value={
      show:true,
      titulo:"Actualizado",
      texto:"El inquilino fue actualizado correctamente."
    };


    emit("actualizado");


  }catch(error:any){


    if(error.response?.status===422){

      mensaje.value={
        show:true,
        titulo:"Error de validación",
        texto:Object.values(error.response.data.errors)
          .flat()
          .join("\n")
      };


    }else{


      mensaje.value={
        show:true,
        titulo:"Error",
        texto:"No se pudo actualizar el inquilino."
      };

    }


  }finally{

    loading.value=false;

  }


};
const formatoFecha = (fecha: string) => (fecha ?? '').slice(0, 10);

</script>