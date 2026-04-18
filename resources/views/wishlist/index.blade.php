@extends('layouts.store')

@section('title', 'Wishlist Saya — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Wishlist Saya</h1>
        <p>Lihat kembali produk-produk yang Anda inginkan</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container">
        <div class="dash-layout">
            {{-- Sidebar --}}
            <aside class="dash-sidebar">
                <div class="card">
                    <div class="dash-sidebar-header">
                        <i class="fa-solid fa-circle-user"></i>
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="dash-menu">
                        <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> Dashboard</a></li>
                        <li><a href="#"><i class="fa-solid fa-box-open"></i> Pesanan Saya</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="active"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
                        <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Main --}}
            <div>
                <div class="card card-body" style="padding: 32px;">
                    <h3 class="font-display" style="font-size: 20px; margin-bottom: 24px;">Daftar Keinginan Anda</h3>

                    @if(session('success'))
                        <div class="alert alert-success" style="margin-bottom: 24px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($wishlists->count() > 0)
                        <div class="grid grid-3">
                            @foreach($wishlists as $item)
                                <div class="product-card" data-wishlist-card style="box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light);">
                                    <a href="{{ route('product.detail', $item->product->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                                        <div class="product-card__image" style="position: relative;">
                                            <img src="{{ asset('assets/product/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        </div>
                                    </a>
                                    <div class="product-card__body">
                                        <a href="{{ route('product.detail', $item->product->slug) }}" style="text-decoration: none; color: inherit;">
                                            <h3 class="product-card__name">{{ $item->product->name }}</h3>
                                            <div class="product-card__price">
                                                <span class="product-card__price-current">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                            </div>
                                        </a>
                                        <div style="display: flex; gap: 8px; margin-top: 16px;">
                                            <form action="{{ route('cart.add', $item->product->id) }}" method="POST" style="flex: 1;">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">Teruskan ke Keranjang</button>
                                            </form>
                                            <button
                                                type="button"
                                                class="btn btn-outline btn-sm wishlist-btn active"
                                                data-wishlist-btn
                                                data-product-id="{{ $item->product->id }}"
                                                title="Hapus dari Wishlist"
                                                style="border-color: #f43f5e; border-width: 1px; color: #f43f5e; width: 38px; padding: 0; justify-content: center;"
                                            >
                                                <i class="fa-solid fa-heart" style="color: #f43f5e;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        
                        @if($wishlists->hasPages())
                            <div style="margin-top: 32px;">
                                {{ $wishlists->links() }}
                            </div>
                        @endif
                    @else
                        <div style="text-align: center; padding: 48px 20px; background: var(--color-bg); border-radius: var(--radius-md);">
                            <i class="fa-regular fa-heart" style="font-size: 36px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                            <p class="text-muted" style="margin-bottom: 16px;">Wishlist Anda masih kosong.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Mulai Belanja</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
