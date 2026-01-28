# Inventory System - Test IT Development

Aplikasi manajemen inventory dengan fitur CRUD Produk, Customer, dan Transaksi.

## Features

- ✅ Authentication menggunakan Laravel Breeze
- ✅ CRUD Produk dengan validasi kode unik
- ✅ CRUD Customer dengan data alamat lengkap
- ✅ CRUD Transaksi dengan auto-generate invoice number
- ✅ Stok management otomatis
- ✅ Multi-level discount (3 tingkat diskon)
- ✅ Clean code dengan MVVC pattern
- ✅ Error handling yang baik
- ✅ Database design yang optimal

## Technology Stack

- **Framework**: Laravel 12
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **PHP Version**: 8.1+
- **CSS Framework**: Tailwind CSS (via Breeze)

## Installation

Ada 2 cara instalasi: **Docker (Recommended)** atau **Manual Installation**

### Option 1: Docker Installation (Recommended) 🐳

**Prerequisites:**
- Docker & Docker Compose

**Quick Start:**
```bash
# Clone repository
git clone https://github.com/MuhammadHatta72/inventory-app
cd inventory-app

# Copy environment file
cp .env.example .env

# Build and start containers
docker-compose up -d --build

Selesai! Aplikasi berjalan di:
- **Main App**: http://localhost:8000

---

### Option 2: Manual Installation

**Prerequisites:**
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & NPM

**Steps:**

1. Clone repository
```bash
git clone https://github.com/MuhammadHatta72/inventory-app
cd inventory-app
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di file `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_system
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Seed data (optional)
```bash
php artisan db:seed
```

7. Build assets
```bash
npm run build
```

8. Run application
```bash
php artisan serve
```

Access aplikasi di: `http://localhost:8000`

## Database Structure

### Table: products
- id (primary key)
- code (unique, alphanumeric only)
- name
- price
- stock
- created_at, updated_at

### Table: customers
- id (primary key)
- code (unique, alphanumeric only)
- name
- full_address
- province
- city
- district (kecamatan)
- village (kelurahan)
- postal_code
- created_at, updated_at

### Table: transactions
- id (primary key)
- invoice_number (unique, format: INV/YYMM/0001)
- customer_code
- customer_name
- customer_address
- transaction_date
- total
- created_at, updated_at

### Table: transaction_details
- id (primary key)
- transaction_id (foreign key)
- invoice_number
- product_code
- product_name
- qty
- price
- discount_1
- discount_2
- discount_3
- net_price
- subtotal
- created_at, updated_at

## Business Rules

### Product
- Kode produk harus unik
- Hanya alphanumeric, tidak boleh special character
- Produk tidak bisa dihapus jika sudah ada transaksi

### Customer
- Kode customer harus unik
- Hanya alphanumeric, tidak boleh special character
- Customer tidak bisa dihapus jika sudah ada transaksi

### Transaction
- Invoice number auto-generate dengan format: INV/YYMM/0001
- Reset nomor urut setiap bulan
- Qty tidak boleh lebih dari stok tersedia
- Stok produk berkurang otomatis setelah transaksi
- Harga bisa diubah saat transaksi
- Diskon bertingkat (3 level)
- Perhitungan: Net Price = Price - (Disc1 + Disc2 + Disc3)
- Subtotal = Net Price × Qty
