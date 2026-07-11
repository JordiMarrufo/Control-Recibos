<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import Registro_pagos from '@/componentes/pagos_comp/registro_pagos.vue';
import Listado_pagos from '@/componentes/pagos_comp/Listado_pagos.vue';

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Control de pagos',

      },
    ],
  },
});
</script>

<template>

  <Head title="Control de pagos" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
     <Registro_pagos />
    <div
      class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
     
    <Listado_pagos />
    </div>
  </div>
</template>
