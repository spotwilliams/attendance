<script setup lang="ts">
import { ref } from 'vue';
import CellEditor from './CellEditor.vue';
import Popover from 'primevue/popover';
import type { AttendanceRecord } from '@/types/attendance';

const props = defineProps<{
    agentId: number;
    fecha: string;
    record?: AttendanceRecord;
    hasContract: boolean;
}>();

const emit = defineEmits<{
    saved: [record: AttendanceRecord | null];
}>();

const popoverRef = ref();

function toggle(event: Event) {
    if (!props.hasContract) return;
    popoverRef.value?.toggle(event);
}

function onSaved(record: AttendanceRecord | null) {
    popoverRef.value?.hide();
    emit('saved', record);
}
</script>

<template>
    <!-- No contract -->
    <div
        v-if="!hasContract"
        class="w-full h-8 rounded bg-gray-100 flex items-center justify-center cursor-not-allowed"
        v-tooltip.top="'Sin contrato'"
    >
        <span class="text-gray-300 text-xs">—</span>
    </div>

    <!-- Has contract -->
    <template v-else>
        <button
            class="w-full h-8 rounded text-xs font-medium transition-all hover:ring-2 hover:ring-orange-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
            :class="record?.tipo_presentismo ? 'cursor-pointer' : 'cursor-pointer border border-dashed border-gray-300 hover:border-orange-400'"
            :style="record?.tipo_presentismo ? {
                backgroundColor: record.tipo_presentismo.color || '#e5e7eb',
                color: record.tipo_presentismo.color_letra || '#374151',
            } : undefined"
            @click="toggle"
        >
            {{ record?.tipo_presentismo?.codigo || '' }}
        </button>

        <Popover ref="popoverRef" :pt="{ root: { class: 'w-64' } }">
            <CellEditor
                :agent-id="agentId"
                :fecha="fecha"
                :current-record="record"
                @saved="onSaved"
            />
        </Popover>
    </template>
</template>
