<template>
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-12">
               
                <div class="flex justify-start mb-6">
                    <Link
                        href="/"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-amber-500 hover:text-amber-700 transition-all shadow-sm hover:shadow-md"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        На главную
                    </Link>
                </div>
                
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Бронирование услуг</h1>
                    <p class="text-lg text-gray-600">Выберите услугу, дату и время для бронирования</p>
                </div>
            </div>


            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Шаг 1: Выбор услуги -->
                <div v-if="step === 1" class="p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Шаг 1: Выберите услугу</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <ServiceCard
                            v-for="service in services"
                            :key="service.id"
                            :service="service"
                            @select="selectService"
                        />
                    </div>
                </div>

                <!-- Шаг 2: Выбор даты -->
                <div v-if="step === 2" class="p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Шаг 2: Выберите дату
                            <span class="text-amber-700 block text-lg mt-1">{{ selectedService?.name }} ({{ selectedService?.duration_display }})</span>
                        </h2>
                        <button
                            @click="goBack"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50"
                        >
                            ← Назад
                        </button>
                    </div>
                    <WeekCalendar
                        :selected-date="selectedDate"
                        @select-date="selectDate"
                    />
                </div>

                <!-- Шаг 3: Выбор времени -->
                <div v-if="step === 3" class="p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Шаг 3: Выберите время
                            <span class="text-amber-700 block text-lg mt-1">{{ formatDate(selectedDate) }}</span>
                        </h2>
                        <button
                            @click="goBack"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50"
                        >
                            ← Назад
                        </button>
                    </div>
                    <TimeSlotPicker
                        :slots="availableSlots"
                        :loading="loadingSlots"
                        :selected-slot="selectedSlot"
                        @select-slot="selectSlot"
                    />
                </div>

                <!-- Шаг 4: Заполнение формы -->
                <div v-if="step === 4" class="p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-gray-800">Шаг 4: Укажите контактные данные</h2>
                        <button
                            @click="goBack"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50"
                        >
                            ← Назад
                        </button>
                    </div>
                    <BookingForm
                        :booking-data="bookingData"
                        :submitting="submitting"
                        @submit="submitBooking"
                    />
                </div>
            </div>
        </div>

        <SuccessModal
            :show="showSuccessModal"
            :booking="createdBooking"
            @close="resetBooking"
        />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import ServiceCard from '@/Components/Booking/ServiceCard.vue';
import WeekCalendar from '@/Components/Booking/WeekCalendar.vue';
import TimeSlotPicker from '@/Components/Booking/TimeSlotPicker.vue';
import BookingForm from '@/Components/Booking/BookingForm.vue';
import SuccessModal from '@/Components/Booking/SuccessModal.vue';

const step = ref(1);
const services = ref([]);
const selectedService = ref(null);
const selectedDate = ref(null);
const availableSlots = ref([]);
const selectedSlot = ref(null);
const loadingSlots = ref(false);
const submitting = ref(false);
const showSuccessModal = ref(false);
const createdBooking = ref(null);

const bookingData = computed(() => ({
    service: selectedService.value,
    date: selectedDate.value,
    time: selectedSlot.value,
}));

onMounted(async () => {
    await loadServices();
});

const loadServices = async () => {
    try {
        const response = await axios.get('/services');
        services.value = response.data.data;
    } catch (error) {
        console.error('Ошибка загрузки услуг:', error);
    }
};

const selectService = (service) => {
    selectedService.value = service;
    step.value = 2;
};

const selectDate = async (date) => {
    selectedDate.value = date;
    step.value = 3;
    await loadAvailableSlots();
};

const loadAvailableSlots = async () => {
    loadingSlots.value = true;
    try {
        const response = await axios.get('/bookings/available-slots', {
            params: {
                service_id: selectedService.value.id,
                date: selectedDate.value,
            },
        });
        availableSlots.value = response.data.data;
    } catch (error) {
        console.error('Ошибка загрузки слотов:', error);
    } finally {
        loadingSlots.value = false;
    }
};

const selectSlot = (slot) => {
    selectedSlot.value = slot;
    step.value = 4;
};

const submitBooking = async (formData) => {
    submitting.value = true;
    try {
        const response = await axios.post('/bookings', {
            service_id: selectedService.value.id,
            booking_date: selectedDate.value,
            start_time: selectedSlot.value.start_time,
            client_name: formData.client_name,
            client_phone: formData.client_phone,
        });

        if (response.data.success) {
            createdBooking.value = response.data.data;
            showSuccessModal.value = true;
        }
    } catch (error) {
        console.error('Ошибка создания бронирования:', error);
        alert(error.response?.data?.message || 'Произошла ошибка при бронировании');
    } finally {
        submitting.value = false;
    }
};

const goBack = () => {
    if (step.value > 1) {
        step.value -= 1;
    }
};

const resetBooking = () => {
    step.value = 1;
    selectedService.value = null;
    selectedDate.value = null;
    selectedSlot.value = null;
    availableSlots.value = [];
    showSuccessModal.value = false;
    createdBooking.value = null;
};

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

