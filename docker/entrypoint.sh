#!/bin/bash
set -e

echo "⏳ Waiting for database..."
maxTries=30
counter=0
until php -r "
try {
    new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
        getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo 'OK';
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
" 2>/dev/null || [ $counter -eq $maxTries ]; do
    sleep 2
    counter=$((counter + 1))
    echo "  Attempt $counter/$maxTries..."
done

if [ $counter -eq $maxTries ]; then
    echo "⚠️  DB not ready after $maxTries attempts, continuing anyway..."
fi

# Check if APP_KEY is set, generate if empty
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "🔑 Generating APP_KEY..."
    export APP_KEY=$(php artisan key:generate --show)
fi

# Fix git safe.directory
git config --global --add safe.directory /var/www/html

# Composer dependencies (ignore platform reqs for dev)
echo "📦 Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

# NPM dependencies & Build
echo "🎨 Building frontend assets..."
npm install
npm run build

# Livewire assets
echo "⚡ Publishing Livewire assets..."
php artisan livewire:publish --assets || true

# Config cache
echo "🔑 Caching config..."
php artisan config:cache || true

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force || true

# Seed database
echo "🌱 Seeding database..."
php artisan db:seed --force || true

# Storage link
echo "🔗 Creating storage link..."
php artisan storage:link || true

echo "✅ Ready! http://localhost:8181"
exec "$@"
