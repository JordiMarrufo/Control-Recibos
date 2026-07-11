<template>
  <div>
    <!-- Botón Editar -->
    <button
      @click="abrirModal"
      class="rounded-lg bg-yellow-500 px-3 py-2 text-white transition hover:bg-yellow-600"
    >
      Editar
    </button>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
    >
      <div class="w-full max-w-xl rounded-xl bg-white p-6 shadow-2xl">
        <div class="mb-6 flex items-center gap-2">
          <DollarSign class="h-6 w-6 text-yellow-600" />

          <h2 class="text-xl font-semibold">
            Editar Pago Mensual
          </h2>
        </div>

        <form @submit.prevent="actualizarPago" class="grid grid-cols-2 gap-4">

          <!-- Inquilino -->
          <div class="col-span-2">
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Inquilino
            </label>

            <div class="relative">
              <User class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <select
                v-model="form.inquilino_id"
                required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none"
              >
                <option value="">
                  Seleccione un inquilino
                </option>

                <option
                  v-for="inquilino in inquilinos"
                  :key="inquilino.id"
                  :value="inquilino.id"
                >
                  {{ inquilino.name }} {{ inquilino.apellido }}
                </option>
              </select>
            </div>
          </div>

          <!-- Mensualidad -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Monto Mensual
            </label>

            <div class="relative">
              <DollarSign class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <input
                v-model="form.mensual_monto"
                type="number"
                step="0.01"
                required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none"
              />
            </div>
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Mensualidad
            </label>

            <select
              v-model="form.mensual_pagado"
              class="w-full rounded-lg border border-slate-300 px-3 py-2"
            >
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

              <input
                v-model="form.monto_agua"
                type="number"
                step="0.01"
                required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none"
              />
            </div>
          </div>

          <!-- Luz -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Monto Luz
            </label>

            <div class="relative">
              <Zap class="absolute top-3 left-3 h-4 w-4 text-slate-400" />

              <input
                v-model="form.monto_luz"
                type="number"
                step="0.01"
                required
                class="w-full rounded-lg border border-slate-300 py-2 pr-3 pl-10 focus:border-blue-500 focus:outline-none"
              />
            </div>
          </div>

          <!-- Estado Agua -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Agua
            </label>

            <select
              v-model="form.agua_pagado"
              class="w-full rounded-lg border border-slate-300 px-3 py-2"
            >
              <option :value="false">Pendiente</option>
              <option :value="true">Pagado</option>
            </select>
          </div>

          <!-- Estado Luz -->
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-600">
              Estado Luz
            </label>

            <select
              v-model="form.luz_pagado"
              class="w-full rounded-lg border border-slate-300 px-3 py-2"
            >
              <option :value="false">Pendiente</option>
              <option :value="true">Pagado</option>
            </select>
          </div>

          <!-- Botones -->
          <div class="col-span-2 mt-4 flex justify-end gap-3">
            <button
              type="button"
              @click="showModal = false"
              class="rounded-lg border border-slate-300 px-5 py-2 hover:bg-slate-100"
            >
              Cancelar
            </button>

            <button
              type="submit"
              :disabled="loading"
              class="flex items-center gap-2 rounded-lg bg-yellow-500 px-5 py-2 text-white hover:bg-yellow-600 disabled:opacity-50"
            >
              <Save class="h-4 w-4" />

              {{ loading ? 'Actualizando...' : 'Actualizar' }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import axios from 'axios';

import {
  Save,
  DollarSign,
  User,
  Droplets,
  Zap
} from '@lucide/vue';

const props = defineProps({
  pago: {
    type: Object,
    required: true,
  },
});

const showModal = ref(false);
const loading = ref(false);
const inquilinos = ref<any[]>([]);

const form = reactive({
  inquilino_id: '',
  mensual_monto: '',
  mensual_pagado: false,
  monto_agua: '',
  agua_pagado: false,
  monto_luz: '',
  luz_pagado: false,
});

const abrirModal = () => {
  form.inquilino_id = props.pago.inquilino_id;
  form.mensual_monto = props.pago.mensual_monto;
  form.mensual_pagado = !!props.pago.mensual_pagado;
  form.monto_agua = props.pago.monto_agua;
  form.agua_pagado = !!props.pago.agua_pagado;
  form.monto_luz = props.pago.monto_luz;
  form.luz_pagado = !!props.pago.luz_pagado;

  showModal.value = true;
};

const actualizarPago = async () => {
  loading.value = true;

  try {
    await axios.put(`/pagoMensualinquilino/${props.pago.id}`, {
      inquilino_id: form.inquilino_id,
      mensual_monto: parseFloat(String(form.mensual_monto)) || 0,
      mensual_pagado: form.mensual_pagado,
      monto_agua: parseFloat(String(form.monto_agua)) || 0,
      agua_pagado: form.agua_pagado,
      monto_luz: parseFloat(String(form.monto_luz)) || 0,
      luz_pagado: form.luz_pagado,
    });

    showModal.value = false;

    // Si usas Inertia puedes reemplazar esto por router.reload()
    window.location.reload();
  } catch (error: any) {
    console.error(error.response?.data ?? error);
  } finally {
    loading.value = false;
  }
};

const obtenerInquilinos = async () => {
  try {
    const response = await axios.get('/inquilinosback');
    inquilinos.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

obtenerInquilinos();
</script>