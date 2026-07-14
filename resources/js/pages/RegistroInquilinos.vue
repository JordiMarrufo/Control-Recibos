<template>
  <div class="container">
    <div class="header-actions">
      <h1>Registro de Inquilinos</h1>
      <button @click="showModal = true" class="btn-primary">
        + Agregar Inquilino
      </button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
      <div class="modal-content">
        <h2 class="modal-title"> Nuevo Inquilino</h2>
        
        <form @submit.prevent="guardarInquilino" class="form-grid">
          <div class="field"><label> Nombre</label><input type="text" v-model="form.nombre" required /></div>
          <div class="field"><label> Apellido</label><input type="text" v-model="form.apellido" required /></div>
          <div class="field"><label> Teléfono</label><input type="tel" v-model="form.telefono" maxlength="9" required /></div>
<div class="field">
  <label>DNI</label>
  <input 
    type="text" 
    v-model="form.dni" 
    @input="form.dni = form.dni.slice(0, 8)" 
    required 
  />
</div>          <div class="field"><label> Correo</label><input type="email" v-model="form.correo" required /></div>
          <div class="field"><label> Cuota (S/)</label><input type="number" v-model="form.cuota" required /></div>
          <div class="field full-width">
            <label> Día de ingreso</label>
            <input type="date" v-model="form.diaIngreso" :min="today" required />
          </div>

          <div class="actions">
            <button type="button" @click="showModal = false" class="btn-cancel">Cancelar</button>
            <button type="submit" class="btn-save">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue';

const showModal = ref(false);
const today = computed(() => new Date().toLocaleDateString('en-CA'));
const form = reactive({ nombre: '', apellido: '', telefono: '', dni: '', correo: '', cuota: '', diaIngreso: '' });

const guardarInquilino = () => {
  console.log(form);
  showModal.value = false;
};
</script>

<style scoped>
.container { padding: 20px; }
.header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }

/* Botón azul original */
.btn-primary { background-color: #3f51b5; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }

/* Modal estético */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 1000; }
.modal-content { background: white; padding: 30px; border-radius: 16px; width: 450px; box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
.modal-title { margin-bottom: 20px; font-size: 1.4rem; color: #1e293b; font-weight: 600; }

/* Grid de formulario */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.field { display: flex; flex-direction: column; }
.full-width { grid-column: span 2; }
label { font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 5px; }
input { width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 8px; box-sizing: border-box; transition: 0.2s; }
input:focus { border-color: #3f51b5; outline: none; }

/* Botones del formulario */
.actions { grid-column: span 2; display: flex; justify-content: flex-end; gap: 12px; margin-top: 15px; }
button { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
.btn-save { background: #3f51b5; color: white; }
.btn-cancel { background: #f1f5f9; color: #475569; }
</style>    