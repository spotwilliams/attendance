<script setup lang="ts">
import {computed, ref} from 'vue';
import axios from 'axios';
import AttendanceCell from './AttendanceCell.vue';
import CommentDialog from './CommentDialog.vue';
import Button from 'primevue/button';
import type {Agent, PaginatedAgents, Base, AttendanceRecord} from '@/types/attendance';

import {onKeyStroke} from '@vueuse/core'

const props = defineProps<{
  agents: PaginatedAgents;
  base: Base;
  dateFrom: string;
  dateTo: string;
  loading: boolean;
}>();

const emit = defineEmits<{
  paginate: [page: number];
  saved: [agentId: number, record: AttendanceRecord | null, fecha: string];
}>();

// Keyboard navigation
const focusedRow = ref(0);
const focusedCol = ref(0);
const gridRef = ref<HTMLElement>();

const dateColumns = computed(() => {
  const dates: { key: string; label: string; dayName: string; isToday: boolean; isWeekend: boolean }[] = [];
  const from = new Date(props.dateFrom + 'T12:00:00');
  const to = new Date(props.dateTo + 'T12:00:00');
  const today = new Date().toISOString().split('T')[0];
  const current = new Date(from);

  while (current <= to) {
    const key = current.toISOString().split('T')[0];
    const day = current.getDay();
    dates.push({
      key,
      label: current.toLocaleDateString('es-AR', {day: '2-digit', month: '2-digit'}),
      dayName: current.toLocaleDateString('es-AR', {weekday: 'short'}),
      isToday: key === today,
      isWeekend: day === 0 || day === 6,
    });
    current.setDate(current.getDate() + 1);
  }
  return dates;
});

// Progress
const totalCells = computed(() => props.agents.data.length * dateColumns.value.length);
const filledCells = computed(() =>
    props.agents.data.reduce((sum, agent) => sum + agent.presentismos.length, 0)
);
const progressPercent = computed(() =>
    totalCells.value > 0 ? Math.round((filledCells.value / totalCells.value) * 100) : 0
);

function getRecordForDate(agent: Agent, dateKey: string): AttendanceRecord | undefined {
  return agent.presentismos.find(p => p.fecha === dateKey);
}

function getCellStyle(agent: Agent, dateKey: string): Record<string, string> | undefined {
  const tipo = getRecordForDate(agent, dateKey)?.tipo_presentismo;
  if (!tipo) return undefined;
  return { backgroundColor: '#f3f4f6', color: tipo.color || '#374151' };
}

function formatDate(dateStr: string): string {
  const d = new Date(dateStr + 'T12:00:00');
  return d.toLocaleDateString('es-AR', {day: '2-digit', month: '2-digit'});
}

// Keyboard navigation
function getCellId(row: number, col: number): string {
  return `cell-${row}-${col}`;
}

const gridHasFocus = ref(false);
const editingRow = ref(-1);
const editingCol = ref(-1);
const maxRow = computed(() => props.agents.data.length - 1);
const maxCol = computed(() => dateColumns.value.length - 1);
const isEditing = ref(false);

function openEditor(row: number, col: number) {
  isEditing.value = true;
  const agent = props.agents.data[row];
  if (!agent?.has_contract) return;
  editingRow.value = row;
  editingCol.value = col;
}

function closeEditor() {
  isEditing.value = false;
  editingRow.value = -1;
  editingCol.value = -1;
}

function onEditorSaved(agentId: number, record: AttendanceRecord | null, fecha: string) {
  emit('saved', agentId, record, fecha);
  closeEditor();
}

// Comment dialog
const commentRecord = ref<AttendanceRecord | undefined>();
const commentAgentName = ref('');
const showCommentDialog = ref(false);

function openCommentDialog(agent: Agent, dateKey: string) {
  const record = getRecordForDate(agent, dateKey);
  if (!record) return;
  isEditing.value = true;
  commentRecord.value = record;
  commentAgentName.value = `${agent.apellido}, ${agent.nombre}`;
  showCommentDialog.value = true;
}

