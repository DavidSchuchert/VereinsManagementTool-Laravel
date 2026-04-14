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

# Fix git safe.directory
git config --global --add safe.directory /var/www/html

# Composer dependencies (only if vendor is missing)
if [ ! -d "vendor" ]; then
    echo "📦 Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
else
    echo "✅ Vendor directory exists, skipping composer install."
fi

# NPM dependencies & Build (only if node_modules is missing)
if [ ! -d "node_modules" ]; then
    echo "🎨 Installing NPM dependencies..."
    npm install
    echo "🏗️ Building frontend assets..."
    npm run build
else
    echo "✅ node_modules directory exists, skipping npm install."
    if [ ! -d "public/build" ]; then
        echo "🏗️ Building frontend assets (build missing)..."
        npm run build
    fi
fi

# Check if APP_KEY is set, generate if empty (NOW it works because vendor is there)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "🔑 Generating APP_KEY..."
    export APP_KEY=$(php artisan key:generate --show)
fi

# Livewire assets
echo "⚡ Publishing Livewire assets..."
php artisan livewire:publish --assets || true

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force || true

# Seed database
echo "🌱 Seeding database..."
php artisan db:seed --force || true

# Storage link
if [ ! -L "public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link || true
fi

echo "✅ Ready! http://localhost:8082"
exec "$@"
