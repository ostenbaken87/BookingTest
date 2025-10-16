<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Бронирование экстремальных развлечений" />
    
    <div class="min-h-screen bg-gray-50">

        <nav class="fixed w-full bg-white/95 backdrop-blur-md shadow-sm z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <svg class="w-10 h-10 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-2xl font-bold text-gray-900">Booking Service</span>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#services" class="text-gray-700 hover:text-amber-700 transition">Услуги</a>
                        <a href="#how-it-works" class="text-gray-700 hover:text-amber-700 transition">Как это работает</a>
                        <a href="#about" class="text-gray-700 hover:text-amber-700 transition">О нас</a>
                        
                        <Link
                            :href="route('booking')"
                            class="bg-gradient-to-r from-amber-600 to-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:from-amber-700 hover:to-orange-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
                        >
                            Забронировать
                        </Link>

                        <!-- <template v-if="canLogin">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="text-gray-700 hover:text-amber-700 transition"
                            >
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="text-gray-700 hover:text-amber-700 transition"
                                >
                                    Вход
                                </Link>
                            </template>
                        </template> -->
                    </div>

                    <div class="md:hidden">
                        <Link
                            :href="route('booking')"
                            class="bg-gradient-to-r from-amber-600 to-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold"
                        >
                            Забронировать
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-emerald-50 opacity-70"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDMiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-40"></div>
            
            <div class="relative max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-1 gap-12 items-center">
                    <div class="text-center lg:text-center">
                        
                        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight">
                            Сервис
                            <span class="bg-gradient-to-r from-amber-700 to-emerald-600 bg-clip-text text-transparent">
                                бронирования
                            </span>
                        </h1>
                        
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            У нас есть Квадроциклы и Эндуро для Вас. Бронируйте онлайн за 60 секунд.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-center">
                            <Link
                                :href="route('booking')"
                                class="group bg-gradient-to-r from-amber-600 to-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105 flex items-center justify-center"
                            >
                                Забронировать сейчас
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </Link>
                            
                            <a
                                href="#services"
                                class="bg-white text-gray-900 px-8 py-4 rounded-xl font-bold text-lg border-2 border-gray-200 hover:border-amber-600 hover:shadow-lg transition-all flex items-center justify-center"
                            >
                                Посмотреть услуги
                            </a>
                        </div>

                        <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                            <div>
                                <div class="text-3xl font-bold text-amber-700">500+</div>
                                <div class="text-sm text-gray-600 mt-1">Довольных клиентов</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-amber-700">4</div>
                                <div class="text-sm text-gray-600 mt-1">Вида услуг</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-amber-700">24/7</div>
                                <div class="text-sm text-gray-600 mt-1">Онлайн бронь</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="services" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Наши услуги
                    </h2>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="group relative bg-gradient-to-br from-amber-50 to-orange-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-amber-700 font-semibold">от 30 минут</div>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">🏁 Поездка на квадроцикле</h3>
                        <p class="text-gray-600 mb-6">
                            Покорите бездорожье на мощном квадроцикле. Идеально для новичков и опытных райдеров.
                        </p>
                        
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>30 или 60 минут на выбор</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Инструктаж включен</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Снаряжение предоставляется</span>
                            </div>
                        </div>

                        <Link
                            :href="route('booking')"
                            class="inline-flex items-center text-amber-700 font-semibold group-hover:text-amber-800"
                        >
                            Забронировать
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                    </div>

                    <div class="group relative bg-gradient-to-br from-emerald-50 to-teal-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-emerald-700 font-semibold">от 60 минут</div>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">🏍️ Тур на эндуро</h3>
                        <p class="text-gray-600 mb-6">
                            Настоящее эндуро-приключение по пересеченной местности. Для тех, кто любит экстрим!
                        </p>
                        
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>60 или 120 минут на выбор</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Профессиональный гид</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Сложные трассы</span>
                            </div>
                        </div>

                        <Link
                            :href="route('booking')"
                            class="inline-flex items-center text-emerald-700 font-semibold group-hover:text-emerald-800"
                        >
                            Забронировать
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Как это работает
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Забронировать приключение проще простого - всего 4 шага
                    </p>
                </div>

                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                <span class="text-3xl font-bold text-white">1</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Выберите услугу</h3>
                        <p class="text-gray-600">Квадроцикл или эндуро - решать вам</p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Выберите дату и время</h3>
                        <p class="text-gray-600">Удобный календарь с доступными слотами</p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Укажите контакты</h3>
                        <p class="text-gray-600">Имя и телефон - это все что нужно</p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-3xl font-bold text-white">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Готово!</h3>
                        <p class="text-gray-600">Получите подтверждение и приезжайте</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <Link
                        :href="route('booking')"
                        class="inline-flex items-center bg-gradient-to-r from-amber-600 to-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105"
                    >
                        Начать бронирование
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Работаем 10:00-20:00</h3>
                        <p class="text-gray-600">Московское время, ежедневно кроме воскресенья</p>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Безопасность</h3>
                        <p class="text-gray-600">Все снаряжение и инструктаж включены в стоимость</p>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Моментальное бронирование</h3>
                        <p class="text-gray-600">Онлайн-бронирование за 60 секунд</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-amber-700 to-orange-600">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    Если Вы готовы?
                </h2>
                <p class="text-xl text-amber-50 mb-8">
                    Не откладывайте на потом - забронируйте прямо сейчас!
                </p>
                <Link
                    :href="route('booking')"
                    class="inline-flex items-center bg-white text-amber-700 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105"
                >
                    Забронировать приключение
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </Link>
            </div>
        </section>

        <footer class="bg-gray-900 text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-xl font-bold text-white">Booking Service</span>
                        </div>
                        <p class="text-gray-400">
                            Бронирование экстремальных развлечений онлайн. Быстро, удобно, безопасно.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="text-white font-bold mb-4">Контакты</h4>
                        <div class="space-y-2 text-gray-400">
                            <p>📞 +7 (900) 000-00-00</p>
                            <p>📧 info@booking-service.ru</p>
                            <p>🕒 Пн-Сб: 10:00-20:00 МСК</p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-white font-bold mb-4">Навигация</h4>
                        <div class="space-y-2">
                            <a href="#services" class="block text-gray-400 hover:text-amber-400 transition">Услуги</a>
                            <a href="#how-it-works" class="block text-gray-400 hover:text-amber-400 transition">Как это работает</a>
                            <Link :href="route('booking')" class="block text-gray-400 hover:text-amber-400 transition">Забронировать</Link>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                    <p>&copy; 2025 Booking Service. Все права защищены.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}
</style>
