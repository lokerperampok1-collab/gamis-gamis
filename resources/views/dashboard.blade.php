@extends('layouts.store')

@section('title', 'Dashboard — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Akun Saya</h1>
        <p>Selamat datang kembali, {{ auth()->user()->name }}</p>
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
                        <li><a href="{{ route('dashboard') }}" class="active"><i class="fa-solid fa-gauge-high"></i> Dashboard</a></li>
                        <li><a href="#"><i class="fa-solid fa-box-open"></i> Pesanan Saya</a></li>
                        <li><a href="{{ route('wishlist.index') }}"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
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
                {{-- Quick Actions --}}
                <div class="grid grid-2 mb-4">
                    <div class="card card-body" style="padding: 28px;">
                        <div class="flex items-center gap-md">
                            <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-truck-fast" style="font-size: 22px; color: var(--color-accent);"></i>
                            </div>
                            <div>
                                <h4 style="font-family: var(--font-body); font-size: 16px; font-weight: 700; margin-bottom: 4px;">Lacak Pesanan</h4>
                                <p class="text-sm text-muted" style="margin: 0;">Periksa status pengiriman Anda</p>
                            </div>
                        </div>
                        <a href="{{ url('/order-track') }}" class="btn btn-outline btn-sm mt-3" style="width: 100%;">Lacak Sekarang</a>
                    </div>

                    <div class="card card-body" style="padding: 28px;">
                        <div class="flex items-center gap-md">
                            <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-bag-shopping" style="font-size: 22px; color: var(--color-accent);"></i>
                            </div>
                            <div>
                                <h4 style="font-family: var(--font-body); font-size: 16px; font-weight: 700; margin-bottom: 4px;">Belanja Lagi</h4>
                                <p class="text-sm text-muted" style="margin: 0;">Jelajahi koleksi terbaru kami</p>
                            </div>
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm mt-3" style="width: 100%;">Lihat Koleksi</a>
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="card card-body" style="padding: 32px;">
                    <h3 class="font-display" style="font-size: 20px; margin-bottom: 24px;">Pesanan Terbaru</h3>

                    @php
                        $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->take(5)->get();
                    @endphp

                    @if($orders->count() > 0)
                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td style="font-weight: 700;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="text-sm">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-sm font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge badge-warning">Menunggu Bayar</span>
                                            @break
                                        @case('payment_uploaded')
                                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Menunggu Verifikasi</span>
                                            @break
                                        @case('processing')
                                            <span class="badge badge-success">Diproses</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Dikirim</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-success">Selesai</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge" style="background: rgba(239,68,68,0.12); color: #ef4444;">Dibatalkan</span>
                                            @break
                                        @default
                                            <span class="badge">{{ ucfirst($order->status) }}</span>
                                    @endswitch
                                </td>
                                <td style="text-align: right;">
                                    @if($order->status === 'pending')
                                        <a href="{{ route('payment.show', $order) }}" class="btn btn-primary btn-sm">Bayar</a>
                                    @else
                                        <a href="{{ route('order.success', $order) }}" class="btn btn-ghost btn-sm">Detail</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div style="text-align: center; padding: 48px 20px; background: var(--color-bg); border-radius: var(--radius-md);">
                        <i class="fa-solid fa-receipt" style="font-size: 36px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                        <p class="text-muted">Anda belum memiliki pesanan.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm mt-2">Mulai Belanja</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
