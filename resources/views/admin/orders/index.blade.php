@extends('layouts.admin')

@section('title', 'Kelola Pesanan — Ranti Admin')
@section('page-title', 'Kelola Pesanan')

@section('content')
{{-- Status Filter --}}
<div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap;">
    <a href="{{ route('admin.orders') }}"
       class="btn {{ !request('status') ? 'btn-primary' : 'btn-ghost' }} btn-sm">Semua</a>
    <a href="{{ route('admin.orders', ['status' => 'pending']) }}"
       class="btn {{ request('status') === 'pending' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Menunggu Bayar</a>
    <a href="{{ route('admin.orders', ['status' => 'payment_uploaded']) }}"
       class="btn {{ request('status') === 'payment_uploaded' ? 'btn-primary' : 'btn-ghost' }} btn-sm">
       Perlu Verifikasi
       @php $pendingCount = \App\Models\Order::where('status', 'payment_uploaded')->count(); @endphp
       @if($pendingCount > 0)
           <span style="background: var(--color-danger); color: #fff; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; margin-left: 4px;">{{ $pendingCount }}</span>
       @endif
    </a>
    <a href="{{ route('admin.orders', ['status' => 'processing']) }}"
       class="btn {{ request('status') === 'processing' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Diproses</a>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h3><i class="fa-solid fa-receipt" style="color: var(--color-accent); margin-right: 8px;"></i> Daftar Pesanan ({{ $orders->total() }})</h3>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight: 700;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div style="font-weight: 600;">{{ $order->first_name }} {{ $order->last_name }}</div>
                    <div class="text-xs text-muted">{{ $order->email }}</div>
                </td>
                <td class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>
                    @if($order->payment_proof)
                        <span class="badge badge-success" style="font-size: 11px;">
                            <i class="fa-solid fa-image" style="margin-right: 4px;"></i> Uploaded
                        </span>
                    @else
                        <span class="text-xs text-muted">Belum upload</span>
                    @endif
                </td>
                <td>
                    @switch($order->status)
                        @case('pending')
                            <span class="badge badge-warning">Menunggu</span>
                            @break
                        @case('payment_uploaded')
                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Perlu Verifikasi</span>
                            @break
                        @case('processing')
                            <span class="badge badge-success">Diproses</span>
                            @break
                        @default
                            <span class="badge">{{ ucfirst($order->status) }}</span>
                    @endswitch
                </td>
                <td class="text-sm text-muted">{{ $order->created_at->format('d M Y') }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="Detail">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 48px;">
                    <i class="fa-solid fa-inbox" style="font-size: 36px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                    <p class="text-muted">Belum ada pesanan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
<div style="padding: 24px 0;">
    {{ $orders->links() }}
</div>
@endif
@endsection
