import { reactive, watch } from 'vue';
import type { Filters } from '@/types/attendance';

const STORAGE_KEY = 'attendance-filters';

function getDefaultDateRange(): { date_from: string; date_to: string } {
    const now = new Date();
    const from = new Date(now);
    from.setDate(now.getDate() - 5);
    const to = new Date(now);
    to.setDate(now.getDate() + 2);

    return {
        date_from: from.toISOString().split('T')[0],
        date_to: to.toISOString().split('T')[0],
    };
}

function loadFromStorage(): Partial<Filters> {
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            return JSON.parse(stored);
        }
    } catch {
        // ignore
    }
    return {};
}

function saveToStorage(filters: Filters): void {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(filters));
    } catch {
        // ignore
    }
}

export function useFilters() {
    const defaults = getDefaultDateRange();
    const stored = loadFromStorage();

    const filters = reactive<Filters>({
        base_id: stored.base_id ?? null,
        shifts: stored.shifts ?? [],
        areas: stored.areas ?? [],
        roles: stored.roles ?? [],
        date_from: stored.date_from ?? defaults.date_from,
        date_to: stored.date_to ?? defaults.date_to,
    });

    watch(filters, (val) => saveToStorage(val), { deep: true });

    function reset(): void {
        const d = getDefaultDateRange();
        filters.base_id = null;
        filters.shifts = [];
        filters.areas = [];
        filters.roles = [];
        filters.date_from = d.date_from;
        filters.date_to = d.date_to;
    }

    return { filters, reset };
}
