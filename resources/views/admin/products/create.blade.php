@extends('layouts.admin')

@section('title', 'Tambah Produk — Ranti Admin')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="form-card" style="max-width: 800px;">
    <h3><i class="fa-solid fa-plus-circle" style="color: var(--color-accent); margin-right: 8px;"></i> Informasi Produk</h3>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama Produk *</label>
            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="contoh: Izzy Dress Premium" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <select name="category_id" class="form-input @error('category_id') is-invalid @enderror" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Stok *</label>
                <input type="number" name="stock" class="form-input @error('stock') is-invalid @enderror"
                       value="{{ old('stock', 10) }}" min="0" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Harga Jual (Rp) *</label>
                <input type="number" name="price" class="form-input @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" min="0" step="1000" placeholder="contoh: 1499000" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Harga Asli / Coret (Rp)</label>
                <input type="number" name="original_price" class="form-input @error('original_price') is-invalid @enderror"
                       value="{{ old('original_price') }}" min="0" step="1000" placeholder="Kosongkan jika tidak ada diskon">
                @error('original_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi *</label>
            <textarea name="description" class="form-input @error('description') is-invalid @enderror"
                      rows="4" placeholder="Deskripsi singkat tentang produk..." required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Produk *</label>
            <div class="image-upload-area" id="uploadArea">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>Klik atau seret gambar ke sini</p>
                <div class="text-xs mt-1">JPEG, PNG, WebP • Maks 5MB</div>
                <input type="file" name="image" id="imageInput" accept="image/*" required>
            </div>
            <img id="imagePreview" class="image-preview" style="display: none;" alt="Preview">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.products') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-check"></i> Simpan Produk
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection
