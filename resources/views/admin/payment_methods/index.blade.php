@extends('layouts.admin')

@section('title', 'Metode Pembayaran — Admin Ranti')
@section('page-title', 'Metode Pembayaran')

@section('content')
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h3 style="font-family: var(--font-body); font-weight: 700; font-size: 20px;">Daftar Rekening & Opsi Pembayaran</h3>
        <p class="text-muted text-sm">Kelola tujuan transfer bank atau E-Wallet untuk pelanggan bayar.</p>
    </div>
    <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Metode
    </a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama / Bank</th>
                <th>Nomor Rekening</th>
                <th>Atas Nama</th>
                <th>Tipe</th>
                <th>Status</th>
                <th style="width: 150px; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($methods as $method)
            <tr>
                <td style="font-weight: 600;">{{ $method->name }}</td>
                <td>{{ $method->account_number }}</td>
                <td class="text-muted">{{ $method->account_name }}</td>
                <td>
                    <span class="badge" style="background: var(--color-bg-warm);">{{ $method->type === 'bank' ? 'Transfer Bank' : 'E-Wallet' }}</span>
                </td>
                <td>
                    @if($method->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="{{ route('admin.payment_methods.edit', $method) }}" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.payment_methods.destroy', $method) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline btn-sm text-danger" style="border-color: var(--color-danger);">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px 20px;" class="text-muted">
                    <i class="fa-solid fa-building-columns" style="font-size: 32px; color: var(--color-border); margin-bottom: 12px; display: block;"></i>
                    Belum ada metode pembayaran yang ditambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
