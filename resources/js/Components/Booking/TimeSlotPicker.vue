<template>
    <div class="space-y-4">

        <div v-if="loading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-amber-600"></div>
        </div>

        <div v-else-if="!slots || slots.length === 0" class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-lg text-gray-600 font-medium">На выбранную дату нет доступных слотов</p>
            <p class="text-sm text-gray-500 mt-2">Попробуйте выбрать другую дату</p>
        </div>

        <div v-else>
            <p class="text-sm text-gray-600 mb-4">
                Доступно слотов: <span class="font-semibold text-amber-700">{{ slots.length }}</span>
            </p>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                <button
                    v-for="slot in slots"
                    :key="slot.start_time"
                    @click="selectSlot(slot)"
                    :class="[
                        'p-4 rounded-lg border-2 transition-all font-medium text-center',
                        selectedSlot?.start_time === slot.start_time
                            ? 'bg-amber-600 border-amber-600 text-white shadow-lg transform scale-105'
                            : 'bg-white border-gray-200 text-gray-700 hover:border-amber-500 hover:shadow-md hover:scale-102',
                    ]"
                >
                    <div class="text-lg font-bold">
                        {{ slot.display }}
                    </div>
                    <div class="text-xs mt-1 opacity-75">
                        до {{ slot.end_time }}
                    </div>
                </button>
            </div>

            <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-amber-900">
                        <p class="font-medium mb-1">Время указано по МСК (Московское время)</p>
                        <p>Время окончания включает 30 минут дополнительного времени для подготовки</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    slots: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
    selectedSlot: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['select-slot']);

const selectSlot = (slot) => {
    emit('select-slot', slot);
};
</script>

