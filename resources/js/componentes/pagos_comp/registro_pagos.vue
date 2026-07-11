<template>
  <div class="p-6">
    <!-- Cabecera -->
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">
          Registro de Pagos Mensuales
        </h1>

        <p class="mt-1 text-sm text-slate-500">
          Controla los pagos de alquiler, agua y luz de tus inquilinos
        </p>
      </div>

      <button @click="showModal = true"
        class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">
        <Plus class="h-5 w-5" />

        <div class="text-left">
          <span class="block text-sm font-medium"> Nuevo Pago </span>

          <span class="block text-xs text-blue-100">
            Registrar mensualidad
          </span>
        </div>
      </button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
      <div class="w-full max-w-xl rounded-xl bg-white p-6 shadow-2xl">
        <div class="mb-6 flex items-center gap-2">
          <DollarSign class="h-6 w-6 text-blue-600" />

          <h2 class="text-xl font-semibold">Nuevo Pago Mensual</h2>
        </div>

        <form @submit.prevent="guardarPago" class="grid grid-cols-2 gap-4">
          <!-- Inquilino -->
          <div class="col-span-2">
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Inquilino
            </label>

            <div class="relative">
              <User class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <select v-model="form.inquilino_id" required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none">
                <option value="">
                  Seleccione un inquilino
                </option>

                <option v-for="inquilino in inquilinos" :key="inquilino.id" :value="inquilino.id">
                  {{ inquilino.name }}
                  {{ inquilino.apellido }}
                </option>
              </select>
            </div>
          </div>

          <!-- Alquiler -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Alquiler
            </label>

            <select v-model="form.alquiler_pagado"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
              <option :value="false">Pendiente</option>

              <option :value="true">Pagado</option>
            </select>
          </div>

          <!-- Agua -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Monto Agua
            </label>

            <div class="relative">
              <Droplets class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <input v-model="form.monto_agua" type="number" step="0.01" required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none" />
            </div>
          </div>

          <!-- Luz -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Monto Luz
            </label>

            <div class="relative">
              <Zap class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <input v-model="form.monto_luz" type="number" step="0.01" required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none" />
            </div>
          </div>

          <!-- Estado Agua -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Agua
            </label>

            <select v-model="form.agua_pagado" class="w-full rounded-lg border border-slate-300 px-3 py-2">
              <option :value="false">Pendiente</option>

              <option :value="true">Pagado</option>
            </select>
          </div>

          <!-- Estado Luz -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Luz
            </label>

            <select v-model="form.luz_pagado" class="w-full rounded-lg border border-slate-300 px-3 py-2">
              <option :value="false">Pendiente</option>

              <option :value="true">Pagado</option>
            </select>
          </div>

          <!-- Botones -->
          <div class="col-span-2 mt-4 flex justify-end gap-3">
            <button type="button" @click="showModal = false"
              class="rounded-lg border border-slate-300 px-5 py-2 hover:bg-slate-100">
              Cancelar
            </button>

            <button type="submit" :disabled="loading"
              class="flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 disabled:opacity-50">
              <Save class="h-4 w-4" />

              {{ loading ? 'Guardando...' : 'Guardar' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal de éxito -->
  <div v-if="showSuccessModal"
    class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-2xl">

      <div class="flex flex-col items-center text-center">

        <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>

        <h2 class="text-2xl font-bold text-slate-800">
          ¡Registro Exitoso!
        </h2>

        <p class="mt-3 text-slate-500">
          El pago mensual fue registrado correctamente.
        </p>

        <button @click="showSuccessModal = false"
          class="mt-8 rounded-lg bg-green-600 px-8 py-3 font-medium text-white transition hover:bg-green-700">
          Aceptar
        </button>

      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import axios from 'axios';

import { Plus, Save, DollarSign, User, Droplets, Zap } from '@lucide/vue';

const showModal = ref(false);
const showSuccessModal = ref(false);
const loading = ref(false);

const inquilinos = ref<any[]>([]);

const form = reactive({
  inquilino_id: '',

  alquiler_pagado: false,

  monto_agua: '',

  agua_pagado: false,

  monto_luz: '',

  luz_pagado: false,
});

const guardarPago = async () => {
  loading.value = true;

  try {
    await axios.post('/pagoMensualinquilino', {
      inquilino_id: form.inquilino_id,

      alquiler_pagado: form.alquiler_pagado,

      monto_agua: form.monto_agua,

      agua_pagado: form.agua_pagado,

      monto_luz: form.monto_luz,

      luz_pagado: form.luz_pagado,
    });

    showModal.value = false;
    showSuccessModal.value = true;

    form.inquilino_id = '';
    form.alquiler_pagado = false;
    form.monto_agua = '';
    form.agua_pagado = false;
    form.monto_luz = '';
    form.luz_pagado = false;
  } catch (error) {
    console.log(error);
  } finally {
    loading.value = false;
  }
};

const obtenerInquilinos = async () => {
  const response = await axios.get('/inquilinosback');

  inquilinos.value = response.data;
};

obtenerInquilinos();
</script>
