# 📦 Inventory System - Test IT Development

> Aplikasi manajemen inventory dengan fitur lengkap untuk mengelola produk, customer, dan transaksi penjualan.

[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)](https://mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)](https://docker.com)

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🔐 **Authentication** | Login/Register system dengan Laravel Breeze |
| 📦 **Product Management** | CRUD produk dengan validasi kode unik & alphanumeric |
| 👥 **Customer Management** | CRUD customer dengan data alamat lengkap Indonesia |
| 🧾 **Transaction System** | Auto-generate invoice (INV/YYMM/XXXX), multi-product, 3-tier discount |
| 📊 **Stock Management** | Validasi & pengurangan stok otomatis |
| 🎨 **Modern UI** | Responsive design dengan Tailwind CSS |
| 🛡️ **Security** | CSRF protection, input validation, SQL injection prevention |
| 📈 **Dashboard** | Real-time statistics & low stock alerts |

---

## 🛠️ Technology Stack

| Category | Technology |
|----------|-----------|
| **Framework** | Laravel 10 |
| **Authentication** | Laravel Breeze |
| **Database** | MySQL 8.0 |
| **PHP** | 8.1+ |
| **Frontend** | Blade Templates + Tailwind CSS + Alpine.js |
| **Build Tool** | Vite |
| **Container** | Docker + Docker Compose |

---

## 🚀 Installation

### Option 1: Docker (⭐ Recommended)

```bash
# 1. Clone repository
git clone https://github.com/MuhammadHatta72/inventory-app.git
cd inventory-app

# 2. Copy environment file
cp .env.example .env

# 3. Build and start containers
docker-compose up -d --build

# 4. Run migrations (wait 15s for MySQL to be ready)
docker-compose exec app php artisan migrate --seed

# 5. Access application
# Main App: http://localhost:8000
# PhpMyAdmin: http://localhost:8080
```

**Default Login:**
- Email: `admin@inventory.com`
- Password: `password`

---

### Option 2: Manual Installation

**Prerequisites:**
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js >= 16
- NPM

```bash
# 1. Clone repository
git clone https://github.com/MuhammadHatta72/inventory-app.git
cd inventory-app

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_system
DB_USERNAME=root
DB_PASSWORD=

# 5. Create database
mysql -u root -p -e "CREATE DATABASE inventory_system"

# 6. Run migrations
php artisan migrate --seed

# 7. Build assets
npm run build

# 8. Run application
php artisan serve
```

Access: http://localhost:8000

---
