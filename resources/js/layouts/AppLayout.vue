<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarOpen = ref(false);
const sidebarCollapsed = ref(false);

const navigation = [
    {
        label: 'Personal',
        icon: 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
        items: [
            { label: 'Agentes', href: '#' },
        ],
    },
    {
        label: 'Presentismo',
        icon: 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z',
        items: [
            { label: 'Registro manual', href: '/app/attendance' },
            { label: 'Registro masivo', href: '#' },
            { label: 'Registro por agente', href: '#' },
        ],
    },
    {
        label: 'Reportes',
        icon: 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z',
        items: [
            { label: 'Presentismos', href: '#' },
        ],
    },
    {
        label: 'Configuración',
        icon: 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
        items: [
            { label: 'Períodos', href: '#' },
        ],
    },
];

const currentUrl = computed(() => usePage().url);

function isActive(href: string): boolean {
    if (href === '#') return false;
    return currentUrl.value.startsWith(href);
}

function sectionIsActive(section: typeof navigation[number]): boolean {
    return section.items.some(item => isActive(item.href));
}

const expandedMenu = ref<string | null>('Presentismo');

function toggleMenu(label: string) {
    if (sidebarCollapsed.value) {
        sidebarCollapsed.value = false;
        expandedMenu.value = label;
        return;
    }
    expandedMenu.value = expandedMenu.value === label ? null : label;
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Top navbar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                <div class="flex items-center gap-4">
                    <!-- Mobile hamburger -->
                    <button
                        class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100"
                        aria-label="Abrir menú de navegación"
                        :aria-expanded="sidebarOpen"
                        aria-controls="sidebar-nav"
                        @click="sidebarOpen = !sidebarOpen"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Desktop collapse toggle -->
                    <button
                        class="hidden lg:flex p-2 rounded-md text-gray-500 hover:bg-gray-100"
                        aria-label="Colapsar navegación"
                        :aria-expanded="!sidebarCollapsed"
                        aria-controls="sidebar-nav"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                    >
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': sidebarCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5" />
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
                id="sidebar-nav"
                class="fixed lg:sticky top-16 left-0 z-20 h-[calc(100vh-4rem)] bg-white border-r border-gray-200 overflow-y-auto transition-all duration-300 lg:translate-x-0"
                :class="[
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                    sidebarCollapsed ? 'w-16' : 'w-64',
                ]"
            >
                <nav class="p-2 space-y-1" :class="sidebarCollapsed ? 'px-1.5' : 'px-4'">
                    <div v-for="section in navigation" :key="section.label">
                        <button
                            class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                            :class="[
                                sidebarCollapsed ? 'justify-center px-0' : 'justify-between',
                                sectionIsActive(section)
                                    ? 'text-orange-700 bg-orange-50'
                                    : 'text-gray-700 hover:bg-gray-100',
                            ]"
                            @click="toggleMenu(section.label)"
                            :title="sidebarCollapsed ? section.label : undefined"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="section.icon" />
                            </svg>
                            <span v-if="!sidebarCollapsed" class="flex-1 text-left">{{ section.label }}</span>
                            <svg
                                v-if="!sidebarCollapsed"
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-90': expandedMenu === section.label }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="!sidebarCollapsed" v-show="expandedMenu === section.label" class="ml-4 mt-1 space-y-0.5">
                            <Link
                                v-for="item in section.items.filter(i => i.href !== '#')"
                                :key="item.label"
                                :href="item.href"
                                class="block px-3 py-1.5 text-sm rounded-md transition-colors"
                                :class="isActive(item.href)
                                    ? 'bg-orange-100 text-orange-700 font-medium'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700'"
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