function closeCommentDialog() {
  showCommentDialog.value = false;
  isEditing.value = false;
}

// Justify / Unjustify
const justifyingId = ref<number | null>(null);

async function toggleJustify(agent: Agent, dateKey: string) {
  const record = getRecordForDate(agent, dateKey);
  if (!record) return;

  justifyingId.value = record.id;
  const action = record.injustificado ? 'justify' : 'unjustify';

  try {
    const { data } = await axios.post(`/app/attendance/${record.id}/${action}`);
    emit('saved', agent.id, data.presentismo, dateKey);
  } catch (e: any) {
    alert(e.response?.data?.message || 'Error al procesar');
  } finally {
    justifyingId.value = null;
  }
}

onKeyStroke('Enter', (e) => {
  if (isEditing.value) return;
  e.preventDefault();
  openEditor(focusedRow.value, focusedCol.value);
})

onKeyStroke('ArrowLeft', (e) => {
  if (isEditing.value) return;
  e.preventDefault();
  if (focusedCol.value > 0) {
    focusedCol.value--;
  }
})

onKeyStroke('ArrowRight', (e) => {
  if (isEditing.value) return;
  e.preventDefault();
  if (focusedCol.value < maxCol.value) {
    focusedCol.value++;
  }
})

onKeyStroke('ArrowDown', (e) => {
  if (isEditing.value) return;
  e.preventDefault();
  if (focusedRow.value < maxRow.value) {
    focusedRow.value++;
  }
})

onKeyStroke('ArrowUp', (e) => {
  if (isEditing.value) return;
  e.preventDefault();
  if (focusedRow.value > 0) {
    focusedRow.value--;
  }
})

onKeyStroke('Escape', (e) => {
  e.preventDefault();
  gridHasFocus.value = false;
})


function onCellFocus(row: number, col: number) {
  focusedRow.value = row;
  focusedCol.value = col;
  gridHasFocus.value = true;
}

function onCellClick(row: number, col: number, event: MouseEvent) {
  event.stopPropagation();
  focusedRow.value = row;
  focusedCol.value = col;
  gridHasFocus.value = true;
  openEditor(focusedRow.value, focusedCol.value);
}
</script>

