@extends('layouts.store')

@section('title', 'Lacak Pesanan — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Lacak Pesanan</h1>
        <p>Masukkan detail pesanan Anda untuk melihat status terkini</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container" style="max-width: 560px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 24px; color: var(--color-accent);"></i>
                </div>
            </div>

            <form action="#" method="GET">
                <div class="form-group">
                    <label class="form-label">Nomor Pesanan</label>
                    <input type="text" class="form-input" name="order_id"
                           placeholder="Contoh: #000123" required>
                    <p class="text-xs text-muted mt-1">Ditemukan di email konfirmasi pesanan Anda.</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Penagihan</label>
                    <input type="email" class="form-input" name="email"
                           placeholder="Email yang digunakan saat checkout" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg mt-2">
                    <i class="fa-solid fa-search"></i> Lacak Sekarang
                </button>
            </form>
        </div>

        {{-- Help CTA --}}
        <div class="text-center mt-5" style="padding-top: 32px; border-top: 1px solid var(--color-border-light);">
            <h3 class="font-display" style="font-size: 18px; margin-bottom: 8px;">Butuh Bantuan?</h3>
            <p class="text-sm text-muted mb-3">Hubungi tim dukungan kami jika Anda mengalami kendala.</p>
            <a href="{{ url('/contact') }}" class="btn btn-outline btn-sm">Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection
