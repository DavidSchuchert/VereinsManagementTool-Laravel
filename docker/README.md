# Docker Setup

## Quick Start

```bash
# 1. Env-Datei erstellen
cp .env.docker .env

# 2. APP_KEY generieren
php artisan key:generate

# 3. Container starten
cd docker && docker compose up -d

# 4. Logs verfolgen
docker compose logs -f app
```

Danach erreichbar unter: **http://localhost:8181**
Mailpit (DEV mail catcher): **http://localhost:8025**

## Services

| Service   | Port | Beschreibung |
|-----------|------|-------------|
| app       | 8181 | Apache + PHP 8.5 + Laravel |
| mariadb   | 3307 | MariaDB 11 (externer Zugriff) |
| mailpit   | 8025 | Mail Catcher UI, Port 1025 für SMTP |

## Wichtige Commands

```bash
# Container starten
docker compose up -d

# Container stoppen
docker compose down

# Logs
docker compose logs -f

# Bash in Container
docker compose exec app bash

# Artisan im Container
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan config:cache
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

## Initiales Setup

Beim ersten Start führt der Entrypoint automatisch aus:
1. Warten auf MariaDB
2. APP_KEY generieren (falls leer)
3. Config cache
4. Migrationen
5. Seeder
6. Storage Link