<template>
  <div
      class="bg-white rounded-xl border border-gray-200 overflow-hidden"
      ref="gridRef"
      @focusin="gridHasFocus = true"
      @focusout="gridHasFocus = false"
  >
    <!-- Header with progress -->
    <div class="border-b border-gray-200 px-4 lg:px-5 py-3">
      <div class="flex items-center justify-between mb-2">
        <div>
          <h2 class="text-lg font-semibold text-gray-900">{{ base.nombre }}</h2>
          <p class="text-sm text-gray-500">
            {{ agents.total }} agentes
            <span class="mx-1">&middot;</span>
            {{ formatDate(dateFrom) }} — {{ formatDate(dateTo) }}
          </p>
        </div>
        <div class="flex items-center gap-4">
          <!-- Progress -->
          <div class="text-right">
            <div class="text-sm font-medium text-gray-700">
              {{ filledCells }} / {{ totalCells }}
            </div>
            <div class="text-xs text-gray-400">registrados</div>
          </div>
          <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
            <div
                class="h-full rounded-full transition-all duration-300"
                :class="progressPercent === 100 ? 'bg-green-500' : 'bg-orange-400'"
                :style="{ width: `${progressPercent}%` }"
            />
          </div>
          <span class="text-xs font-medium" :class="progressPercent === 100 ? 'text-green-600' : 'text-gray-500'">
                        {{ progressPercent }}%
                    </span>
        </div>
      </div>
      <div class="text-xs text-gray-400">
        Página {{ agents.current_page }} de {{ agents.last_page }}
        <span class="mx-1">&middot;</span>
        Usá las flechas del teclado para navegar, Enter para editar
      </div>
    </div>

    <!-- Loading skeleton -->
    <div v-if="loading" class="p-4 space-y-3">
      <div v-for="i in 8" :key="i" class="flex gap-2 items-center">
        <div class="w-[200px] h-8 bg-gray-100 rounded animate-pulse flex-shrink-0"/>
        <div class="w-[100px] h-8 bg-gray-50 rounded animate-pulse flex-shrink-0"/>
        <div v-for="j in 7" :key="j" class="w-[80px] h-8 bg-gray-100 rounded animate-pulse flex-shrink-0"/>
      </div>
    </div>

    <!-- Grid table -->
    <div v-else class="overflow-x-auto scroll-smooth" role="grid">
      <table class="w-full text-sm">
        <thead>
        <tr class="bg-gray-50 border-b border-gray-200">
          <th class="sticky left-0 z-10 bg-gray-50 px-4 py-2 text-left font-medium text-gray-700 min-w-[200px]">
            Agente
          </th>
          <th class="px-2 py-2 text-left font-medium text-gray-500 min-w-[100px]">
            Contrato
          </th>
          <th
              v-for="col in dateColumns"
              :key="col.key"
              class="px-1 py-2 text-center font-medium min-w-[72px]"
              :class="{
                                'bg-orange-50/80 text-orange-700': col.isToday,
                                'bg-gray-100/50 text-gray-400': col.isWeekend && !col.isToday,
                                'text-gray-700': !col.isToday && !col.isWeekend,
                            }"
          >
            <div class="text-[10px] uppercase">{{ col.dayName }}</div>
            <div class="text-xs">{{ col.label }}</div>
          </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
        <tr
            v-for="(agent, rowIdx) in agents.data"
            :key="agent.id"
            class="hover:bg-gray-50/50"
        >
          <!-- Agent name (sticky) -->
          <td class="sticky left-0 z-10 bg-white px-4 py-2 border-r border-gray-100">
            <div class="font-medium text-gray-900 truncate max-w-[180px]">
              {{ agent.apellido }}, {{ agent.nombre }}
            </div>
            <div class="text-xs text-gray-400">{{ agent.cuit }}</div>
          </td>

          <!-- Contract type -->
          <td class="px-2 py-2 text-xs text-gray-500 border-r border-gray-100">
                            <span v-if="agent.contract_type" class="truncate block max-w-[90px]">
                                {{ agent.contract_type }}
                            </span>
            <span v-else class="text-gray-300">—</span>
          </td>

          <!-- Date cells -->
          <td
              v-for="(col, colIdx) in dateColumns"
              :key="`${agent.id}-${col.key}`"
              :id="getCellId(rowIdx, colIdx)"
              class="px-2 py-0.5 text-center"
              :class="{
                                'bg-orange-50/40': col.isToday,
                                'bg-gray-50/40': col.isWeekend && !col.isToday,
                                'ring-2 ring-inset ring-orange-400/60 rounded-md': focusedRow === rowIdx && focusedCol === colIdx,
                            }"
          >
            <template v-if="agent.has_contract">
              <!-- Editor mode -->
              <AttendanceCell
                  v-if="editingRow === rowIdx && editingCol === colIdx"
                  :agent-id="agent.id"
                  :fecha="col.key"
                  :record="getRecordForDate(agent, col.key)"
                  @saved="(record) => onEditorSaved(agent.id, record, col.key)"
                  @close="closeEditor"
              />

              <!-- Display mode -->
              <div v-else class="flex flex-col items-center gap-0.5">
                <button
                    class="w-full h-8 rounded-md text-xs font-semibold focus:outline-none"
                    :class="getRecordForDate(agent, col.key)?.tipo_presentismo
                                      ? 'cursor-pointer'
                                      : 'cursor-pointer border border-dashed border-gray-200'"
                    :style="getCellStyle(agent, col.key)"
                    @focus="onCellFocus(rowIdx, colIdx)"
                    @click="onCellClick(rowIdx, colIdx, $event)"
                >
                  {{ getRecordForDate(agent, col.key)?.tipo_presentismo?.codigo || '' }}
                </button>
                <div v-if="getRecordForDate(agent, col.key)" class="flex items-center gap-1">
                  <!-- Comment button -->
                  <button
                      class="p-0.5 text-gray-400 hover:text-orange-600 transition-colors cursor-pointer"
                      :title="`Comentarios ${col.key}`"
                      @click.stop="openCommentDialog(agent, col.key)"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                  </button>
                  <!-- Justify/Unjustify button with popover -->
                  <div class="relative group">
                    <button
                        class="p-0.5 transition-colors cursor-pointer"
                        :class="getRecordForDate(agent, col.key)!.injustificado
                          ? 'text-red-400 hover:text-green-600'
                          : 'text-green-500 hover:text-red-400'"
                        :disabled="justifyingId === getRecordForDate(agent, col.key)!.id"
                        @click.stop="toggleJustify(agent, col.key)"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path v-if="justifyingId === getRecordForDate(agent, col.key)!.id" stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        <path v-else stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                    </button>
                    <!-- Popover -->
                    <div class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-1 z-20">
                      <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-3 w-40 text-center">
                        <span
                            class="inline-block text-xs font-bold text-white px-2 py-0.5 rounded mb-2"
                            :class="getRecordForDate(agent, col.key)!.injustificado ? 'bg-red-500' : 'bg-green-500'"
                        >
                          {{ getRecordForDate(agent, col.key)!.injustificado ? 'Injustificado' : 'Justificado' }}
                        </span>
                        <p class="text-xs text-gray-600 mb-2">Click para marcar el presentismo como</p>
                        <span
                            class="inline-block text-xs font-bold text-white px-2 py-0.5 rounded"
                            :class="getRecordForDate(agent, col.key)!.injustificado ? 'bg-green-500' : 'bg-red-500'"
                        >
                          {{ getRecordForDate(agent, col.key)!.injustificado ? 'Justificado' : 'Injustificado' }}
                        </span>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-px">
                          <div class="w-2 h-2 bg-white border-b border-r border-gray-200 rotate-45 -translate-y-1"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </template>

            <!-- No contract -->
            <div
                v-else
                class="w-full h-8 rounded-md bg-gray-50 flex items-center justify-center cursor-not-allowed"
            >
              <span class="text-gray-300 text-xs">—</span>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- Empty state -->
    <div v-if="!loading && agents.data.length === 0" class="px-5 py-12 text-center text-gray-400">
      <p class="text-sm">No se encontraron agentes con los filtros seleccionados.</p>
    </div>

    <!-- Pagination -->
    <div v-if="agents.last_page > 1"
         class="border-t border-gray-200 px-4 lg:px-5 py-3 flex items-center justify-between">
      <p class="text-sm text-gray-500">
        Mostrando {{ agents.from }} a {{ agents.to }} de {{ agents.total }}
      </p>
      <div class="flex gap-1">
        <Button
            icon="pi pi-angle-left"
            severity="secondary"
            text
            size="small"
            :disabled="agents.current_page === 1"
            @click="$emit('paginate', agents.current_page - 1)"
        />
        <Button
            v-for="page in agents.last_page"
            :key="page"
            :label="String(page)"
            :severity="page === agents.current_page ? undefined : 'secondary'"
            :text="page !== agents.current_page"
            size="small"
            @click="$emit('paginate', page)"
            v-show="Math.abs(page - agents.current_page) <= 2 || page === 1 || page === agents.last_page"
        />
        <Button
            icon="pi pi-angle-right"
            severity="secondary"
            text
            size="small"
            :disabled="agents.current_page === agents.last_page"
            @click="$emit('paginate', agents.current_page + 1)"
        />
      </div>
    </div>

    <!-- Comment dialog -->
    <CommentDialog
        v-if="showCommentDialog && commentRecord"
        :record="commentRecord"
        :agent-name="commentAgentName"
        @close="closeCommentDialog"
    />
  </div>
</template>
