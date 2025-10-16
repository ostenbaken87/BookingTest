<template>
    <div
        @click="$emit('select', service)"
        class="relative p-6 border-2 border-gray-200 rounded-xl hover:border-amber-600 hover:shadow-lg transition-all cursor-pointer group bg-white"
    >
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-amber-700 transition-colors">
                    {{ service.name }}
                </h3>
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-600 font-medium">{{ service.duration_display }}</span>
                </div>
            </div>
            <div class="flex-shrink-0 ml-4">
                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center group-hover:bg-amber-600 transition-colors">
                    <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>

        <p class="text-sm text-gray-500 mt-2">
            Общее время: {{ service.duration_minutes + 30 }} минут (включая подготовку)
        </p>

        <div class="absolute top-0 left-0 right-0 h-1 bg-amber-600 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </div>
</template>

<script setup>
defineProps({
    service: {
        type: Object,
        required: true,
    },
});

defineEmits(['select']);
</script>

