@extends('layouts.admin')

@section('title', 'Kupon Diskon — Admin Ranti')
@section('page-title', 'Kupon Diskon')

@section('content')
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h3 style="font-family: var(--font-body); font-weight: 700; font-size: 20px;">Daftar Kupon</h3>
        <p class="text-muted text-sm">Kelola potongan harga dan kode promosi toko.</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Kupon
    </a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Kode Kupon</th>
                <th>Tipe & Nilai</th>
                <th>Min. Belanja</th>
                <th>Batas Waktu</th>
                <th>Pemakaian</th>
                <th style="width: 120px; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr>
                <td style="font-weight: 700;">{{ $coupon->code }}</td>
                <td>
                    <div style="font-weight: 600;">{{ $coupon->type == 'fixed' ? 'Nominal' : 'Persentase' }}</div>
                    <span class="text-sm text-muted">
                        {{ $coupon->type == 'fixed' ? 'Rp ' . number_format($coupon->value, 0, ',', '.') : $coupon->value . '%' }}
                    </span>
                </td>
                <td class="text-sm">{{ $coupon->min_spend ? 'Rp ' . number_format($coupon->min_spend, 0, ',', '.') : '-' }}</td>
                <td>
                    @if($coupon->expires_at)
                        <span class="badge {{ $coupon->expires_at->isPast() ? 'badge-danger' : 'badge-warning' }}">
                            {{ $coupon->expires_at->format('d M Y') }}
                        </span>
                    @else
                        <span class="text-muted text-sm">Tanpa Batas</span>
                    @endif
                </td>
                <td class="text-sm">
                    {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="action-btn" title="Edit Kupon">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kupon ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Hapus Kupon">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px 20px;" class="text-muted">
                    <i class="fa-solid fa-ticket" style="font-size: 32px; color: var(--color-border); margin-bottom: 12px; display: block;"></i>
                    Belum ada kupon diskon yang ditambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($coupons->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid var(--color-border-light);">
        {{ $coupons->links() }}
    </div>
    @endif
</div>
@endsection
