@extends('layouts.admin')

@section('title', 'Edit Kategori — Admin Ranti')
@section('page-title', 'Edit Kategori')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kategori
    </a>
</div>

<div class="form-card" style="max-width: 600px;">
    <h3>Informasi Kategori</h3>
    
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-4">
            <label class="form-label" for="name">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group mb-4">
            <label class="form-label">Slug Saat Ini</label>
            <input type="text" class="form-control" value="{{ $category->slug }}" disabled style="background-color: var(--color-bg-warm); cursor: not-allowed;">
            <p class="text-muted text-xs mt-1">Slug otomatis dibuat berdasarkan sistem dan tidak dapat diubah manual untuk menjaga integritas link URL.</p>
        </div>

        <div class="form-actions mt-4">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
