@extends('layouts.store')

@section('title', $product->name . ' — Ranti')

@section('content')
<section class="section" style="padding-top: 40px; background: var(--color-bg);">
    <div class="container">
        {{-- Breadcrumb --}}
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Beranda</a></li>
            <li><a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            <li>{{ $product->name }}</li>
        </ul>

        <div class="layout-split" style="grid-template-columns: 1fr 1fr; gap: 56px;">
            {{-- Product Image --}}
            <div>
                <div class="card" style="border-radius: var(--radius-lg); overflow: hidden;">
                    <img src="{{ asset('assets/product/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         style="width: 100%; aspect-ratio: 3/4; object-fit: cover;">
                </div>
            </div>

            {{-- Product Info --}}
            <div style="padding-top: 16px;">
                <span class="badge badge-category mb-2">{{ $product->category->name }}</span>
                <h1 class="font-display" style="font-size: 32px; margin-bottom: 20px;">{{ $product->name }}</h1>

                {{-- Rating Summary --}}
                @if($product->reviews()->count() > 0)
                <div class="flex items-center gap-sm mb-4" style="color: #f59e0b; font-size: 14px;">
                    <div>
                        @php $avgRating = round($product->average_rating); @endphp
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="text-sm text-muted font-bold" style="color: var(--color-text);">{{ number_format($product->average_rating, 1) }}</span>
                    <span class="text-xs text-muted" style="margin-left: 4px;">({{ $product->reviews()->count() }} Ulasan)</span>
                </div>
                @endif

                {{-- Price --}}
                <div class="flex items-center gap-md mb-3" style="flex-wrap: wrap;">
                    <span style="font-size: 28px; font-weight: 700; color: var(--color-primary);">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    @if($product->original_price)
                        <span style="font-size: 18px; color: var(--color-text-muted); text-decoration: line-through;">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </span>
                        <span class="badge badge-sale">
                            Hemat {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                <div class="mb-4" style="border-top: 1px solid var(--color-border-light); padding-top: 24px;">
                    <h5 style="font-family: var(--font-body); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--color-text-muted); margin-bottom: 10px;">Deskripsi</h5>
                    <p class="text-muted" style="line-height: 1.8;">{{ $product->description }}</p>
                </div>

                {{-- Size Selector --}}
                <div class="mb-4">
                    <h5 style="font-family: var(--font-body); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--color-text-muted); margin-bottom: 12px;">Ukuran</h5>
                    <div class="flex gap-sm flex-wrap">
                        @foreach(['S', 'M', 'L', 'XL'] as $size)
                            <button type="button" class="btn btn-ghost size-btn" data-size="{{ $size }}" style="border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); min-width: 52px; transition: all 0.2s;">{{ $size }}</button>
                        @endforeach
                    </div>
                </div>

                {{-- Add to Cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 32px;">
                    @csrf
                    <input type="hidden" name="size" id="selected-size" value="">
                    <div class="flex gap-md items-center flex-wrap">
                        <div class="qty-selector">
                            <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="flex: 1;">
                            <i class="fa-solid fa-bag-shopping"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </form>

                @php
                    $inWishlist = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                @endphp
                <button
                    type="button"
                    id="wishlist-detail-btn"
                    class="btn btn-block wishlist-btn {{ $inWishlist ? 'active' : '' }}"
                    data-wishlist-btn
                    data-product-id="{{ $product->id }}"
                    style="margin-top: 16px; border-radius: var(--radius-md); border: 1.5px solid {{ $inWishlist ? '#f43f5e' : 'var(--color-border)' }}; color: {{ $inWishlist ? '#f43f5e' : 'inherit' }}; background: transparent; padding: 12px; font-family: var(--font-body); font-size: 15px; gap: 10px; width: 100%;"
                >
                    <i class="fa-{{ $inWishlist ? 'solid' : 'regular' }} fa-heart" style="color: {{ $inWishlist ? '#f43f5e' : 'inherit' }};"></i>
                    <span id="wishlist-btn-text">{{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}</span>
                </button>


                {{-- Trust Signals --}}
                <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--color-border-light);">
                    <div class="flex gap-lg flex-wrap">
                        <div class="flex items-center gap-sm text-sm text-muted">
                            <i class="fa-solid fa-truck-fast" style="color: var(--color-accent);"></i> Pengiriman seluruh Indonesia
                        </div>
                        <div class="flex items-center gap-sm text-sm text-muted">
                            <i class="fa-solid fa-shield-halved" style="color: var(--color-accent);"></i> 100% Original
                        </div>
                        <div class="flex items-center gap-sm text-sm text-muted">
                            <i class="fa-solid fa-rotate-left" style="color: var(--color-accent);"></i> Easy Return 7 hari
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        {{-- Product Reviews --}}
        <div class="mt-5" style="padding-top: 40px; border-top: 1px solid var(--color-border-light);">
            <div class="section-header">
                <h2>Ulasan Pelanggan</h2>
            </div>
            
            @php $reviews = $product->reviews()->with('user')->latest()->get(); @endphp
            
            @if($reviews->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 24px; max-width: 800px;">
                    @foreach($reviews as $review)
                    <div style="background: var(--color-surface); padding: 24px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-user" style="color: var(--color-accent);"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 14px; font-weight: 700; margin: 0;">{{ $review->user->name ?? 'Pengguna' }}</h4>
                                    <p class="text-xs text-muted" style="margin: 0;">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div style="color: #f59e0b; font-size: 12px;">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p style="font-size: 14px; color: var(--color-text); line-height: 1.6; margin: 0;">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 48px 20px; background: var(--color-bg-warm); border-radius: var(--radius-md);">
                    <i class="fa-regular fa-comment-dots" style="font-size: 40px; color: var(--color-border); margin-bottom: 16px; display: block;"></i>
                    <h3 style="font-size: 16px; margin-bottom: 8px;">Belum Ada Ulasan</h3>
                    <p class="text-muted text-sm">Jadilah yang pertama memberikan ulasan untuk produk ini setelah membelinya!</p>
                </div>
            @endif
        </div>
        {{-- Related Products --}}
        @php $related = $product->category->products->where('id', '!=', $product->id)->take(4); @endphp
        @if($related->count() > 0)
        <div class="mt-5" style="padding-top: 40px; border-top: 1px solid var(--color-border-light);">
            <div class="section-header">
                <h2>Produk Serupa</h2>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="section-link">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="grid grid-4">
                @foreach($related as $item)
                <a href="{{ route('product.detail', $item->slug) }}" style="text-decoration: none; color: inherit;">
                    <div class="product-card">
                        <div class="product-card__image">
                            <img src="{{ asset('assets/product/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="product-card__body">
                            <h3 class="product-card__name">{{ $item->name }}</h3>
                            <div class="product-card__price">
                                <span class="product-card__price-current">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Extra logic for product detail page: update border color & label text after wishlist toggle
    (function () {
        const btn = document.getElementById('wishlist-detail-btn');
        if (!btn) return;
        const origToggle = btn._wishlistBound;
        // Observe state changes via MutationObserver on the button's class attribute
        const observer = new MutationObserver(() => {
            const icon = btn.querySelector('i.fa-heart');
            const textEl = document.getElementById('wishlist-btn-text');
            if (!icon || !textEl) return;
            const isActive = icon.classList.contains('fa-solid') || btn.classList.contains('active');
            btn.style.borderColor = isActive ? '#f43f5e' : 'var(--color-border)';
            btn.style.color       = isActive ? '#f43f5e' : 'inherit';
            textEl.textContent    = isActive ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist';
        });
        observer.observe(btn, { attributes: true, attributeFilter: ['class'] });
    })();

    // Size Selector Logic
    (function () {
        const sizeButtons = document.querySelectorAll('.size-btn');
        const hiddenInput = document.getElementById('selected-size');
        
        function selectSize(btn) {
            // Reset all buttons
            sizeButtons.forEach(b => {
                b.style.borderColor = 'var(--color-border)';
                b.style.background = 'transparent';
                b.style.color = 'inherit';
                b.style.fontWeight = 'normal';
                b.classList.remove('active');
            });
            
            // Highlight selected button
            btn.style.borderColor = 'var(--color-primary)';
            btn.style.background = 'rgba(196,162,101,0.08)'; // Subtle accent background
            btn.style.color = 'var(--color-primary)';
            btn.style.fontWeight = '700';
            btn.classList.add('active');
            
            // Update hidden input
            hiddenInput.value = btn.dataset.size;
        }

        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => selectSize(btn));
        });

        // Set default size (e.g., the first one)
        if (sizeButtons.length > 0) {
            selectSize(sizeButtons[0]);
        }
    })();
</script>

@endpush

