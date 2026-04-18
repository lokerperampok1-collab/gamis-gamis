@extends('layouts.admin')

@section('title', 'Tambah Kategori — Admin Ranti')
@section('page-title', 'Tambah Kategori')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kategori
    </a>
</div>

<div class="form-card" style="max-width: 600px;">
    <h3>Informasi Kategori</h3>
    
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group mb-4">
            <label class="form-label" for="name">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Dress, Hijab, Atasan">
            @error('name')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-muted text-xs mt-1">Slug akan otomatis di-generate berdasarkan nama kategori.</p>
        </div>

        <div class="form-actions mt-4">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection
