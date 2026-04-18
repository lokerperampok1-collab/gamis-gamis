@extends('layouts.store')

@section('title', 'Koleksi Lengkap — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Semua Koleksi</h1>
        <p>Temukan keanggunan dalam setiap desain eksklusif kami</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container">
        {{-- Category Filter Pills --}}
        <div class="flex justify-between items-center mb-4 flex-wrap gap-md">
            <div class="category-pills">
                <a href="{{ route('products.index') }}"
                   class="category-pill {{ !request('category') ? 'active' : '' }}">Semua</a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="category-pill {{ request('category') == $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <span class="text-sm text-muted">{{ $products->total() }} produk</span>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-4" style="margin-top: 32px;">
            @forelse($products as $product)
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
                                    style="width: 36px; height: 36px;"
                                >
                                    <i class="fa-{{ $inWishlist ? 'solid' : 'regular' }} fa-heart" style="font-size: 15px; color: {{ $inWishlist ? '#f43f5e' : 'var(--color-text-muted)' }};"></i>
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
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
                    <i class="fa-solid fa-box-open" style="font-size: 48px; color: var(--color-text-muted); margin-bottom: 16px;"></i>
                    <h3 class="font-display mb-2">Tidak Ada Produk</h3>
                    <p class="text-muted mb-3">Maaf, tidak ada produk dalam kategori ini saat ini.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Semua</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>
@endsection
