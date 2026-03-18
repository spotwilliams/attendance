<script setup lang="ts">
import type { PaginatedAgents, Base } from '@/types/attendance';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

defineProps<{
    agents: PaginatedAgents;
    base: Base;
    dateFrom: string;
    dateTo: string;
    loading: boolean;
}>();

const emit = defineEmits<{
    paginate: [page: number];
}>();

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
                    {{ agents.total }} agentes encontrados
                    <span class="mx-1">&middot;</span>
                    {{ formatDate(dateFrom) }} — {{ formatDate(dateTo) }}
                </p>
            </div>
            <div class="text-sm text-gray-500">
                Página {{ agents.current_page }} de {{ agents.last_page }}
            </div>
        </div>

        <!-- Agent cards -->
        <div class="divide-y divide-gray-100">
            <div
                v-for="agent in agents.data"
                :key="agent.id"
                class="px-4 lg:px-5 py-3 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4"
            >
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-900 truncate">
                            {{ agent.apellido }}, {{ agent.nombre }}
                        </span>
                        <span
                            v-if="agent.observacion"
                            class="text-orange-500 cursor-help"
                            v-tooltip.right="agent.observacion"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex items-center gap-3 mt-0.5 text-sm text-gray-500">
                        <span>CUIT: {{ agent.cuit }}</span>
                        <Tag
                            v-if="agent.contrato?.tipo_contrato"
                            :value="agent.contrato.tipo_contrato.descripcion"
                            severity="info"
                            class="text-xs"
                        />
                        <span v-if="agent.operativo?.turno" class="text-xs text-gray-400">
                            {{ agent.operativo.turno.codigo }}
                        </span>
                    </div>
                </div>

                <!-- Attendance summary (compact badges) -->
                <div class="flex items-center gap-1 flex-shrink-0">
                    <span
                        v-for="p in agent.presentismos"
                        :key="p.id"
                        class="inline-flex items-center justify-center w-8 h-6 rounded text-xs font-medium"
                        :style="{
                            backgroundColor: p.tipo_presentismo?.color || '#e5e7eb',
                            color: p.tipo_presentismo?.color_letra || '#374151',
                        }"
                        v-tooltip.top="(p.tipo_presentismo?.descripcion || '') + ' — ' + formatDate(p.fecha)"
                    >
                        {{ p.tipo_presentismo?.codigo || '—' }}
                    </span>
                </div>
            </div>

            <!-- Empty state -->
            <div v-if="agents.data.length === 0" class="px-5 py-12 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-sm">No se encontraron agentes con los filtros seleccionados.</p>
            </div>
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
