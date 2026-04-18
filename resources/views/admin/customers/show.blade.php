@extends('layouts.admin')

@section('title', 'Detail Pelanggan — Admin Ranti')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pelanggan
    </a>
</div>

<div class="form-row">
    {{-- Customer Profile Card --}}
    <div class="form-card" style="align-self: flex-start;">
        <div style="text-align: center; padding-bottom: 24px; border-bottom: 1px solid var(--color-border-light); margin-bottom: 24px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--color-bg-warm); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="fa-solid fa-user" style="font-size: 32px; color: var(--color-text-muted);"></i>
            </div>
            <h3 style="font-size: 20px; margin-bottom: 4px;">{{ $customer->name }}</h3>
            <span class="badge badge-success">Pelanggan Terdaftar</span>
        </div>
        
        <h4 style="font-size: 14px; text-transform: uppercase; color: var(--color-text-muted); letter-spacing: 1px; margin-bottom: 16px;">Informasi Kontak</h4>
        
        <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px;">
            <div>
                <span class="text-xs text-muted block mb-1">Alamat Email</span>
                <span style="font-weight: 500; font-size: 14px;">
                    <i class="fa-regular fa-envelope" style="color: var(--color-accent); margin-right: 6px;"></i> 
                    {{ $customer->email }}
                </span>
            </div>
            <div>
                <span class="text-xs text-muted block mb-1">Tanggal Bergabung</span>
                <span style="font-weight: 500; font-size: 14px;">
                    <i class="fa-regular fa-calendar" style="color: var(--color-accent); margin-right: 6px;"></i> 
                    {{ $customer->created_at->format('d F Y') }}
                </span>
            </div>
        </div>

        <div style="background: rgba(196,162,101,0.05); border: 1.5px solid rgba(196,162,101,0.2); padding: 20px; border-radius: var(--radius-md); text-align: center;">
            <span class="text-sm text-muted block mb-2">Total Nilai Belanja (Sepanjang Waktu)</span>
            <span style="font-size: 28px; font-weight: 700; color: var(--color-primary);">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Customer Order History --}}
    <div class="admin-table-wrapper" style="flex: 1;">
        <div class="admin-table-header">
            <h3>Riwayat Pesanan Pelanggan ({{ $orders->total() }})</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-weight: 700;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-sm">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge badge-warning">Menunggu</span>
                                @break
                            @case('payment_uploaded')
                                <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Verifikasi</span>
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
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px 20px;" class="text-muted">
                        <i class="fa-solid fa-receipt" style="font-size: 32px; color: var(--color-border); margin-bottom: 12px; display: block;"></i>
                        Pelanggan ini belum pernah melakukan pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($orders->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--color-border-light);">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
