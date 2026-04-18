@extends('layouts.store')

@section('title', 'Kebijakan Pengembalian — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Kebijakan Pengembalian</h1>
        <p>Informasi mengenai pengembalian produk dan penukaran</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="card card-body" style="padding: 40px;">
            <div class="prose max-w-none" style="line-height: 1.8; color: var(--color-text);">
                <h3 class="font-display" style="font-size: 24px; margin-bottom: 16px;">1. Syarat dan Ketentuan Pengembalian</h3>
                <p class="mb-6 text-muted">Aset produk yang dapat dikembalikan adalah produk yang cacat produksi, kesalahan pengiriman, atau ukuran yang tidak sesuai. Anda memiliki waktu <strong>7 hari kalender</strong> sejak produk diterima untuk mengajukan pengembalian.</p>

                <ul class="mb-6 text-muted" style="list-style-type: disc; padding-left: 20px;">
                    <li>Produk harus dalam kondisi asli, belum dicuci, tidak rusak (kecuali dari pabrik), dan belum pernah dipakai (selain percobaan ukuran).</li>
                    <li>Label/tag produk dan kemasan bawaan harus masih terpasang dengan baik.</li>
                    <li>Sertakan bukti pembelian atau nomor pesanan Anda dalam permintaan pengembalian.</li>
                </ul>

                <h3 class="font-display" style="font-size: 24px; margin-bottom: 16px;">2. Proses Pengembalian</h3>
                <p class="mb-6 text-muted">Untuk memulai proses pengembalian, silakan hubungi layanan pelanggan kami melalui halaman <a href="{{ url('/contact') }}" style="color: var(--color-primary); font-weight: 600;">Kontak</a> atau via WhatsApp resmi. Tim kami akan memberikan instruksi lebih lanjut terkait alamat pengiriman kembali barang Anda.</p>

                <h3 class="font-display" style="font-size: 24px; margin-bottom: 16px;">3. Batasan Pengecualian</h3>
                <p class="mb-6 text-muted">Beberapa produk seperti pakaian dalam (inner), kaus kaki, pernak-pernik kecil (bros), atau barang kosmetik tidak dapat dikembalikan demi menjaga kebersihan dan kesehatan operasional toko kecuali terjadi cacat produksi dari pihak Ranti.</p>

                <h3 class="font-display" style="font-size: 24px; margin-bottom: 16px;">4. Dana Pengembalian (Refund)</h3>
                <p class="text-muted">Setelah pesanan pengembalian Anda tiba di gudang dan lolos proses pengecekan (Quality Control), pengembalian dana akan diproses maksimal 3-5 hari kerja. Pengembalian dana dapat dilakukan melalui transfer ke rekening bank Anda atau e-Wallet yang didukung.</p>
            </div>
        </div>
    </div>
</section>
@endsection
