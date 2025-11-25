#!/bin/bash
set -e

echo "=============================================="
echo " 🚀 Starting Laravel + React Auto Deploy Script"
echo "=============================================="

# ----------- CONFIG ------------
BACKEND_DIR="./"                # Laravel root folder
FRONTEND_DIR="../frontend"      # React project folder (update if needed)
PHP_VERSION=$(php -r "echo PHP_VERSION;")
# -------------------------------

echo ""
echo "🧩 Checking PHP version: $PHP_VERSION"
if [[ "$PHP_VERSION" < "8.2" ]]; then
  echo "⚠️  PHP 8.2 or higher recommended!"
fi

# Step 1: Pull latest code
echo ""
echo "📦 Pulling latest code from Git..."
git pull origin main || git pull origin master

# Step 2: Backend setup
echo ""
echo "🧱 Setting up Laravel backend..."

cd "$BACKEND_DIR"

if [ ! -f ".env" ]; then
  echo "⚙️  .env file not found, copying from .env.example"
  cp .env.example .env
fi

# Generate app key if not exists
if ! grep -q "APP_KEY=" .env || [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f2)" ]; then
  echo "🔑 Generating APP_KEY..."
  php artisan key:generate
else
  echo "✅ APP_KEY already exists."
fi

# Install composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear and rebuild caches
echo "🧹 Clearing and caching configs..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "⚙️ Running migrations..."
php artisan migrate --force || echo "⚠️ Migration failed — please check database settings."

# Permissions
echo "🔒 Fixing permissions..."
chmod -R 775 storage bootstrap/cache || true

# Step 3: Frontend setup (React)
echo ""
echo "🎨 Setting up React frontend..."

if [ -d "$FRONTEND_DIR" ]; then
  cd "$FRONTEND_DIR"
  echo "📦 Installing npm dependencies..."
  npm ci || npm install
  echo "🏗️  Building React app..."
  npm run build
  echo "✅ React build completed."
else
  echo "ℹ️ React frontend folder not found ($FRONTEND_DIR) — skipping."
fi

# Step 4: Back to Laravel root
cd "$BACKEND_DIR"

# Step 5: Restart services (optional for VPS)
if command -v systemctl &> /dev/null; then
  echo ""
  echo "🔁 Restarting PHP-FPM and Nginx (if applicable)..."
  sudo systemctl restart php*-fpm.service || true
  sudo systemctl restart nginx || true
fi

echo ""
echo "✅ Deployment completed successfully!"
echo "Your Laravel + React app is now live 🚀"
echo "=============================================="
