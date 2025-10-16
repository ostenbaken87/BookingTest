Backend
- PHP 8.2+
- Laravel 12 - PHP фреймворк
- PostgreSQL 15 - База данных
- Redis - Кеширование и очереди

Frontend
- Vue.js 3.4 - JavaScript фреймворк
- Inertia.js 2.0 - Связь между Laravel и Vue
- Tailwind CSS 3 - CSS фреймворк
- Vite 6 - Сборщик модулей

DevOps
- Docker & Docker Compose - Контейнеризация
- Nginx - Web-сервер


## 🚀 Установка и запуск

### 1. Клонирование репозитория

```bash
git clone <repository-url>
cd BookingTest
```

### 2. Создание .env файла

```bash
cp .env.example .env
```

Настройте переменные окружения:
```env
APP_NAME="Booking System"
APP_PORT=8001

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=booking
DB_USERNAME=postgres
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379
```

### 3. Запуск через Make

```bash
# Первоначальная инициализация (сборка контейнеров)
make init

# Генерация ключа приложения
make keygen

# Запуск миграций и заполнение тестовыми данными
make fresh-seed
```

### 4. Запуск Vite для frontend

В отдельном терминале:
```bash
npm run dev
```

### 5. Открытие приложения

Перейдите в браузере:
```
http://localhost:8001
```

## 📂 Структура проекта

```
BookingTest/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ServiceController.php      # Контроллер услуг
│   │   │   └── BookingController.php      # Контроллер бронирований
│   │   ├── Requests/
│   │   │   └── BookingRequest.php         # Валидация бронирования
│   │   └── Resources/
│   │       ├── ServiceResource.php        # Сериализация услуг
│   │       └── BookingResource.php        # Сериализация бронирований
│   ├── Models/
│   │   ├── Service.php                    # Модель услуги
│   │   └── Booking.php                    # Модель бронирования
│   └── Services/
│       └── BookingService.php             # Бизнес-логика бронирования
├── database/
│   ├── migrations/
│   │   ├── 2025_10_16_*_create_services_table.php
│   │   └── 2025_10_16_*_create_bookings_table.php
│   └── seeders/
│       ├── ServiceSeeder.php              # Заполнение услуг
│       └── BookingSeeder.php              # Тестовые бронирования
├── resources/
│   └── js/
│       ├── Pages/
│       │   └── Booking.vue                # Главная страница бронирования
│       └── Components/
│           └── Booking/
│               ├── ServiceCard.vue        # Карточка услуги
│               ├── WeekCalendar.vue       # Календарь недели
│               ├── TimeSlotPicker.vue     # Выбор временных слотов
│               ├── BookingForm.vue        # Форма бронирования
│               └── SuccessModal.vue       # Модальное окно успеха
├── docs/
│   └── RACE_CONDITION.md                  # Документация по race condition
├── docker-compose.yml
├── Dockerfile
├── makefile                               # Make команды
└── README.md
```

## ⚡ Функциональность

### Бронирование

1. **Выбор услуги** - отображение доступных услуг с длительностью
2. **Выбор даты** - календарь текущей недели (воскресенье заблокировано)
3. **Выбор времени** - доступные временные слоты (10:00-20:00 МСК)
4. **Форма клиента** - ввод имени и телефона
5. **Подтверждение** - модальное окно с деталями бронирования

### Ограничения

- ⏰ Бронирование доступно только с **10:00 до 20:00** (МСК)
- 📅 Бронирование в **воскресенье заблокировано**
- ⏱️ Продолжительность = длительность услуги + **30 минут** (подготовка)
- 🚫 Нельзя забронировать уже занятое время
- 📞 Телефон в формате: **+7 (XXX) XXX-XX-XX**

### Доступные услуги

1. **Поездка на квадроцикле**
   - 30 минут (итого 60 мин с подготовкой)
   - 60 минут (итого 90 мин с подготовкой)

2. **Тур на эндуро**
   - 60 минут (итого 90 мин с подготовкой)
   - 120 минут (итого 150 мин с подготовкой)

## 🔌 API Endpoints

### Получить список услуг
```http
GET /services
```

