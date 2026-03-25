<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import FilterBar from './components/FilterBar.vue';
import AttendanceGrid from './components/AttendanceGrid.vue';
import { useFilters } from '@/composables/useFilters';
import type { Base, Shift, Area, Role, PaginatedAgents, AttendanceRecord } from '@/types/attendance';

const props = defineProps<{
    bases: Base[];
    shifts: Shift[];
    areas: Area[];
    roles: Role[];
    agents?: PaginatedAgents | null;
}>();

const { filters, reset } = useFilters();
const loading = ref(false);

const selectedBase = computed(() =>
    props.bases.find(b => b.id === filters.base_id) ?? null
);

// Auto-search if filters were restored from localStorage
onMounted(() => {
    if (filters.base_id && !props.agents) {
        search();
    }
});

function search(page = 1) {
    if (!filters.base_id) return;

    router.reload({
        data: {
            base_id: filters.base_id,
            date_from: filters.date_from,
            date_to: filters.date_to,
            shifts: filters.shifts,
            areas: filters.areas,
            roles: filters.roles,
            page,
        },
        only: ['agents'],
        onStart: () => { loading.value = true; },
        onFinish: () => { loading.value = false; },
    });
}

function handleReset() {
    reset();
    router.reload({
        only: ['agents'],
        data: {},
        onFinish: () => { loading.value = false; },
    });
}

function onCellSaved(agentId: number, record: AttendanceRecord | null, fecha: string) {
    if (!props.agents) return;

    const agent = props.agents.data.find(a => a.id === agentId);
    if (!agent) return;

    // Update local state without re-fetching
    const idx = agent.presentismos.findIndex(p => p.fecha === fecha);
    if (record) {
        if (idx >= 0) {
            agent.presentismos[idx] = record;
        } else {
            agent.presentismos.push(record);
        }
    } else if (idx >= 0) {
        agent.presentismos.splice(idx, 1);
    }
}
</script>

<template>
    <AppLayout>
        <Head title="Registro de Presentismo" />

        <div class="space-y-4">
            <!-- Page header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Registro de Presentismo.</h1>
                <p class="text-sm text-gray-500 mt-1">Seleccioná una base y el rango de fechas para ver los agentes.</p>
            </div>

            <!-- Filters -->
            <FilterBar
                :bases="bases"
                :shifts="shifts"
                :areas="areas"
                :roles="roles"
                :filters="filters"
                :loading="loading"
                @search="search(1)"
                @reset="handleReset"
            />

            <!-- Loading skeleton (initial load) -->
            <div v-if="loading && !agents" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-4 lg:px-5 py-3">
                    <div class="h-5 w-40 bg-gray-200 rounded animate-pulse mb-2" />
                    <div class="h-4 w-64 bg-gray-100 rounded animate-pulse" />
                </div>
                <div class="p-4 space-y-3">
                    <div v-for="i in 8" :key="i" class="flex gap-2 items-center">
                        <div class="w-[200px] h-8 bg-gray-100 rounded animate-pulse flex-shrink-0" />
                        <div class="w-[100px] h-8 bg-gray-50 rounded animate-pulse flex-shrink-0" />
                        <div v-for="j in 7" :key="j" class="w-[80px] h-8 bg-gray-100 rounded animate-pulse flex-shrink-0" />
                    </div>
                </div>
            </div>

            <!-- Results -->
            <AttendanceGrid
                v-else-if="agents && selectedBase"
                :agents="agents"
                :base="selectedBase"
                :date-from="filters.date_from"
                :date-to="filters.date_to"
                :loading="loading"
                @paginate="search"
                @saved="onCellSaved"
            />

            <!-- Initial empty state -->
            <div v-else-if="!loading" class="bg-white rounded-xl border border-gray-200 px-5 py-16 text-center">
                <div class="mx-auto w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Registro de asistencia</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto">
                    Seleccioná una base y opcionalmente filtrá por turno, área o función.
                    Luego hacé clic en <strong>Buscar</strong> para ver los agentes.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
