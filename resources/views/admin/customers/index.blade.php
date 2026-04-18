@extends('layouts.admin')

@section('title', 'Daftar Pelanggan — Admin Ranti')
@section('page-title', 'Daftar Pelanggan')

@section('content')
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h3 style="font-family: var(--font-body); font-weight: 700; font-size: 20px;">Pelanggan Toko</h3>
        <p class="text-muted text-sm">Lihat aktivitas dan riwayat transaksi semua pembeli Anda.</p>
    </div>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Terdaftar Pada</th>
                <th>Total Pesanan</th>
                <th>Total Belanja</th>
                <th style="width: 100px; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--color-bg-warm); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted);">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span style="font-weight: 600; color: var(--color-text);">{{ $customer->name }}</span>
                    </div>
                </td>
                <td class="text-sm text-muted">{{ $customer->email }}</td>
                <td class="text-sm">{{ $customer->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge" style="background: var(--color-bg-warm);">{{ $customer->orders_count }} Pesanan</span>
                </td>
                <td style="font-weight: 700;">
                    Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}
                </td>
                <td style="text-align: right;">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-ghost btn-sm">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px 20px;" class="text-muted">
                    <i class="fa-solid fa-users" style="font-size: 32px; color: var(--color-border); margin-bottom: 12px; display: block;"></i>
                    Belum ada data pelanggan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($customers->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid var(--color-border-light);">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
