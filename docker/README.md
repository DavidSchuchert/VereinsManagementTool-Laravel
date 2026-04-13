# Docker Setup

## Quick Start

```bash
# 1. Env-Datei erstellen
cp .env.docker .env

# 2. APP_KEY generieren (lokal, NICHT im Container)
php artisan key:generate

# 3. Container starten
docker compose up -d --build

# 4. Logs verfolgen
docker compose logs -f app
```

Danach erreichbar unter: **http://localhost:8181**
Mailpit (DEV mail catcher): **http://localhost:8025**

## Services

| Service   | Port | Beschreibung |
|-----------|------|-------------|
| app       | 8181 | Apache 2.4 + PHP 8.5 + Laravel |
| mariadb   | 3307 | MariaDB 11 (externer Zugriff) |
| mailpit   | 8025 | Mail Catcher UI, Port 1025 für SMTP |

## Initiales Setup (automатически)

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
docker compose up -d

# Neu bauen (nach Codeänderungen)
docker compose up -d --build

# Container stoppen
docker compose down

# Logs
docker compose logs -f
docker compose logs -f app

# Bash im Container
docker compose exec app bash

# Artisan Commands
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan config:cache
docker compose exec app php artisan livewire:publish --assets

# Frontend neu bauen
docker compose exec app npm run build
```

## Datenbank von außen

Mit TablePlus, DBeaver oder MySQL Workbench:
- Host: `localhost`
- Port: `3307`
- User: `vereinsuser`
- Password: `vereinspass`
- Database: `vereinsmanagement`

## Mailpit

Mailpit fängt alle ausgehenden Mails ab. Keine echten Mails werden versendet.
- Web UI: http://localhost:8025
- SMTP: `localhost:1025`

## Env-Variablen anpassen

In der `.env` Datei anpassen:

```env
APP_NAME="Dein Vereinsname"
APP_URL=http://localhost:8181
DB_DATABASE=vereinsmanagement
DB_USERNAME=vereinsuser
DB_PASSWORD=dein_sicheres_passwort
DB_ROOT_PASSWORD=root_sicheres_passwort
```
