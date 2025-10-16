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


Установка и запуск

1. Клонирование репозитория

```bash
git clone git@github.com:ostenbaken87/BookingTest.git
cd BookingTest
```

2. Создание .env файла

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

3. Запуск через Make

```bash
# Первоначальная инициализация (сборка контейнеров)
make init

# Генерация ключа приложения
make keygen

# Запуск миграций и заполнение тестовыми данными
make fresh-seed
```

4. Запуск Vite для frontend

npm run dev

5. Открытие приложения

http://localhost:8001
