<script setup lang="ts">
import { ref, computed, onMounted, nextTick, watch } from 'vue';
import { onKeyStroke } from '@vueuse/core';
import Button from 'primevue/button';
import type { AttendanceRecord, AttendanceType, TypesResponse, StoreResponse } from '@/types/attendance';

const props = defineProps<{
    agentId: number;
    fecha: string;
    currentRecord?: AttendanceRecord;
}>();

const emit = defineEmits<{
    saved: [record: AttendanceRecord | null];
}>();

const types = ref<AttendanceType[]>([]);
const hasContract = ref(true);
const loadingTypes = ref(true);
const saving = ref(false);
const error = ref<string | null>(null);
const search = ref('');
const searchInput = ref<HTMLInputElement>();
const highlightedIndex = ref(-1);

const filteredTypes = computed(() => {
    if (!search.value) return types.value;
    const q = search.value.toLowerCase();
    return types.value.filter(t =>
        t.codigo.toLowerCase().includes(q) || t.descripcion.toLowerCase().includes(q)
    );
});

// Reset highlight when filtered list changes
watch(filteredTypes, () => {
    highlightedIndex.value = filteredTypes.value.length > 0 ? 0 : -1;
});

onKeyStroke('ArrowDown', (e) => {
    e.preventDefault();
    const len = filteredTypes.value.length;
    if (len === 0) return;
    highlightedIndex.value = (highlightedIndex.value + 1) % len;
    scrollToHighlighted();
}, { target: searchInput })

onKeyStroke('ArrowUp', (e) => {
    e.preventDefault();
    const len = filteredTypes.value.length;
    if (len === 0) return;
    highlightedIndex.value = (highlightedIndex.value - 1 + len) % len;
    scrollToHighlighted();
}, { target: searchInput })

onKeyStroke('Enter', (e) => {
    e.preventDefault();
    const len = filteredTypes.value.length;
    if (len === 0) return;
    if (highlightedIndex.value >= 0 && highlightedIndex.value < len) {
        selectType(filteredTypes.value[highlightedIndex.value].id);
    }
}, { target: searchInput })

function scrollToHighlighted() {
    nextTick(() => {
        const el = document.getElementById(`type-option-${highlightedIndex.value}`);
        el?.scrollIntoView({ block: 'nearest' });
    });
}

onMounted(async () => {
    try {
        const response = await fetch(`/app/attendance/types/agent/${props.agentId}/date/${props.fecha}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data: TypesResponse = await response.json();
        types.value = data.types;
        hasContract.value = data.has_contract;
    } catch {
        error.value = 'Error al cargar tipos';
    } finally {
        loadingTypes.value = false;
        nextTick(() => searchInput.value?.focus());
    }
});

async function selectType(typeId: number) {
    saving.value = true;
    error.value = null;

    try {
        const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        const response = await fetch('/app/attendance/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
            },
            body: JSON.stringify({
                agente: props.agentId,
                fecha: props.fecha,
                presentismo: typeId,
            }),
        });

        const data: StoreResponse = await response.json();

        if (!response.ok) {
            error.value = data.message;
            return;
        }

        emit('saved', data.presentismo);
    } catch {
        error.value = 'Error al guardar';
    } finally {
        saving.value = false;
    }
}

async function clear() {
    await selectType(-1);
}
</script>

<template>
    <div class="p-2 space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-500">{{ fecha }}</span>
            <Button
                v-if="currentRecord"
                icon="pi pi-trash"
                severity="danger"
                text
                size="small"
                @click="clear"
                :loading="saving"
                v-tooltip.left="'Eliminar'"
            />
        </div>

        <!-- Error -->
        <div v-if="error" class="text-xs text-red-600 bg-red-50 rounded px-2 py-1">
            {{ error }}
        </div>

        <!-- Loading -->
        <div v-if="loadingTypes" class="space-y-1">
            <div v-for="i in 4" :key="i" class="h-7 bg-gray-100 rounded animate-pulse" />
        </div>

        <!-- No contract -->
        <div v-else-if="!hasContract" class="text-xs text-gray-400 text-center py-2">
            Sin contrato en esta fecha
        </div>

        <!-- Types with search -->
        <template v-else>
            <!-- Search input -->
            <input
                ref="searchInput"
                v-model="search"
                type="text"
                placeholder="Buscar tipo..."
                class="w-full px-2 py-1.5 text-xs border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-orange-400 focus:border-orange-400"
            />

            <!-- Types list -->
            <div class="space-y-0.5 max-h-48 overflow-y-auto">
                <button
                    v-for="(type, idx) in filteredTypes"
                    :key="type.id"
                    :id="`type-option-${idx}`"
                    class="w-full flex items-center gap-2 px-2 py-1.5 rounded text-left text-xs transition-colors"
                    :class="{
                        'ring-2 ring-orange-400 bg-orange-50': currentRecord?.id_tipo_presentismo === type.id,
                        'bg-gray-100': highlightedIndex === idx && currentRecord?.id_tipo_presentismo !== type.id,
                    }"
                    :disabled="saving"
                    @click="selectType(type.id)"
                >
                    <span
                        class="inline-flex items-center justify-center w-8 h-5 rounded text-[10px] font-bold flex-shrink-0"
                        :style="{ backgroundColor: type.color, color: type.color_letra }"
                    >
                        {{ type.codigo }}
                    </span>
                    <span class="text-gray-700 truncate">{{ type.descripcion }}</span>
                </button>

                <!-- No results -->
                <div v-if="filteredTypes.length === 0" class="text-xs text-gray-400 text-center py-2">
                    Sin resultados para "{{ search }}"
                </div>
            </div>
        </template>
    </div>
</template>
