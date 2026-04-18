<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Ranti — Belanja Gamis Syari, Koko & Busana Muslim Exclusive Premium Quality.">
    <title>@yield('title', 'Ranti — Busana Muslim Exclusive Premium')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Design System --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>
<body>
    <div class="page-wrapper">
        {{-- Top Bar --}}
        <div class="site-topbar">
            <div class="container">
                <span>✦ Free Shipping untuk pembelian di atas Rp 1.000.000</span>
                <div class="flex gap-md items-center">
                    <a href="{{ url('/order-track') }}" style="color: rgba(255,255,255,0.7);">
                        <i class="fa-solid fa-truck" style="font-size: 12px;"></i> Lacak Pesanan
                    </a>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <header class="site-header">
            <div class="container">
                <nav class="site-nav">
                    <a href="{{ url('/') }}" class="site-logo">
                        <img src="https://static.mineralcdn.net/site/ranticoid/logo_white_2025@3x.png"
                             alt="Ranti" style="height: 40px;">
                    </a>

                    <button class="nav-toggle" id="navToggle" aria-label="Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <ul class="nav-links" id="navLinks">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}">Koleksi</a></li>
                        <li><a href="{{ url('/contact') }}">Kontak</a></li>
                    </ul>

                    <ul class="nav-actions">
                        @auth
                            <li>
                                <a href="{{ route('wishlist.index') }}" title="Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}" title="Dashboard">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" title="Keluar">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" title="Masuk">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                            </li>
                        @endauth
                        <li>
                            <a href="{{ route('cart.index') }}" title="Keranjang" style="position: relative;">
                                <i class="fa-solid fa-bag-shopping"></i>
                                @if(count(session('cart', [])) > 0)
                                    <span class="cart-badge">{{ count(session('cart', [])) }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="page-main">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="site-footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand">
                        <h3 class="font-display">Ranti</h3>
                        <p>Premium quality busana muslim dengan desain eksklusif yang memadukan keanggunan dan kenyamanan untuk setiap momen berharga Anda.</p>
                    </div>

                    <div class="footer-col">
                        <h5>Belanja</h5>
                        <ul>
                            <li><a href="{{ route('products.index', ['category' => 'dress']) }}">Dress</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'koko']) }}">Koko</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'scarf']) }}">Scarf</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'tunic']) }}">Tunic</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h5>Bantuan</h5>
                        <ul>
                            <li><a href="{{ url('/contact') }}">Hubungi Kami</a></li>
                            <li><a href="{{ url('/order-track') }}">Lacak Pesanan</a></li>
                            <li><a href="{{ route('return-policy') }}">Kebijakan Pengembalian</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h5>Ikuti Kami</h5>
                        <div class="footer-social">
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    &copy; {{ date('Y') }} Ranti Exclusive. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    {{-- Global Toast Notification --}}
    <div id="toast-container" style="
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    "></div>

    <style>
        .toast-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 12px;
            background: #1a1a2e;
            color: #fff;
            font-size: 14px;
            font-family: var(--font-body, 'Inter', sans-serif);
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            pointer-events: all;
            min-width: 260px;
            max-width: 340px;
            animation: toastSlideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            border-left: 4px solid #c4a265;
        }
        .toast-item.toast-success { border-left-color: #22c55e; }
        .toast-item.toast-error   { border-left-color: #ef4444; }
        .toast-item.toast-wishlist { border-left-color: #f43f5e; }
        .toast-item .toast-icon { font-size: 18px; flex-shrink: 0; }
        .toast-item.toast-out {
            animation: toastSlideOut 0.3s ease forwards;
        }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(60px) scale(0.92); }
            to   { opacity: 1; transform: translateX(0)   scale(1);    }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0)   scale(1);    }
            to   { opacity: 0; transform: translateX(60px) scale(0.92); }
        }
        /* Wishlist heart button base style */
        .wishlist-btn {
            background: rgba(255,255,255,0.92);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: transform 0.2s, background 0.2s;
        }
        .wishlist-btn:hover { transform: scale(1.15); background: #fff; }
        .wishlist-btn.active .fa-heart { color: #f43f5e !important; }
        .wishlist-btn .fa-heart { transition: color 0.2s; }
        .wishlist-btn.loading { opacity: 0.6; pointer-events: none; }
    </style>

    {{-- jQuery (for cart AJAX) --}}
    <script src="{{ asset('assets/vendor/jquery-3.6.0.min.js') }}"></script>

    {{-- Mobile Nav --}}
    <script>
        document.getElementById('navToggle')?.addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // ——— Global Toast System ———
        function showToast(message, type = 'wishlist') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const icons = {
                wishlist: '<i class="fa-solid fa-heart toast-icon" style="color:#f43f5e"></i>',
                success:  '<i class="fa-solid fa-circle-check toast-icon" style="color:#22c55e"></i>',
                error:    '<i class="fa-solid fa-circle-xmark toast-icon" style="color:#ef4444"></i>',
            };
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = (icons[type] || icons.wishlist) + `<span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('toast-out');
                toast.addEventListener('animationend', () => toast.remove());
            }, 3200);
        }

        // ——— Global Wishlist AJAX Toggle ———
        function initWishlistButtons() {
            document.querySelectorAll('[data-wishlist-btn]').forEach(btn => {
                if (btn._wishlistBound) return;
                btn._wishlistBound = true;
                btn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    @auth
                        const productId = this.dataset.productId;
                        const url = `/wishlist/${productId}`;
                        this.classList.add('loading');
                        try {
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                            });
                            const data = await res.json();
                            const icon = this.querySelector('i.fa-heart');
                            if (data.wishlisted) {
                                icon.classList.remove('fa-regular');
                                icon.classList.add('fa-solid');
                                icon.style.color = '#f43f5e';
                                this.classList.add('active');
                            } else {
                                icon.classList.remove('fa-solid');
                                icon.classList.add('fa-regular');
                                icon.style.color = '';
                                this.classList.remove('active');
                                // If on wishlist page, remove the card
                                const card = this.closest('[data-wishlist-card]');
                                if (card) {
                                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                                    card.style.opacity = '0';
                                    card.style.transform = 'scale(0.92)';
                                    setTimeout(() => card.remove(), 320);
                                }
                            }
                            showToast(data.message, 'wishlist');
                        } catch(err) {
                            showToast('Terjadi kesalahan, coba lagi.', 'error');
                        } finally {
                            this.classList.remove('loading');
                        }
                    @else
                        window.location.href = '{{ route("login") }}';
                    @endauth
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initWishlistButtons);
    </script>

    @stack('scripts')
</body>
</html>
