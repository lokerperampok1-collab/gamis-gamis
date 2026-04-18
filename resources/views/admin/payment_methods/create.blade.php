@extends('layouts.admin')

@section('title', 'Tambah Metode Pembayaran — Admin Ranti')
@section('page-title', 'Tambah Metode Pembayaran')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card" style="max-width: 600px;">
    <form action="{{ route('admin.payment_methods.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Nama Bank / Dompet Digital</label>
            <input type="text" name="name" class="form-input" placeholder="Contoh: BCA, Mandiri, GoPay" value="{{ old('name') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group" style="flex: 1;">
                <label class="form-label">Tipe Pembayaran</label>
                <select name="type" class="form-input" required>
                    <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="e_wallet" {{ old('type') == 'e_wallet' ? 'selected' : '' }}>E-Wallet / Dompet Digital</option>
                </select>
            </div>
            <div class="form-group" style="flex: 1;">
                <label class="form-label">Nomor Rekening / HP</label>
                <input type="text" name="account_number" class="form-input" placeholder="Contoh: 1234567890" value="{{ old('account_number') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Atas Nama (Pemilik Rekening)</label>
            <input type="text" name="account_name" class="form-input" placeholder="Contoh: PT Ranti Exclusive" value="{{ old('account_name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Instruksi Khusus (Opsional)</label>
            <textarea name="instructions" class="form-input" rows="3" placeholder="Instruksi tambahan jika ada...">{{ old('instructions') }}</textarea>
        </div>

        <div class="form-group" style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--color-border-light);">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                <span class="font-bold">Aktifkan Metode Ini</span>
            </label>
            <p class="text-xs text-muted" style="margin-left: 26px; margin-top: 4px;">Metode pembayaran yang aktif akan ditampilkan pada opsi checkout pelanggan.</p>
        </div>

        <div style="margin-top: 32px; text-align: right;">
            <button type="submit" class="btn btn-primary">Simpan Metode Pembayaran</button>
        </div>
    </form>
</div>
@endsection
