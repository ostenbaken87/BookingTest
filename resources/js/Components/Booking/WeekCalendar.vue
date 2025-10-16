<template>
    <div class="space-y-4">

        <div class="flex items-center justify-between mb-6">
            <button
                @click="previousWeek"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h3 class="text-lg font-semibold text-gray-800">
                {{ weekRangeText }}
            </h3>
            <button
                @click="nextWeek"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-4">
            <div
                v-for="day in weekDays"
                :key="day.date"
                @click="selectDay(day)"
                :class="[
                    'p-4 rounded-xl border-2 text-center transition-all cursor-pointer',
                    day.isSunday
                        ? 'bg-gray-100 border-gray-200 cursor-not-allowed opacity-50'
                        : day.isPast
                        ? 'bg-gray-50 border-gray-200 cursor-not-allowed opacity-50'
                        : selectedDate === day.date
                        ? 'bg-amber-600 border-amber-600 text-white shadow-lg transform scale-105'
                        : 'bg-white border-gray-200 hover:border-amber-600 hover:shadow-md',
                ]"
            >
                <div class="text-sm font-medium mb-1" :class="selectedDate === day.date ? 'text-white' : 'text-gray-500'">
                    {{ day.weekday }}
                </div>
                <div class="text-2xl font-bold" :class="selectedDate === day.date ? 'text-white' : 'text-gray-900'">
                    {{ day.day }}
                </div>
                <div class="text-xs mt-1" :class="selectedDate === day.date ? 'text-amber-100' : 'text-gray-400'">
                    {{ day.month }}
                </div>
                <div v-if="day.isSunday" class="text-xs mt-2 text-red-500 font-medium">
                    Закрыто
                </div>
                <div v-else-if="day.isPast" class="text-xs mt-2 text-gray-400 font-medium">
                    Прошло
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    selectedDate: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['select-date']);

// Текущая неделя
const currentWeekStart = ref(null);

// Инициализация
onMounted(() => {
    const today = new Date();
    currentWeekStart.value = getMonday(today);
});

// Получить понедельник недели
const getMonday = (date) => {
    const d = new Date(date);
    const day = d.getDay();
    const diff = d.getDate() - day + (day === 0 ? -6 : 1);
    return new Date(d.setDate(diff));
};

// Дни текущей недели
const weekDays = computed(() => {
    if (!currentWeekStart.value) return [];
    
    const days = [];
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    for (let i = 0; i < 7; i++) {
        const date = new Date(currentWeekStart.value);
        date.setDate(date.getDate() + i);
        
        const dateString = formatDateToISO(date);
        const isSunday = date.getDay() === 0;
        const isPast = date < today;
        
        days.push({
            date: dateString,
            day: date.getDate(),
            weekday: date.toLocaleDateString('ru-RU', { weekday: 'short' }),
            month: date.toLocaleDateString('ru-RU', { month: 'short' }),
            isSunday,
            isPast,
        });
    }
    
    return days;
});

// Текст диапазона недели
const weekRangeText = computed(() => {
    if (!currentWeekStart.value) return '';
    
    const start = new Date(currentWeekStart.value);
    const end = new Date(currentWeekStart.value);
    end.setDate(end.getDate() + 6);
    
    return `${start.toLocaleDateString('ru-RU', { day: 'numeric', month: 'short' })} - ${end.toLocaleDateString('ru-RU', { day: 'numeric', month: 'short', year: 'numeric' })}`;
});

// Предыдущая неделя
const previousWeek = () => {
    const newDate = new Date(currentWeekStart.value);
    newDate.setDate(newDate.getDate() - 7);
    currentWeekStart.value = newDate;
};

// Следующая неделя
const nextWeek = () => {
    const newDate = new Date(currentWeekStart.value);
    newDate.setDate(newDate.getDate() + 7);
    currentWeekStart.value = newDate;
};

// Выбор дня
const selectDay = (day) => {
    if (day.isSunday || day.isPast) return;
    emit('select-date', day.date);
};

// Форматирование даты в ISO
const formatDateToISO = (date) => {
    return date.toISOString().split('T')[0];
};
</script>

