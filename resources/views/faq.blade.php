@extends('layouts.store')

@section('title', 'FAQ — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Pertanyaan Umum (FAQ)</h1>
        <p>Jawaban atas pertanyaan yang sering diajukan pelanggan kami</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="card card-body" style="padding: 40px;" x-data="{ openPanel: null }">
            <div class="prose max-w-none" style="line-height: 1.8; color: var(--color-text);">
                {{-- FAQ Item 1 --}}
                <div style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 20px; margin-bottom: 20px;">
                    <button class="flex items-center justify-between w-full text-left" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--color-text); font-family: var(--font-body);" @click="openPanel = (openPanel === 1 ? null : 1)">
                        <h4 style="font-weight: 700; font-size: 18px; margin: 0;">Apakah produk Ranti dijamin 100% original?</h4>
                        <i class="fa-solid fa-chevron-down text-muted" :class="{'fa-chevron-up': openPanel === 1, 'fa-chevron-down': openPanel !== 1}" style="transition: transform 0.2s;"></i>
                    </button>
                    <p class="mt-4 text-muted" x-show="openPanel === 1" x-collapse x-cloak>
                        Tentu saja. Semua produk yang dijual di situs web kami adalah 100% desain produksi asli Ranti Exclusive. Kualitas bahan dan detail jahitan terjaga untuk memberikan keanggunan dan kenyamanan terbaik bagi para pelanggan setia kami.
                    </p>
                </div>

                {{-- FAQ Item 2 --}}
                <div style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 20px; margin-bottom: 20px;">
                    <button class="flex items-center justify-between w-full text-left" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--color-text); font-family: var(--font-body);" @click="openPanel = (openPanel === 2 ? null : 2)">
                        <h4 style="font-weight: 700; font-size: 18px; margin: 0;">Berapa lama proses pengiriman produk?</h4>
                        <i class="fa-solid fa-chevron-down text-muted" :class="{'fa-chevron-up': openPanel === 2, 'fa-chevron-down': openPanel !== 2}" style="transition: transform 0.2s;"></i>
                    </button>
                    <p class="mt-4 text-muted" x-show="openPanel === 2" x-collapse x-cloak>
                        Pengiriman reguler memakan waktu sekitar 2-5 hari kerja untuk wilayah Pulau Jawa, dan 3-7 hari kerja untuk di luar Pulau Jawa. Anda dapat memantau status resi Anda kapan saja menggunakan halaman <a href="{{ url('/order-track') }}" style="color: var(--color-primary); font-weight: 600;">Lacak Pesanan</a>.
                    </p>
                </div>

                {{-- FAQ Item 3 --}}
                <div style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 20px; margin-bottom: 20px;">
                    <button class="flex items-center justify-between w-full text-left" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--color-text); font-family: var(--font-body);" @click="openPanel = (openPanel === 3 ? null : 3)">
                        <h4 style="font-weight: 700; font-size: 18px; margin: 0;">Apa saja metode pembayaran yang tersedia?</h4>
                        <i class="fa-solid fa-chevron-down text-muted" :class="{'fa-chevron-up': openPanel === 3, 'fa-chevron-down': openPanel !== 3}" style="transition: transform 0.2s;"></i>
                    </button>
                    <p class="mt-4 text-muted" x-show="openPanel === 3" x-collapse x-cloak>
                        Pilihan metode pembayaran (termasuk transfer Bank BCA, Mandiri, dan E-Wallet seperti GoPay atau Dana) secara dinamis direpresentasikan sewaktu Anda melakukan <i>checkout</i> pesanan. Pastikan opsi pembayaran tersedia sebelum Anda melanjutkan pesanan.
                    </p>
                </div>

                {{-- FAQ Item 4 --}}
                <div style="padding-bottom: 10px;">
                    <button class="flex items-center justify-between w-full text-left" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--color-text); font-family: var(--font-body);" @click="openPanel = (openPanel === 4 ? null : 4)">
                        <h4 style="font-weight: 700; font-size: 18px; margin: 0;">Apakah saya perlu membuat akun untuk berbelanja?</h4>
                        <i class="fa-solid fa-chevron-down text-muted" :class="{'fa-chevron-up': openPanel === 4, 'fa-chevron-down': openPanel !== 4}" style="transition: transform 0.2s;"></i>
                    </button>
                    <p class="mt-4 text-muted" x-show="openPanel === 4" x-collapse x-cloak>
                        Diwajibkan membuat akun untuk berbelanja produk di Ranti. Tujuannya adalah untuk memudahkan Anda menyimpan <a href="{{ route('wishlist.index') }}" style="color: var(--color-primary); font-weight: 600;">Wishlist</a>, memantau sejarah pesanan di dasbor pribadi, mempercepat proses <i>checkout</i> kedepannya dan melihat detail invoice secara praktis.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
