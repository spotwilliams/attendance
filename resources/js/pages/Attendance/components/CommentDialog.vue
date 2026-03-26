<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import type { AttendanceRecord, AttendanceComment } from '@/types/attendance';

const props = defineProps<{
    record: AttendanceRecord;
    agentName?: string;
}>();

const emit = defineEmits<{
    close: [];
}>();

const visible = ref(true);
const comments = ref<AttendanceComment[]>([]);
const newComment = ref('');
const loading = ref(true);
const saving = ref(false);
const error = ref<string | null>(null);

onMounted(async () => {
    try {
        const { data } = await axios.get(`/app/attendance/${props.record.id}/comments`);
        comments.value = data.comments;
    } catch {
        error.value = 'Error al cargar comentarios';
    } finally {
        loading.value = false;
    }
});

async function saveComment() {
    if (!newComment.value.trim()) return;

    saving.value = true;
    error.value = null;

    try {
        const { data } = await axios.post(`/app/attendance/${props.record.id}/comments`, {
            comentario: newComment.value.trim(),
        });
        comments.value.push(data.comment);
        newComment.value = '';
    } catch (e: any) {
        error.value = e.response?.data?.message || 'Error al guardar comentario';
    } finally {
        saving.value = false;
    }
}

function onHide() {
    emit('close');
}

function formatDateTime(dateStr: string): string {
    const d = new Date(dateStr);
    return d.toLocaleDateString('es-AR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}
</script>

<template>
    <Dialog
        v-model:visible="visible"
        modal
        :header="agentName ?? 'Comentarios'"
        :style="{ width: '60rem' }"
        @hide="onHide"
    >
        <div class="space-y-4">
            <!-- Record info -->
            <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-1.5 text-sm border-b border-gray-200 pb-4">
                <span class="font-medium text-gray-700">Fecha</span>
                <span class="text-orange-600">{{ record.fecha }}</span>

                <span class="font-medium text-gray-700">Licencia</span>
                <span v-if="record.tipo_presentismo">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold"
                        :style="{ backgroundColor: record.tipo_presentismo.color, color: record.tipo_presentismo.color_letra }"
                    >
                        {{ record.tipo_presentismo.descripcion }} ({{ record.tipo_presentismo.codigo }})
                    </span>
                </span>
                <span v-else class="text-gray-400">Sin tipo</span>
            </div>

            <!-- Error -->
            <div v-if="error" class="text-xs text-red-600 bg-red-50 rounded px-3 py-2">
                {{ error }}
            </div>
                <!-- Comments list (GitHub-style) -->
                <div class="space-y-0">
                    <!-- Loading skeleton -->
                    <div v-if="loading" class="space-y-4 py-2">
                        <div v-for="i in 2" :key="i" class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 animate-pulse shrink-0" />
                            <div class="flex-1 space-y-2">
                                <div class="h-4 bg-gray-100 rounded animate-pulse w-1/3" />
                                <div class="h-12 bg-gray-100 rounded animate-pulse" />
                            </div>
                        </div>
                    </div>

                    <!-- Comments -->
                    <template v-else>
                        <div v-if="comments.length === 0" class="text-sm text-gray-400 text-center py-6">
                            Sin comentarios
                        </div>

                        <div
                            v-for="(comment, index) in comments"
                            :key="comment.id"
                            class="flex gap-3"
                            :class="index > 0 ? 'pt-4' : ''"
                        >
                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full bg-gray-500 text-white flex items-center justify-center text-xs font-semibold shrink-0 mt-0.5">
                                {{ (comment.usuario || '?').charAt(0).toUpperCase() }}
                            </div>

                            <!-- Comment bubble -->
                            <div class="flex-1 border border-gray-200 rounded-lg overflow-hidden">
                                <!-- Header -->
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border-b border-gray-200 text-xs">
                                    <span class="font-semibold text-gray-800">{{ comment.usuario }}</span>
                                    <span class="text-gray-400">{{ formatDateTime(comment.created_at) }}</span>
                                </div>
                                <!-- Body -->
                                <div class="px-3 py-3 text-sm text-gray-700 whitespace-pre-wrap">{{ comment.comentario }}</div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Reply box (GitHub-style) -->
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-semibold shrink-0 mt-0.5">
                        Tu
                    </div>
                    <div class="flex-1 border border-gray-200 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-orange-400 focus-within:border-orange-400">
                        <textarea
                            v-model="newComment"
                            class="w-full px-3 py-2 text-sm focus:outline-none resize-none"
                            rows="3"
                            maxlength="400"
                            placeholder="Dejá un comentario..."
                        />
                        <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-t border-gray-100">
                            <Button
                                label="Cancelar"
                                severity="secondary"
                                outlined
                                size="small"
                                @click="visible = false"
                            />
                            <Button
                                label="Comentar"
                                size="small"
                                :loading="saving"
                                :disabled="!newComment.trim()"
                                @click="saveComment"
                            />
                        </div>
                    </div>
                </div>
        </div>
    </Dialog>
</template>
