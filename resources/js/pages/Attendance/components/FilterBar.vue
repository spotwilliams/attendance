<script setup lang="ts">
import { computed } from 'vue';
import Select from 'primevue/select';
import MultiSelect from 'primevue/multiselect';
import DatePicker from 'primevue/datepicker';
import Button from 'primevue/button';
import type { Base, Shift, Area, Role, Filters } from '@/types/attendance';

const props = defineProps<{
    bases: Base[];
    shifts: Shift[];
    areas: Area[];
    roles: Role[];
    filters: Filters;
    loading: boolean;
}>();

const emit = defineEmits<{
    search: [];
    reset: [];
}>();

const availableShifts = computed(() =>
    props.shifts.map(s => ({
        ...s,
        label: s.descripcion?.trim() ? `${s.codigo} (${s.descripcion})` : s.codigo,
    }))
);

const dateRange = computed({
    get: () => {
        const from = props.filters.date_from ? new Date(props.filters.date_from + 'T12:00:00') : null;
        const to = props.filters.date_to ? new Date(props.filters.date_to + 'T12:00:00') : null;
        return from && to ? [from, to] : null;
    },
    set: (val: Date[] | null) => {
        if (val && val.length === 2 && val[0] && val[1]) {
            props.filters.date_from = val[0].toISOString().split('T')[0];
            props.filters.date_to = val[1].toISOString().split('T')[0];
        }
    },
});

const canSearch = computed(() => props.filters.base_id !== null && props.filters.date_from && props.filters.date_to);
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-200 p-4 lg:p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 items-end">
            <!-- Base (required) -->
            <div class="xl:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Base <span class="text-red-500">*</span>
                </label>
                <Select
                    v-model="filters.base_id"
                    :options="bases"
                    optionLabel="nombre"
                    optionValue="id"
                    placeholder="Seleccionar base"
                    class="w-full"
                    filter
                    showClear
                />
            </div>

            <!-- Shifts -->
            <div class="xl:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Turnos</label>
                <MultiSelect
                    v-model="filters.shifts"
                    :options="availableShifts"
                    optionLabel="label"
                    optionValue="id"
                    placeholder="Todos"
                    class="w-full"
                    :maxSelectedLabels="2"
                    selectedItemsLabel="{0} turnos"
                    filter
                />
            </div>

            <!-- Areas -->
            <div class="xl:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Áreas</label>
                <MultiSelect
                    v-model="filters.areas"
                    :options="areas"
                    optionLabel="nombre"
                    optionValue="id"
                    placeholder="Todas"
                    class="w-full"
                    :maxSelectedLabels="2"
                    selectedItemsLabel="{0} áreas"
                    filter
                />
            </div>

            <!-- Roles -->
            <div class="xl:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Funciones</label>
                <MultiSelect
                    v-model="filters.roles"
                    :options="roles"
                    optionLabel="nombre"
                    optionValue="id"
                    placeholder="Todas"
                    class="w-full"
                    :maxSelectedLabels="2"
                    selectedItemsLabel="{0} funciones"
                    filter
                />
            </div>

            <!-- Date range -->
            <div class="xl:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Rango de fechas</label>
                <DatePicker
                    v-model="dateRange"
                    selectionMode="range"
                    dateFormat="dd/mm/yy"
                    placeholder="Desde - Hasta"
                    class="w-full"
                    :maxDate="new Date()"
                    showIcon
                />
            </div>

            <!-- Actions -->
            <div class="xl:col-span-1 flex gap-2">
                <Button
                    label="Buscar"
                    icon="pi pi-search"
                    :loading="loading"
                    :disabled="!canSearch"
                    @click="$emit('search')"
                    class="flex-1"
                />
                <Button
                    icon="pi pi-filter-slash"
                    severity="secondary"
                    outlined
                    @click="$emit('reset')"
                    v-tooltip.bottom="'Limpiar filtros'"
                />
            </div>
        </div>
    </div>
</template>
