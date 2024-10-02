## Installation

Установка стандартная. Написан docker-compose.yml

```bash
  npm install
  composer install
  cp .env.example .env
  docker-compose build
  docker-compose up
```

## Usage/Examples

Наполнение БД тестовыми данными
```
php artisan db:seed
```
