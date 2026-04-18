<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel — Ranti')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Design System --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .admin-layout {
            min-height: 100vh;
        }

        .admin-sidebar {
            background: var(--color-primary-dark);
            color: rgba(255,255,255,0.7);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .admin-sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .admin-sidebar-brand h3 {
            font-family: var(--font-display);
            color: #fff;
            font-size: 20px;
            margin: 0;
        }

        .admin-sidebar-brand span {
            font-size: 11px;
            color: var(--color-accent);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .admin-nav {
            list-style: none;
            padding: 16px 0;
        }

        .admin-nav li a, .admin-nav li button {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: all var(--transition);
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            font-family: var(--font-body);
        }

        .admin-nav li a:hover, .admin-nav li button:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }

        .admin-nav li a.active {
            color: #fff;
            background: rgba(196,162,101,0.15);
            border-left: 3px solid var(--color-accent);
        }

        .admin-nav li a i, .admin-nav li button i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .admin-nav-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 12px 0;
        }

        .admin-content {
            margin-left: 260px;
            background: var(--color-bg);
            min-height: 100vh;
        }

        .admin-topbar {
            background: var(--color-surface);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--color-border-light);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-topbar h2 {
            font-family: var(--font-body);
            font-size: 18px;
            font-weight: 700;
        }

        .admin-topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--color-text-secondary);
        }

        .admin-topbar-user i {
            font-size: 20px;
            color: var(--color-accent);
        }

        .admin-body {
            padding: 32px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            z-index: 95;
            transition: all var(--transition);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--color-text);
            cursor: pointer;
            padding: 8px;
            margin-right: 12px;
        }

        /* Stat Cards */
        .stat-card {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            padding: 28px;
            box-shadow: var(--shadow-sm);
        }

        .stat-card__icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .stat-card__label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--color-text-muted);
            margin-bottom: 6px;
        }

        .stat-card__value {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-text);
            font-family: var(--font-body);
        }

        /* Admin Table */
        .admin-table-wrapper {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            overflow-x: auto;
        }

        .admin-table-header {
            padding: 24px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--color-border-light);
        }

        .admin-table-header h3 {
            font-family: var(--font-body);
            font-size: 16px;
            font-weight: 700;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--color-text-muted);
            padding: 14px 20px;
            background: var(--color-bg-warm);
            border-bottom: 1px solid var(--color-border-light);
        }

        .admin-table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--color-border-light);
            font-size: 14px;
            vertical-align: middle;
        }

        .admin-table tr:last-child td { border-bottom: none; }

        .admin-table tr:hover td { background: var(--color-bg-warm); }

        .product-thumb {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-sm);
            object-fit: cover;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: var(--color-text-secondary);
            cursor: pointer;
            transition: all var(--transition);
        }

        .action-btn:hover {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
        }

        .action-btn.delete:hover {
            background: var(--color-danger);
            border-color: var(--color-danger);
        }

        /* Form Page */
        .form-card {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 36px;
        }

        .form-card h3 {
            font-family: var(--font-body);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--color-border-light);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 24px;
            border-top: 1px solid var(--color-border-light);
            margin-top: 12px;
        }

        .image-upload-area {
            border: 2px dashed var(--color-border);
            border-radius: var(--radius-md);
            padding: 40px 24px;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition);
            position: relative;
        }

        .image-upload-area:hover {
            border-color: var(--color-accent);
            background: rgba(196,162,101,0.03);
        }

        .image-upload-area i {
            font-size: 32px;
            color: var(--color-text-muted);
            margin-bottom: 12px;
        }

        .image-upload-area p {
            font-size: 14px;
            color: var(--color-text-secondary);
        }

        .image-upload-area .text-xs {
            color: var(--color-text-muted);
        }

        .image-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .image-preview {
            max-width: 200px;
            border-radius: var(--radius-md);
            margin-top: 12px;
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                left: -260px;
                transition: left 0.3s ease;
            }

            .admin-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .sidebar-open .admin-sidebar {
                left: 0;
            }

            .sidebar-open .sidebar-overlay {
                display: block;
            }

            .admin-body {
                padding: 24px 16px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .admin-topbar {
                padding: 16px 20px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-layout" id="adminLayout">
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
        {{-- Sidebar --}}
        <aside class="admin-sidebar">
            <div class="admin-sidebar-brand">
                <span>Admin Panel</span>
                <h3>Ranti</h3>
            </div>
            <ul class="admin-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box-open"></i> Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Pelanggan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket"></i> Kupon Diskon
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payment_methods.index') }}" class="{{ request()->routeIs('admin.payment_methods*') ? 'active' : '' }}">
                        <i class="fa-solid fa-wallet"></i> Opsi Pembayaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}" style="position: relative;">
                        <i class="fa-solid fa-receipt"></i> Pesanan
                        @php $needVerify = \App\Models\Order::where('status', 'payment_uploaded')->count(); @endphp
                        @if($needVerify > 0)
                            <span style="background: var(--color-danger); color: #fff; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; margin-left: auto;">{{ $needVerify }}</span>
                        @endif
                    </a>
                </li>
                <hr class="admin-nav-divider">
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa-solid fa-store"></i> Lihat Toko
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="color: rgba(255,100,100,0.7);">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        {{-- Main Content Area --}}
        <div class="admin-content">
            <div class="admin-topbar">
                <div style="display: flex; align-items: center;">
                    <button class="mobile-toggle" onclick="toggleSidebar()">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="admin-topbar-actions">
                    <div class="admin-topbar-user">
                        <i class="fa-solid fa-circle-user"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <div class="admin-body">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 24px;">
                        <i class="fa-solid fa-check-circle" style="margin-right: 8px;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery-3.6.0.min.js') }}"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminLayout').classList.toggle('sidebar-open');
        }
    </script>
    @stack('scripts')
</body>
</html>
