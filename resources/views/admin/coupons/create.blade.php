@extends('layouts.admin')

@section('title', 'Tambah Kupon — Admin Ranti')
@section('page-title', 'Tambah Kupon')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kupon
    </a>
</div>

<div class="form-card" style="max-width: 800px;">
    <h3>Informasi Kupon</h3>
    
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="form-row mb-4">
            <div class="form-group">
                <label class="form-label" for="code">Kode Kupon <span class="text-danger">*</span></label>
                <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required placeholder="Contoh: PROMOMEI">
                @error('code')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-muted text-xs mt-1">Harus unik dan tanpa spasi.</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="type">Tipe Potongan <span class="text-danger">*</span></label>
                <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                </select>
                @error('type')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-row mb-4">
            <div class="form-group">
                <label class="form-label" for="value">Nilai Potongan <span class="text-danger">*</span></label>
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required placeholder="Contoh: 10 atau 50000" min="0" step="0.01">
                @error('value')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="min_spend">Minimal Belanja (Opsional)</label>
                <input type="number" id="min_spend" name="min_spend" class="form-control @error('min_spend') is-invalid @enderror" value="{{ old('min_spend') }}" placeholder="Contoh: 150000" min="0">
                @error('min_spend')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-row mb-4">
            <div class="form-group">
                <label class="form-label" for="expires_at">Diperbarui Waktu Kadaluarsa (Opsional)</label>
                <input type="date" id="expires_at" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                @error('expires_at')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="usage_limit">Batas Kuota Kupon (Opsional)</label>
                <input type="number" id="usage_limit" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}" placeholder="Contoh: 100" min="1">
                @error('usage_limit')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-actions mt-4">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Kupon</button>
        </div>
    </form>
</div>
@endsection
