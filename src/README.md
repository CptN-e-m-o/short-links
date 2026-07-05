# Short Links

Short Links — веб-приложение для создания коротких ссылок, отслеживания переходов и управления ссылками через личный кабинет.


## Стек

- PHP 8.3
- Laravel 10+
- Filament v3
- MySQL 8
- Nginx
- Node.js 22
- Docker Compose

## Запуск проекта

### 1. Собрать контейнеры

```bash
docker compose build
```

### 2. Запустить контейнеры

```bash
docker compose up -d
```

### 3. Установить PHP-зависимости

```bash
docker compose exec app composer install
```

### 4. Создать `.env`

```bash
cp src/.env.example src/.env
```

### 5. Сгенерировать ключ приложения

```bash
docker compose exec app php artisan key:generate
```

### 6. Запустить миграции

```bash
docker compose exec app php artisan migrate
```

### 7. Установить frontend-зависимости

```bash
docker compose exec node npm install
```

### 8. Запустить Vite

```bash
docker compose exec node npm run dev -- --host 0.0.0.0
```

## Структура проекта

```text
short-links/
├── docker/
│   ├── mysql/
│   │   └── my.cnf
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       ├── Dockerfile
│       └── php.ini
├── src/
│   ├── app/
│   ├── database/
│   ├── routes/
│   ├── resources/
│   ├── composer.json
│   └── package.json
├── docker-compose.yml
└── README.md
