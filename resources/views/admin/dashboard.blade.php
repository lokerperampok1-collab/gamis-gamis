@extends('layouts.admin')

@section('title', 'Admin Dashboard — Ranti')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-3" style="margin-bottom: 32px;">
    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(196,162,101,0.12); color: var(--color-accent);">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <div class="stat-card__label">Total Produk</div>
        <div class="stat-card__value">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(39,174,96,0.12); color: var(--color-success);">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <div class="stat-card__label">Total Pesanan</div>
        <div class="stat-card__value">{{ $totalOrders }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(26,58,42,0.12); color: var(--color-primary);">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <div class="stat-card__label">Total Pendapatan</div>
        <div class="stat-card__value" style="font-size: 22px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h3><i class="fa-solid fa-clock-rotate-left" style="color: var(--color-accent); margin-right: 8px;"></i> Pesanan Terbaru</h3>
    </div>

    @if($recentOrders->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td style="font-weight: 700;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->first_name ?? '-' }} {{ $order->last_name ?? '' }}</td>
                <td class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td><span class="badge badge-warning">{{ ucfirst($order->status) }}</span></td>
                <td class="text-sm text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 48px 20px;">
        <i class="fa-solid fa-inbox" style="font-size: 36px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
        <p class="text-muted">Belum ada pesanan.</p>
    </div>
    @endif
</div>
@endsection
