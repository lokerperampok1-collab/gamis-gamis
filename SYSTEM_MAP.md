# SYSTEM_MAP.md

## 1. Project Summary
- **Tujuan**: Platform E-commerce Premium khusus busana Muslimah "Ranti" dengan fitur logistik internal kustom.
- **Stack**: PHP 8.3, Laravel 11, MySQL, Nginx (VPS Ubuntu 22.04), Google OAuth.
- **Arsitektur**: Model-View-Controller (MVC) dengan Laravel Blade sebagai engine frontend.

## 2. Core Logic Flow
- **Checkout**: `POST /checkout` -> `CartController[store]` -> Save Order & Items -> Status: `pending`.
- **Payment**: `POST /orders/{id}/payment` -> `PaymentController[store]` -> Upload Proof -> Status: `payment_uploaded`.
- **Admin Verification**: `PATCH /admin/orders/{id}/verify` -> `AdminController[verifyOrder]` -> Auto-generate Resi -> Status: `processing`.
- **Tracking**: `GET /order-track` -> `OrderTrackingController[index]` -> Search by `tracking_number` + `email` -> View Status & Timeline.
- **Internal Logistics**: `POST /admin/orders/{id}/log` -> `AdminController[addTrackingLog]` -> Update granular package location.

## 3. Clean Tree
```text
e:/ecommerce
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/ (Dashboard, Categories, Products, Orders, Logistics)
│   │   ├── Auth/ (Laravel Breeze)
│   │   ├── CartController.php
│   │   ├── GoogleAuthController.php
│   │   ├── PaymentController.php
│   │   └── OrderTrackingController.php
│   └── Models/ (User, Product, Order, OrderStatusLog, etc.)
├── database/
│   ├── migrations/ (Schema definition)
│   └── seeders/ (InitialDataSeeder)
├── public/assets/
│   ├── css/style.css (Custom Design System)
│   ├── product/ (Stored product images)
│   └── payments/ (Uploaded payment proofs)
├── resources/views/
│   ├── admin/ (Admin Panel)
│   ├── auth/ (Custom Auth Pages)
│   ├── layouts/ (Admin & Store Layouts)
│   ├── contact.blade.php
│   └── order-track.blade.php
└── routes/
    ├── web.php (All routes)
    └── auth.php (Auth routes)
```

## 4. Module Map (The Chapters)
- `app/Http/Controllers/Admin/AdminController.php`: Otak dari operasional admin | Menangani produk, verifikasi pesanan, dan sistem logistik internal.
- `app/Http/Controllers/OrderTrackingController.php`: Jembatan pelacakan paket | Menangani pencarian resi publik dan penayangan linimasa perjalanan.
- `app/Models/Order.php`: Entitas utama transaksi | Mengelola data pesanan, status, dan relasi ke riwayat logistik.
- `resources/views/layouts/store.blade.php`: Kerangka utama website | Desain sistem premium dengan estetik Muslimah yang konsisten.

## 5. Data & Config
- **Config**: `.env` (Environment & DB), `config/` (App & Auth config).
- **Schema**: 11 Tabel Utama (Users, Products, Categories, Orders, OrderItems, Coupons, Reviews, Wishlists, PaymentMethods, OrderStatusLogs, PasswordResets).
- **Migration**: `database/migrations/`, `database/seeders/InitialDataSeeder.php` (Restorasi data produk & admin).

## 6. External Integrations
- **Google OAuth**: `GoogleAuthController` | Menggunakan Socialite untuk login sekali klik.
- **FontAwesome & Google Fonts**: Integrasi CDN untuk antarmuka premium.

## 7. Risks / Blind Spots
- **Manual Verification**: Pembayaran masih diverifikasi manual oleh manusia.
- **Static Shipping**: Belum ada integrasi API ongkir otomatis (RajaOngkir).
- **Folder Permissions**: VPS membutuhkan `chown` manual untuk folder `uploads` agar tidak Error 500.

---
*Dibuat secara otomatis oleh Antigravity (IA) pada 20 April 2026.*
