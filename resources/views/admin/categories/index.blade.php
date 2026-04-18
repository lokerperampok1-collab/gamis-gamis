@extends('layouts.admin')

@section('title', 'Kategori Produk — Admin Ranti')
@section('page-title', 'Kategori Produk')

@section('content')
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h3 style="font-family: var(--font-body); font-weight: 700; font-size: 20px;">Daftar Kategori</h3>
        <p class="text-muted text-sm">Kelola kategori produk yang ditampilkan di toko.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Jumlah Produk</th>
                <th style="width: 120px; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td style="font-weight: 600;">{{ $category->name }}</td>
                <td class="text-sm text-muted">{{ $category->slug }}</td>
                <td><span class="badge" style="background: var(--color-bg-warm);">{{ $category->products_count }} Produk</span></td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn" title="Edit Kategori">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Hapus Kategori">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px 20px;" class="text-muted">
                    <i class="fa-solid fa-layer-group" style="font-size: 32px; color: var(--color-border); margin-bottom: 12px; display: block;"></i>
                    Belum ada kategori yang ditambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($categories->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid var(--color-border-light);">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
