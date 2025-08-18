#!/bin/bash
set -e

cd /var/www

echo "🚀 Starting Laravel container setup..."

# ✅ Fix storage & cache permissions
echo "🔒 Fixing permissions for storage and bootstrap/cache..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Check Laravel project exists
if [ ! -f "artisan" ]; then
    echo "❌ Laravel project not found in /var/www"
    exit 1
fi

# Install PHP dependencies
if [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing PHP dependencies..."
    composer install --no-progress --no-interaction --prefer-dist --optimize-autoloader
else
    echo "✅ Dependencies already installed."
fi

# Setup .env file if missing
if [ ! -f ".env" ]; then
    echo "⚙️ Creating default .env file..."
    cp .env.example .env
else
    echo "✅ .env file already exists."
fi

# Generate app key if missing
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating Laravel app key..."
    php artisan key:generate
fi

# Run Laravel optimizations
echo "🔧 Running Laravel optimizations..."
php artisan migrate --force || echo "⚠️ Migration failed, skipping..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache

echo "✅ Laravel is ready."

# Start PHP-FPM
echo "▶️ Starting PHP-FPM..."
exec php-fpm -F

