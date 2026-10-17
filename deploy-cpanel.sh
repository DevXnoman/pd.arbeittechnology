#!/usr/bin/env bash

# cPanel / Shared Hosting Production Deployment Script for Arbeit Technology Project
set -e

echo "🚀 Starting Production Deployment for Arbeit Technology (koro) Project..."

# 1. Enable Maintenance Mode
echo "🔒 Enabling maintenance mode..."
php artisan down || true

# 2. Update Composer Dependencies
echo "📦 Installing PHP dependencies (Optimized for Production)..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# 3. Build Production Assets with Vite
if command -v npm &> /dev/null; then
    echo "⚡ Building frontend assets via Vite..."
    npm install
    npm run build
else
    echo "⚠️ npm command not found on server. Ensure public/build assets were compiled locally and committed."
fi

# 4. Database Migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 5. Create Storage Link for PDF Quotation Uploads & Public Assets
echo "🔗 Linking public storage..."
php artisan storage:link || true

# 6. Optimize Cache (Configuration, Routes, Views)
echo "⚡ Clearing & Caching framework metadata..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache || true

# 7. Disable Maintenance Mode
echo "🔓 Disabling maintenance mode..."
php artisan up

echo "✅ Production Deployment Successfully Completed!"
