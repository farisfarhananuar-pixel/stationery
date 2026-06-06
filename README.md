# ✏️ PenBox — Online Stationery Marketplace

A full-featured Laravel e-commerce platform for buying and selling stationery online, built with multi-role authentication (User, Seller, Admin), QR payment system, delivery tracking, and a modern colourful UI.

---

## 🚀 Features

- **3-Role System**: Customer, Seller, Admin
- **Product Browsing**: Search, filter by category, sort by price
- **Shopping Cart**: Add, update, remove items
- **Checkout Flow**: Shipping address + contact details
- **QR Payment System**: Seller uploads QR → Customer scans & transfers → Uploads receipt → Seller approves/rejects
- **Delivery Tracking**: Seller updates status (Processing → Shipped → Delivered)
- **Seller Dashboard**: Manage products, view orders, handle payments
- **Admin Panel**: Approve sellers, manage users/categories
- **Public Pages**: Home, Shop, About Us, Contact Us, Our Team (Website Owner)
- **10+ Stationery Products** seeded with descriptions
- **Modern Colourful UI** using Bootstrap 5 + custom CSS

---

## 📦 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 10 (PHP 8.1+) |
| Frontend | Bootstrap 5, Bootstrap Icons, Google Fonts (Poppins) |
| Database | MySQL |
| File Storage | Laravel Storage (public disk) |
| Deployment | Railway |
| Version Control | GitHub |

---

## ⚙️ Local Setup

### 1. Clone the repo
```bash
git clone https://github.com/YOUR_USERNAME/stationery-shop.git
cd stationery-shop
```

### 2. Install dependencies
```bash
composer install
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="PenBox Stationery"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stationery_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Create database
```sql
CREATE DATABASE stationery_shop;
```

### 5. Run migrations & seed
```bash
php artisan migrate --seed
```

### 6. Link storage
```bash
php artisan storage:link
```

### 7. Start server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## 🔑 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@penbox.com | password |
| Seller | seller@penbox.com | password |
| Customer | user@penbox.com | password |

---

## 🚂 Railway Deployment

1. Push project to GitHub
2. Create new Railway project → Deploy from GitHub
3. Add MySQL plugin in Railway
4. Set environment variables:
   - `APP_KEY` — generate with `php artisan key:generate --show`
   - `APP_URL` — your Railway domain
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — from Railway MySQL plugin
   - `APP_DEBUG=false`
5. Railway will use `nixpacks.toml` for build & start

---

## 📁 Project Structure

```
stationery-shop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php
│   │   │   ├── User/{HomeController, CartController, OrderController}
│   │   │   ├── Seller/SellerController.php
│   │   │   └── Admin/AdminController.php
│   │   └── Middleware/RoleMiddleware.php
│   └── Models/{User, SellerProfile, Product, Category, Cart, Order, OrderItem}
├── database/
│   ├── migrations/     (7 migration files)
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── layouts/{app, dashboard}.blade.php
│   ├── auth/{login, register}.blade.php
│   ├── user/{home, shop, product-detail, cart, checkout, orders, order-detail, about, contact, website-owner}
│   ├── seller/{dashboard, products, product-form, orders, order-detail, profile, pending}
│   └── admin/{dashboard, users, sellers, orders, categories}
├── routes/web.php
├── nixpacks.toml       (Railway config)
└── .env.example
```

---

## 💳 Payment Flow (QR System)

```
Customer places order
        ↓
Seller uploads QR code (in profile settings)
        ↓
Customer views QR on order detail page
        ↓
Customer transfers via DuitNow / bank transfer
        ↓
Customer uploads receipt + enters amount transferred
        ↓
Seller reviews receipt → Approve ✅ or Reject ❌
        ↓
If approved → Seller updates delivery status
(Processing → Shipped → Delivered)
        ↓
Customer tracks delivery on order detail page
```

---

## 👨‍💻 Team

| Name | Matric | Role |
|------|--------|------|
| Muhammad Farhan bin Ahmad | 281234 | Project Lead & Full-Stack Developer |
| Nur Aisyah binti Zulkifli | 281235 | Frontend Developer & UI/UX Designer |
| Ahmad Haziq bin Mohd Noor | 281236 | Backend Developer & Database Engineer |
| Siti Nabilah binti Rashid | 281237 | Tester & Documentation Specialist |
| Mohamad Izzat bin Sulaiman | 281238 | System Analyst & Integration Specialist |

---

© 2024 PenBox Team — Universiti Utara Malaysia
