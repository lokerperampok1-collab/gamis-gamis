@extends('layouts.store')

@section('title', 'Checkout — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Checkout</h1>
        <p>Satu langkah lagi menuju koleksi impian Anda</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="layout-split" style="grid-template-columns: 1fr 440px;">
                {{-- Shipping Details --}}
                <div>
                    <div class="card card-body" style="padding: 40px;">
                        <h3 class="font-display" style="font-size: 22px; margin-bottom: 32px;">Detail Pengiriman</h3>

                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label">Nama Depan</label>
                                <input type="text" class="form-input" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Belakang</label>
                                <input type="text" class="form-input" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" name="email"
                                   value="{{ auth()->user()->email ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-input" name="phone" placeholder="0812xxxx" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-input" name="address" rows="3"
                                      placeholder="Nama jalan, gedung, no rumah..." required></textarea>
                        </div>

                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-input" name="city" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-input" name="zip" required>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div style="margin-top: 16px;">
                            <h4 style="font-family: var(--font-body); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--color-text-muted); margin-bottom: 16px;">Metode Pembayaran</h4>
                            <div class="radio-group">
                                @forelse($paymentMethods as $index => $method)
                                <label class="radio-option {{ $index === 0 ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="{{ $method->name }}" {{ $index === 0 ? 'checked' : '' }}>
                                    <div>
                                        <strong style="font-size: 14px;">{{ $method->name }}</strong>
                                        <p class="text-xs text-muted" style="margin: 2px 0 0;">{{ $method->type === 'bank' ? 'Transfer Bank' : 'E-Wallet' }}</p>
                                    </div>
                                </label>
                                @empty
                                <div class="alert alert-warning">Belum ada metode pembayaran yang dikonfigurasi. Hubungi Admin.</div>
                                <input type="hidden" name="payment_method" value="bank_transfer">
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="sticky-sidebar">
                    <div class="card card-body" style="padding: 32px;">
                        <h3 class="font-display" style="font-size: 20px; margin-bottom: 24px;">Ringkasan Pesanan</h3>

                        <div style="margin-bottom: 20px;">
                            @foreach($cart as $id => $details)
                            <div class="flex items-center gap-md" style="margin-bottom: 16px;">
                                <div style="position: relative; flex-shrink: 0;">
                                    <img src="{{ asset('assets/product/' . $details['image']) }}"
                                         alt="{{ $details['name'] }}"
                                         style="width: 56px; height: 68px; object-fit: cover; border-radius: var(--radius-sm);">
                                    <span style="position: absolute; top: -6px; right: -6px; background: var(--color-primary); color: #fff; font-size: 10px; font-weight: 700; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">{{ $details['quantity'] }}</span>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <p style="font-weight: 600; font-size: 14px; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $details['name'] }}</p>
                                    <span class="text-xs text-muted">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                </div>
                                <span style="font-weight: 700; font-size: 14px; flex-shrink: 0;">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </span>
                            </div>
                            @endforeach
                        </div>

                        <div class="info-row">
                            <span class="label">Subtotal</span>
                            <span class="value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="info-row">
                            <span class="label" style="color: var(--color-success);">Diskon Promo</span>
                            <span class="value" style="color: var(--color-success);">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="label">Pengiriman</span>
                            <span class="value" style="color: var(--color-success);">Gratis</span>
                        </div>
                        <div class="info-row info-row-total">
                            <span class="label">Total</span>
                            <span class="value">Rp {{ number_format(max(0, $total - $discount), 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                            <i class="fa-solid fa-lock" style="font-size: 14px;"></i> Buat Pesanan
                        </button>

                        <p class="text-xs text-muted text-center mt-2">
                            Dengan memesan, Anda menyetujui syarat & ketentuan kami.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.radio-option').forEach(opt => {
        opt.addEventListener('click', function() {
            document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
</script>
@endpush
