# Rencana Implementasi: Google Social Login & Auto Generate Resi

Dokumen ini adalah panduan teknis untuk menambahkan fitur Login SSO Google dan Pembuatan Resi Otomatis pada proyek E-Commerce ini.

## 📅 Tahap 1: Login Cepat via Google (Laravel Socialite)
**Tujuan**: Memungkinkan pengguna mendaftar dan login dengan satu klik menggunakan akun Google, mem-bypass pengisian form yang rumit panjang.

**Step-by-Step Task:**
- [ ] **Install Package**: Jalankan `composer require laravel/socialite`.
- [ ] **Modifikasi Database**:
  - Buat migration baru: `php artisan make:migration add_google_id_to_users_table`.
  - Tambahkan kolom `google_id` (string, nullable) pada tabel `users`.
  - Tambahkan `google_id` ke dalam array atribut `Fillable` di file `app/Models/User.php` (`#[Fillable(['name', 'email', 'password', 'is_admin', 'google_id'])]`).
- [ ] **Konfigurasi Services**:
  - Daftarkan client-id dan secret-id di `config/services.php`:
    ```php
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', 'http://localhost:8000/auth/google/callback'),
    ],
    ```
- [ ] **Buat & Setup Controller**:
  - Buat controller misal `GoogleAuthController`.
  - Buat dua function: `redirect()` (untuk melempar user ke oAuth screen Google) dan `callback()` (untuk menangkap Google User dan mencari/membuat data di tabel `users`).
  - Tambahkan kedua rute tersebut di `routes/web.php`.
- [ ] **Update Tampilan Login**:
  - Sesuaikan tampilan `resources/views/auth/login.blade.php` dengan manambahkan tombol "Lanjutkan dengan Google" yang mengarah ke route redirect tadi.

---

## 📅 Tahap 2: Otomatisasi Generate Resi saat Verifikasi Pembayaran
**Tujuan**: Menghemat waktu kerja admin dengan otomatis membuat dan menugaskan Nomor Resi pesanan sewaktu pembayaran dikonfirmasi dari Dashboard Admin.

**Step-by-Step Task:**
- [ ] **Kenali Lokasi Kode Eksekusi**:
  - Buka file `app/Http/Controllers/Admin/AdminController.php`.
  - Fokus pada method `verifyOrder(Order $order)` yang bertugas mengubah status pesanan.
- [ ] **Tambahkan Logika Resi**:
  - Saat mengubah status pesanan menjadi `processing` atau `verified`, otomatis sertakan *generate string* acak untuk kolom `tracking_number` (karena kolom ini sudah ada di Model `Order`).
  - *Code snippet logic*:
    ```php
    public function verifyOrder(\App\Models\Order $order)
    {
        $order->status = 'processing';
        // Auto-generate resi dengan pattern misal "RTX-" ditambah karakter acak dan tanggal
        $order->tracking_number = 'RTX-' . strtoupper(Str::random(6)) . '-' . date('dmy');
        $order->save();

        return redirect()->back()->with('success', 'Pesanan diverifikasi & resi otomatis dibuat.');
    }
    ```
- [ ] **Pastikan Resi Ditampilkan dengan Baik**:
  - Verifikasi bahwa halaman Lacak Pesanan (`/order-track`) atau detail pesanan (baik di UI user maupun modal admin) masih dapat menampilkan `$order->tracking_number` yang di-*generate* secara otomatis ini tanpa kendala.
