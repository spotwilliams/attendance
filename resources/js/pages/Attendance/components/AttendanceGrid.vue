<script setup lang="ts">
import { computed } from 'vue';
import AttendanceCell from './AttendanceCell.vue';
import Button from 'primevue/button';
import type { Agent, PaginatedAgents, Base, AttendanceRecord } from '@/types/attendance';

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

const dateColumns = computed(() => {
    const dates: { key: string; label: string; dayName: string }[] = [];
    const from = new Date(props.dateFrom + 'T12:00:00');
    const to = new Date(props.dateTo + 'T12:00:00');
    const current = new Date(from);

    while (current <= to) {
        const key = current.toISOString().split('T')[0];
        dates.push({
            key,
            label: current.toLocaleDateString('es-AR', { day: '2-digit', month: '2-digit' }),
            dayName: current.toLocaleDateString('es-AR', { weekday: 'short' }),
        });
        current.setDate(current.getDate() + 1);
    }
    return dates;
});

function getRecordForDate(agent: Agent, dateKey: string): AttendanceRecord | undefined {
    return agent.presentismos.find(p => p.fecha === dateKey);
}

function hasContract(agent: Agent): boolean {
    return agent.contrato !== null;
}

function formatDate(dateStr: string): string {
    const d = new Date(dateStr + 'T12:00:00');
    return d.toLocaleDateString('es-AR', { day: '2-digit', month: '2-digit' });
}
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="border-b border-gray-200 px-4 lg:px-5 py-3 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ base.nombre }}</h2>
                <p class="text-sm text-gray-500">
                    {{ agents.total }} agentes
                    <span class="mx-1">&middot;</span>
                    {{ formatDate(dateFrom) }} — {{ formatDate(dateTo) }}
                </p>
            </div>
            <div class="text-sm text-gray-500">
                Página {{ agents.current_page }} de {{ agents.last_page }}
            </div>
        </div>

        <!-- Grid table -->
        <div class="overflow-x-auto">
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
                            class="px-1 py-2 text-center font-medium text-gray-700 min-w-[80px]"
                        >
                            <div class="text-xs">{{ col.dayName }}</div>
                            <div>{{ col.label }}</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr
                        v-for="agent in agents.data"
                        :key="agent.id"
                        class="hover:bg-gray-50/50"
                    >
                        <!-- Agent name (sticky) -->
                        <td class="sticky left-0 z-10 bg-white px-4 py-2">
                            <div class="font-medium text-gray-900 truncate max-w-[180px]">
                                {{ agent.apellido }}, {{ agent.nombre }}
                            </div>
                            <div class="text-xs text-gray-400">{{ agent.cuit }}</div>
                        </td>

                        <!-- Contract type -->
                        <td class="px-2 py-2 text-xs text-gray-500">
                            <span v-if="agent.contrato?.tipo_contrato" class="truncate block max-w-[90px]">
                                {{ agent.contrato.tipo_contrato.descripcion }}
                            </span>
                            <span v-else class="text-gray-300">—</span>
                        </td>

                        <!-- Date cells -->
                        <td
                            v-for="col in dateColumns"
                            :key="`${agent.id}-${col.key}`"
                            class="px-1 py-1 text-center"
                        >
                            <AttendanceCell
                                :agent-id="agent.id"
                                :fecha="col.key"
                                :record="getRecordForDate(agent, col.key)"
                                :has-contract="hasContract(agent)"
                                @saved="(record) => $emit('saved', agent.id, record, col.key)"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Empty state -->
        <div v-if="agents.data.length === 0" class="px-5 py-12 text-center text-gray-400">
            <p class="text-sm">No se encontraron agentes con los filtros seleccionados.</p>
        </div>

        <!-- Pagination -->
        <div v-if="agents.last_page > 1" class="border-t border-gray-200 px-4 lg:px-5 py-3 flex items-center justify-between">
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
    </div>
</template>
