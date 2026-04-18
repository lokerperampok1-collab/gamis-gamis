@extends('layouts.admin')

@section('title', 'Edit Produk — Ranti Admin')
@section('page-title', 'Edit Produk')

@section('content')
<div class="form-card" style="max-width: 800px;">
    <h3><i class="fa-solid fa-pen-to-square" style="color: var(--color-accent); margin-right: 8px;"></i> Edit: {{ $product->name }}</h3>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Produk *</label>
            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                   value="{{ old('name', $product->name) }}" required>
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
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                       value="{{ old('stock', $product->stock) }}" min="0" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Harga Jual (Rp) *</label>
                <input type="number" name="price" class="form-input @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Harga Asli / Coret (Rp)</label>
                <input type="number" name="original_price" class="form-input @error('original_price') is-invalid @enderror"
                       value="{{ old('original_price', $product->original_price) }}" min="0" step="1000">
                @error('original_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi *</label>
            <textarea name="description" class="form-input @error('description') is-invalid @enderror"
                      rows="4" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Produk</label>
            <div style="margin-bottom: 12px;">
                <p class="text-sm text-muted" style="margin-bottom: 8px;">Gambar saat ini:</p>
                <img src="{{ asset('assets/product/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     style="width: 120px; height: 120px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--color-border);"
                     onerror="this.src='https://placehold.co/120x120/e8e4df/9ca3af?text=No+Img'">
            </div>
            <div class="image-upload-area" id="uploadArea">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>Upload gambar baru (opsional)</p>
                <div class="text-xs mt-1">JPEG, PNG, WebP • Maks 5MB</div>
                <input type="file" name="image" id="imageInput" accept="image/*">
            </div>
            <img id="imagePreview" class="image-preview" style="display: none;" alt="Preview">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.products') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-check"></i> Simpan Perubahan
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
