@extends('layouts.store')

@section('title', 'Konfirmasi Pembayaran — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Konfirmasi Pembayaran</h1>
        <p>Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container" style="max-width: 720px;">

        {{-- Payment Info Card --}}
        <div class="card" style="padding: 36px; margin-bottom: 28px;">
            <h3 class="font-display" style="font-size: 20px; margin-bottom: 20px;">
                <i class="fa-solid fa-wallet" style="color: var(--color-accent); margin-right: 8px;"></i>
                Detail Pesanan
            </h3>
            <div style="background: var(--color-bg); border-radius: var(--radius-md); padding: 24px;">
                <div class="info-row">
                    <span class="label">Nomor Pesanan</span>
                    <span class="value font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total Pembayaran</span>
                    <span class="value" style="color: var(--color-primary); font-weight: 700; font-size: 20px;">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
            </div>
        </div>

        {{-- Bank Info --}}
        <div class="card" style="padding: 36px; margin-bottom: 28px;">
            <h3 class="font-display" style="font-size: 20px; margin-bottom: 20px;">
                <i class="fa-solid fa-building-columns" style="color: var(--color-accent); margin-right: 8px;"></i>
                Transfer ke Rekening
            </h3>
            <div class="grid @if($paymentMethods->count() > 1) grid-2 @endif" style="gap: 16px;">
                @foreach($paymentMethods as $method)
                <div style="border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); padding: 24px; text-align: center;">
                    <p class="text-xs text-muted uppercase font-bold mb-1">{{ $method->name }}</p>
                    <p style="font-size: 20px; font-weight: 700; margin-bottom: 4px; letter-spacing: 1px;">{{ $method->account_number }}</p>
                    <p class="text-xs text-muted">a.n. {{ $method->account_name }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="card" style="padding: 36px;">
            <h3 class="font-display" style="font-size: 20px; margin-bottom: 8px;">
                <i class="fa-solid fa-cloud-arrow-up" style="color: var(--color-accent); margin-right: 8px;"></i>
                Upload Bukti Transfer
            </h3>
            <p class="text-sm text-muted" style="margin-bottom: 24px;">
                Unggah screenshot atau foto bukti transfer Anda untuk mempercepat proses verifikasi.
            </p>

            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <i class="fa-solid fa-exclamation-circle" style="margin-right: 8px;"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('payment.store', $order) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <div style="border: 2px dashed var(--color-border); border-radius: var(--radius-md); padding: 48px 24px; text-align: center; cursor: pointer; transition: all 0.3s ease; position: relative;" id="uploadArea">
                        <i class="fa-solid fa-image" style="font-size: 40px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                        <p style="font-size: 16px; font-weight: 600; margin-bottom: 4px;">Klik untuk memilih gambar</p>
                        <p class="text-sm text-muted">JPG, PNG, atau WebP • Maksimal 5MB</p>
                        <input type="file" name="payment_proof" id="proofInput" accept="image/*" required
                               style="position: absolute; inset: 0; opacity: 0; cursor: pointer;">
                    </div>
                    <img id="proofPreview" style="display: none; max-width: 100%; max-height: 300px; margin-top: 16px; border-radius: var(--radius-md); border: 1px solid var(--color-border);" alt="Preview">
                </div>

                <div style="display: flex; justify-content: center; padding-top: 20px; border-top: 1px solid var(--color-border-light); margin-top: 8px;">
                    <button type="submit" class="btn btn-primary btn-lg" style="min-width: 240px;">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const input = document.getElementById('proofInput');
    const preview = document.getElementById('proofPreview');
    const area = document.getElementById('uploadArea');
    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                area.style.borderColor = 'var(--color-accent)';
                area.style.background = 'rgba(196,162,101,0.03)';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection
