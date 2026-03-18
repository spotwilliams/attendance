<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const sidebarOpen = ref(false);

const navigation = [
    {
        label: 'Personal',
        icon: 'users',
        items: [
            { label: 'Agentes', href: '#' },
        ],
    },
    {
        label: 'Presentismo',
        icon: 'calendar-check',
        items: [
            { label: 'Registro manual', href: '/app/attendance' },
            { label: 'Registro masivo', href: '#' },
            { label: 'Registro por agente', href: '#' },
        ],
    },
    {
        label: 'Reportes',
        icon: 'bar-chart',
        items: [
            { label: 'Presentismos', href: '#' },
        ],
    },
    {
        label: 'Configuración',
        icon: 'settings',
        items: [
            { label: 'Períodos', href: '#' },
        ],
    },
];

const expandedMenu = ref<string | null>('Presentismo');

function toggleMenu(label: string) {
    expandedMenu.value = expandedMenu.value === label ? null : label;
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Top navbar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                <div class="flex items-center gap-4">
                    <button
                        class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100"
                        @click="sidebarOpen = !sidebarOpen"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-xl font-bold text-orange-600">CAT</span>
                    <span class="text-sm text-gray-400 hidden sm:inline">Sistema de Presentismo</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-100 text-orange-700 rounded-full flex items-center justify-center text-sm font-medium">
                        U
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            <!-- Sidebar overlay (mobile) -->
            <div
                v-if="sidebarOpen"
                class="fixed inset-0 bg-black/30 z-20 lg:hidden"
                @click="sidebarOpen = false"
            />

            <!-- Sidebar -->
            <aside
                class="fixed lg:sticky top-16 left-0 z-20 w-64 h-[calc(100vh-4rem)] bg-white border-r border-gray-200 overflow-y-auto transition-transform lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            >
                <nav class="p-4 space-y-1">
                    <div v-for="section in navigation" :key="section.label">
                        <button
                            class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors"
                            @click="toggleMenu(section.label)"
                        >
                            <span>{{ section.label }}</span>
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-90': expandedMenu === section.label }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-show="expandedMenu === section.label" class="ml-4 mt-1 space-y-0.5">
                            <Link
                                v-for="item in section.items"
                                :key="item.label"
                                :href="item.href"
                                class="block px-3 py-1.5 text-sm text-gray-600 rounded-md hover:bg-orange-50 hover:text-orange-700 transition-colors"
                            >
                                {{ item.label }}
                            </Link>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Main content -->
            <main class="flex-1 min-w-0 p-4 lg:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
