@extends('layouts.store')

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="hero__bg" style="background-image: url('https://static.mineralcdn.net/site/ranticoid/banner/hero1.jpg');"></div>
    <div class="container">
        <div class="hero__content animate-in">
            <p class="hero__eyebrow">Koleksi Exclusive 2026</p>
            <h1 class="hero__title">Keanggunan<br>dalam Setiap Jahitan</h1>
            <p class="hero__subtitle">Busana muslim premium yang dirancang untuk menemani setiap momen berharga Anda — dari ibadah hingga acara istimewa.</p>
            <div class="flex gap-md flex-wrap">
                <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg">Jelajahi Koleksi</a>
                <a href="{{ route('products.index', ['category' => 'dress']) }}" class="btn btn-accent btn-lg">Dress Terbaru</a>
            </div>
        </div>
    </div>
</section>

{{-- Trust Strip --}}
<section style="margin-top: -40px; position: relative; z-index: 10;">
    <div class="container">
        <div class="feature-strip">
            <div class="feature-item">
                <i class="fa-solid fa-truck-fast"></i>
                <div>
                    <h5>Gratis Ongkir</h5>
                    <p>Untuk pesanan di atas Rp 1jt</p>
                </div>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <h5>100% Original</h5>
                    <p>Garansi keaslian produk</p>
                </div>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-rotate-left"></i>
                <div>
                    <h5>Easy Return</h5>
                    <p>Pengembalian mudah 7 hari</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Best Sellers --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Produk Terlaris</h2>
                <p>Pilihan favorit pelanggan kami minggu ini</p>
            </div>
            <a href="{{ route('products.index') }}" class="section-link">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-4">
            @foreach($bestSellers as $product)
            <a href="{{ route('product.detail', $product->slug) }}" style="text-decoration: none; color: inherit;">
                <div class="product-card">
                    <div class="product-card__image" style="position: relative;">
                        <img src="{{ asset('assets/product/' . $product->image) }}" alt="{{ $product->name }}">
                        <div style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                            @php
                                $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                            @endphp
                            <button
                                type="button"
                                class="wishlist-btn {{ $inWishlist ? 'active' : '' }}"
                                data-wishlist-btn
                                data-product-id="{{ $product->id }}"
                                title="{{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}"
                                style="width: 32px; height: 32px;"
                            >
                                <i class="fa-{{ $inWishlist ? 'solid' : 'regular' }} fa-heart" style="font-size: 14px; color: {{ $inWishlist ? '#f43f5e' : 'var(--color-text-muted)' }};"></i>
                            </button>
                        </div>
                        @if($product->original_price)
                            <div class="product-card__badge" style="position: absolute; top: 12px; left: 12px; z-index: 10;">
                                <span class="badge badge-sale">-{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%</span>
                            </div>
                        @endif
                    </div>
                    <div class="product-card__body">
                        <p class="product-card__category">{{ $product->category->name ?? '' }}</p>
                        <h3 class="product-card__name">{{ $product->name }}</h3>
                        <div class="product-card__price">
                            <span class="product-card__price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->original_price)
                                <span class="product-card__price-original">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Banner --}}
<section style="background: var(--color-primary); padding: 80px 0;">
    <div class="container text-center">
        <p class="hero__eyebrow" style="margin-bottom: 12px;">Exclusive Offer</p>
        <h2 class="font-display" style="color: #fff; font-size: 36px; margin-bottom: 16px;">Diskon hingga 70% untuk Koleksi Pilihan</h2>
        <p style="color: rgba(255,255,255,0.6); max-width: 500px; margin: 0 auto 32px; font-size: 15px;">Jangan lewatkan penawaran spesial untuk produk-produk eksklusif Ranti. Stok terbatas!</p>
        <a href="{{ route('products.index') }}" class="btn btn-accent btn-lg">Belanja Sekarang</a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // lazy load product card images
        const cards = document.querySelectorAll('.product-card');
        cards.forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 + i * 100);
        });
    });
</script>
@endpush
