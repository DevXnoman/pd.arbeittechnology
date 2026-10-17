# 🚀 cPanel + MySQL Deployment Guide for Arbeit Technology Project

This guide provides step-by-step instructions to deploy the **Arbeit Technology (koro) Laravel Application** to a standard **cPanel Shared Hosting / VPS** environment using **MySQL**.

---

## 📋 Prerequisites
1. **cPanel Access** with File Manager, MySQL Database Wizard, and PHP version select capability (PHP **8.2** or **8.3** required).
2. **Terminal / SSH Access** (optional but recommended; if SSH is unavailable, steps can be done via cPanel UI).

---

## 🛠️ Step-by-Step Deployment Instructions

### Step 1: Create MySQL Database & User in cPanel
1. Open cPanel and go to **MySQL Database Wizard**.
2. Create a new database (e.g., `username_arbeittech`).
3. Create a new database user and strong password (e.g., `username_dbuser`).
4. Assign **ALL PRIVILEGES** to the user for the created database.

---

### Step 2: Upload Application Files to Server
1. Compress your project files into a `.zip` archive (excluding `node_modules`, `.git`, and local `.env`).
2. Open cPanel **File Manager**.
3. Upload the `.zip` file into your home directory (e.g., `/home/username/arbeittechnology`) — **outside the `public_html` directory** for maximum security.
4. Extract the zip file in `/home/username/arbeittechnology`.

---

### Step 3: Configure Public Directory / Symlink in cPanel
**Option A (Recommended for Primary Domain):**
Point your main domain's document root in cPanel to `/home/username/arbeittechnology/public`.

**Option B (If Document Root cannot be changed in Shared Hosting):**
Move the contents of `/home/username/arbeittechnology/public/` directly inside `public_html/`.
Then edit `public_html/index.php` and update the paths:
```php
require __DIR__.'/../arbeittechnology/vendor/autoload.php';
$app = require_once __DIR__.'/../arbeittechnology/bootstrap/app.php';
```

---

### Step 4: Configure Production `.env` File
1. In cPanel File Manager, locate `/home/username/arbeittechnology/.env.example`.
2. Rename or copy it to `.env`.
3. Edit `.env` with your actual cPanel MySQL credentials and domain:
```ini
APP_NAME="Arbeit Technology"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=username_arbeittech
DB_USERNAME=username_dbuser
DB_PASSWORD=your_strong_password
```

---

### Step 5: Run Database Migrations & Seed Admin Account
Via Terminal / SSH (or cPanel Terminal / Cron Job):
```bash
cd /home/username/arbeittechnology
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

*Default Admin Account created after seeding:*
- **Email:** `admin@arbeittechnology.com`
- **Password:** `Arbeit@1234`

---

### Step 6: Optimize Cache for High Performance
Run these Artisan optimization commands to ensure super-fast page loads:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## ⚡ Quick One-Line Automated Deployment Command (via SSH)
If SSH is enabled on your cPanel account, simply run:
```bash
chmod +x deploy-cpanel.sh && ./deploy-cpanel.sh
```

---

## 🔒 Security Best Practices Checklist
- [x] `APP_DEBUG` is set to `false` in `.env`.
- [x] Sensitive credential files (`.env`) are outside `public_html`.
- [x] Database password is standard high-entropy string.
- [x] File upload permissions set to `0755` for directories and `0644` for files.
