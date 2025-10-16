<template>
    <div class="max-w-2xl mx-auto">
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-amber-900 mb-3">Детали бронирования:</h3>
            <div class="space-y-2 text-sm text-amber-800">
                <div class="flex justify-between">
                    <span class="font-medium">Услуга:</span>
                    <span>{{ bookingData.service?.name }} ({{ bookingData.service?.duration_display }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Дата:</span>
                    <span>{{ formatDate(bookingData.date) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Время:</span>
                    <span>{{ bookingData.time?.display }} - {{ bookingData.time?.end_time }}</span>
                </div>
            </div>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Ваше имя <span class="text-red-500">*</span>
                </label>
                <input
                    id="client_name"
                    v-model="form.client_name"
                    type="text"
                    required
                    maxlength="255"
                    placeholder="Введите ваше имя"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                    :class="{ 'border-red-500': errors.client_name }"
                />
                <p v-if="errors.client_name" class="mt-1 text-sm text-red-600">
                    {{ errors.client_name }}
                </p>
            </div>

            <div>
                <label for="client_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Номер телефона <span class="text-red-500">*</span>
                </label>
                <input
                    id="client_phone"
                    v-model="form.client_phone"
                    type="tel"
                    required
                    placeholder="+7 (999) 123-45-67"
                    @input="formatPhone"
                    maxlength="18"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                    :class="{ 'border-red-500': errors.client_phone }"
                />
                <p v-if="errors.client_phone" class="mt-1 text-sm text-red-600">
                    {{ errors.client_phone }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                    Формат: +7 (XXX) XXX-XX-XX
                </p>
            </div>

            <div class="flex items-start space-x-3">
                <input
                    id="agreement"
                    v-model="form.agreement"
                    type="checkbox"
                    required
                    class="mt-1 w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                />
                <label for="agreement" class="text-sm text-gray-600">
                    Я согласен на обработку персональных данных и принимаю условия бронирования <span class="text-red-500">*</span>
                </label>
            </div>

            <div class="flex space-x-4 pt-4">
                <button
                    type="submit"
                    :disabled="submitting || !isFormValid"
                    class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="!submitting">Забронировать</span>
                    <span v-else class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Обработка...
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    bookingData: {
        type: Object,
        required: true,
    },
    submitting: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['submit']);

// Форма
const form = ref({
    client_name: '',
    client_phone: '',
    agreement: false,
});

// Ошибки
const errors = ref({
    client_name: '',
    client_phone: '',
});

// Валидация формы
const isFormValid = computed(() => {
    return form.value.client_name.trim() !== '' &&
           form.value.client_phone.match(/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/) &&
           form.value.agreement;
});

// Форматирование телефона
const formatPhone = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    
    if (value.length > 11) {
        value = value.slice(0, 11);
    }
    
    let formatted = '+7';
    if (value.length > 1) {
        formatted += ' (' + value.slice(1, 4);
    }
    if (value.length >= 5) {
        formatted += ') ' + value.slice(4, 7);
    }
    if (value.length >= 8) {
        formatted += '-' + value.slice(7, 9);
    }
    if (value.length >= 10) {
        formatted += '-' + value.slice(9, 11);
    }
    
    form.value.client_phone = formatted;
};

// Отправка формы
const handleSubmit = () => {
    errors.value = { client_name: '', client_phone: '' };
    
    if (form.value.client_name.trim() === '') {
        errors.value.client_name = 'Пожалуйста, укажите ваше имя';
        return;
    }
    
    if (!form.value.client_phone.match(/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/)) {
        errors.value.client_phone = 'Неверный формат номера телефона';
        return;
    }
    
    emit('submit', {
        client_name: form.value.client_name,
        client_phone: form.value.client_phone,
    });
};

// Форматирование даты
const formatDate = (date) => {
    if (!date) return '';
    const d = new Date(date);
    return d.toLocaleDateString('ru-RU', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