**Ответ:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Поездка на квадроцикле",
      "duration_minutes": 30,
      "duration_display": "30 мин"
    }
  ]
}
```

### Получить доступные слоты
```http
GET /bookings/available-slots?service_id=1&date=2025-10-16
```

**Ответ:**
```json
{
  "success": true,
  "data": [
    {
      "start_time": "10:00",
      "end_time": "11:00",
      "display": "10:00"
    }
  ]
}
```

### Создать бронирование
```http
POST /bookings
Content-Type: application/json

{
  "service_id": 1,
  "booking_date": "2025-10-16",
  "start_time": "10:00",
  "client_name": "Иван Иванов",
  "client_phone": "+7 (900) 123-45-67"
}
```

**Успешный ответ (201):**
```json
{
  "success": true,
  "message": "Бронирование успешно создано!",
  "data": {
    "id": 1,
    "service_id": 1,
    "booking_date": "2025-10-16",
    "start_time": "10:00",
    "end_time": "11:00",
    "status": "active"
  }
}
```

**Ошибка (422):**
```json
{
  "success": false,
  "message": "Выбранное время уже забронировано."
}
```

## 🗄️ База данных

### Таблица `services` (Услуги)

| Поле              | Тип      | Описание                    |
|-------------------|----------|-----------------------------|
| id                | bigint   | Первичный ключ              |
| name              | string   | Название услуги             |
| duration_minutes  | integer  | Длительность в минутах      |
| created_at        | timestamp| Дата создания               |
| updated_at        | timestamp| Дата обновления             |

**Индексы:**
- `(name, duration_minutes)` - для быстрого поиска

### Таблица `bookings` (Бронирования)

| Поле          | Тип      | Описание                       |
|---------------|----------|--------------------------------|
| id            | bigint   | Первичный ключ                 |
| service_id    | bigint   | FK → services.id               |
| client_name   | string   | Имя клиента                    |
| client_phone  | string   | Телефон клиента                |
| booking_date  | date     | Дата бронирования              |
| start_time    | time     | Время начала                   |
| end_time      | time     | Время окончания                |
| status        | enum     | active, cancelled              |
| created_at    | timestamp| Дата создания                  |
| updated_at    | timestamp| Дата обновления                |

**Индексы:**
- `(service_id, booking_date, start_time, end_time, status)` - для проверки пересечений
- **UNIQUE** `(service_id, booking_date, start_time, status)` - защита от дублирования

### Связи

```
services (1) ──→ (N) bookings
```

## 🔒 Race Condition

Система защищена от одновременного бронирования одного слота несколькими пользователями.

### Механизмы защиты:

1. **Database Transactions** - атомарность операций
2. **Pessimistic Locking** - блокировка записей на время транзакции
3. **Unique Constraint** - уникальный индекс в БД
4. **Двойная проверка** - до и внутри транзакции

Подробнее: [docs/RACE_CONDITION.md](docs/RACE_CONDITION.md)

## 🧪 Тестирование

### Запуск тестов

```bash
docker-compose exec app php artisan test
```

### Ручное тестирование race condition

1. Откройте два браузера
2. Выберите одинаковые услугу, дату и время в обоих
3. Одновременно нажмите "Забронировать"
4. Результат: только одно бронирование создастся

## 📝 Useful Commands (Make)

```bash
make help           # Показать все доступные команды
make build          # Пересобрать контейнеры
make up             # Запустить контейнеры
make down           # Остановить контейнеры
make restart        # Перезапустить контейнеры
make migrate        # Запустить миграции
make fresh-seed     # Пересоздать БД с тестовыми данными
```

## 🔧 Troubleshooting

### Проблема: "Connection refused" к БД

**Решение:**
```bash
make down
make up
# Подождите 10-15 секунд для инициализации PostgreSQL
make migrate
```

### Проблема: Vite не компилирует файлы

**Решение:**
```bash
npm install
npm run build
```

### Проблема: "Class not found"

**Решение:**
```bash
docker-compose exec app composer dump-autoload
```

## 📄 Лицензия

MIT License

## 👨‍💻 Автор

Разработано как тестовое задание для демонстрации навыков работы с Laravel, Vue.js и Inertia.js.

---

**Дата создания:** Октябрь 2025  
**Версия:** 1.0.0
