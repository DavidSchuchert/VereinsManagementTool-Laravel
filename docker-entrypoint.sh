#!/bin/bash
set -e

echo "⏳ Waiting for database connection..."
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
    echo "⚠️  DB not ready after $maxTries attempts, trying to continue anyway..."
fi

echo "🔑 Caching config..."
php artisan config:cache || true

echo "📦 Running migrations..."
php artisan migrate --force || true

echo "🌱 Seeding database (if needed)..."
php artisan db:seed --force || true

echo "🔗 Creating storage link..."
php artisan storage:link || true

echo "✅ Application ready! Listening on port 8000"
exec "$@"
