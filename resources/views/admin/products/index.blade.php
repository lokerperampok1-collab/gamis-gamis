@extends('layouts.admin')

@section('title', 'Kelola Produk — Ranti Admin')
@section('page-title', 'Kelola Produk')

@section('content')
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h3><i class="fa-solid fa-box-open" style="color: var(--color-accent); margin-right: 8px;"></i> Daftar Produk ({{ $products->total() }})</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 60px;">Foto</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="width: 100px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('assets/product/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="product-thumb"
                         onerror="this.src='https://placehold.co/52x52/e8e4df/9ca3af?text=No+Img'">
                </td>
                <td>
                    <div style="font-weight: 600;">{{ $product->name }}</div>
                    <div class="text-xs text-muted">{{ Str::limit($product->description, 50) }}</div>
                </td>
                <td>
                    <span class="badge badge-category">{{ $product->category->name ?? '-' }}</span>
                </td>
                <td>
                    <div style="font-weight: 700;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    @if($product->original_price)
                        <div class="text-xs text-muted" style="text-decoration: line-through;">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </div>
                    @endif
                </td>
                <td>
                    @if($product->stock > 5)
                        <span class="badge badge-success">{{ $product->stock }}</span>
                    @elseif($product->stock > 0)
                        <span class="badge badge-warning">{{ $product->stock }}</span>
                    @else
                        <span class="badge badge-sale">Habis</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <div class="flex gap-sm justify-center">
                        <a href="{{ route('admin.products.edit', $product) }}" class="action-btn" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.delete', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 48px;">
                    <i class="fa-solid fa-box-open" style="font-size: 36px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                    <p class="text-muted">Belum ada produk. Mulai tambah produk pertama Anda!</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div style="padding: 24px 0;">
    {{ $products->links() }}
</div>
@endif
@endsection
