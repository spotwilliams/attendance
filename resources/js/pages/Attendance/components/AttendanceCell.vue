<script setup lang="ts">
import {ref, onMounted, nextTick} from 'vue';
import CellEditor from './CellEditor.vue';
import Popover from 'primevue/popover';
import type {AttendanceRecord} from '@/types/attendance';

defineProps<{
  agentId: number;
  fecha: string;
  record?: AttendanceRecord;
}>();

const emit = defineEmits<{
  saved: [record: AttendanceRecord | null];
  close: [];
}>();

const popoverRef = ref();
const triggerRef = ref<HTMLButtonElement>();

onMounted(() => {
  // This allows us to open the popover immediately if the cell already has a record (e.g. when editing an existing attendance)
  nextTick(() => {
    popoverRef.value?.toggle(
        {currentTarget: triggerRef.value} as unknown as Event
    );
  });
});

function toggle(event: Event) {
  popoverRef.value?.toggle(event);
}

function onSaved(record: AttendanceRecord | null) {
  popoverRef.value?.hide();
  emit('saved', record);
}

function onPopoverHide() {
  emit('close');
}
</script>

<template>
  <!-- Trigger button (visually matches the grid badge) -->
  <button
      ref="triggerRef"
      class="w-full h-8 rounded-md text-xs font-semibold transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-orange-400/70"
      :class="record?.tipo_presentismo
            ? 'cursor-pointer shadow-xs'
            : 'cursor-pointer border border-dashed border-gray-200'"
      :style="record?.tipo_presentismo ? {
            backgroundColor: record.tipo_presentismo.color || '#f3f4f6',
            color: record.tipo_presentismo.color_letra || '#374151',
        } : undefined"
      @click="toggle"
  >
    {{ record?.tipo_presentismo?.codigo || '' }}
  </button>

  <Popover ref="popoverRef" :pt="{ root: { class: 'w-64' } }" @hide="onPopoverHide">
    <CellEditor
        :agent-id="agentId"
        :fecha="fecha"
        :current-record="record"
        @saved="onSaved"
    />
  </Popover>
</template>
