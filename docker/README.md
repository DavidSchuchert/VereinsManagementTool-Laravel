# Docker Setup

## Quick Start

```bash
# 1. Env-Datei erstellen
cp .env.docker .env

# 2. APP_KEY generieren (lokal, NICHT im Container)
php artisan key:generate

# 3. Container starten
cd docker && docker compose up -d --build

# 4. Logs verfolgen
cd docker && docker compose logs -f
```

Danach erreichbar unter: **http://localhost:8181**

## Services

| Service | Port | Beschreibung |
|---------|------|-------------|
| app     | 8181 | Apache 2.4 + PHP 8.5 + Laravel |
| mariadb | 3307 | MariaDB 11 (externer Zugriff) |

## Initiales Setup (automatisch)

Der Entrypoint führt beim ersten Start automatisch aus:

1. Wartet auf MariaDB
2. APP_KEY generieren (falls leer)
3. `composer install --no-dev --optimize-autoloader`
4. `npm install && npm run build`
5. `php artisan livewire:publish --assets`
6. `php artisan config:cache`
7. `php artisan migrate --force`
8. `php artisan db:seed --force`
9. `php artisan storage:link`

## Wichtige Commands

```bash
# Container starten
cd docker && docker compose up -d

# Neu bauen (nach Codeänderungen)
cd docker && docker compose up -d --build

# Container stoppen
cd docker && docker compose down

# Logs
cd docker && docker compose logs -f

# Bash im Container
cd docker && docker compose exec app bash

# Artisan Commands
cd docker && docker compose exec app php artisan migrate
cd docker && docker compose exec app php artisan db:seed
cd docker && docker compose exec app php artisan config:cache
cd docker && docker compose exec app php artisan livewire:publish --assets

# Frontend neu bauen
cd docker && docker compose exec app npm run build
```

## Datenbank von außen

Mit TablePlus, DBeaver oder MySQL Workbench:
- Host: `localhost`
- Port: `3307`
- User: `vereinsuser`
- Password: `vereinspass`
- Database: `vereinsmanagement`

## Env-Variablen anpassen

In der `.env` Datei anpassen:

```env
APP_NAME="Dein Vereinsname"
APP_URL=http://localhost:8181
DB_DATABASE=vereinsmanagement
DB_USERNAME=vereinsuser
DB_PASSWORD=dein_s...wort
DB_ROOT_PASSWORD=root_s...wort
```
