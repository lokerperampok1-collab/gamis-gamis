@extends('layouts.store')

@section('title', 'Keranjang Belanja — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Keranjang Belanja</h1>
        <p>{{ count($cart) }} item di keranjang Anda</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
        <div class="layout-split">
            {{-- Cart Items --}}
            <div>
                <div class="card">
                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align: center;">Harga</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th style="text-align: right;">Subtotal</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-md">
                                        <img src="{{ asset('assets/product/' . $details['image']) }}"
                                             alt="{{ $details['name'] }}"
                                             style="width: 72px; height: 90px; object-fit: cover; border-radius: var(--radius-sm); flex-shrink: 0;">
                                        <div>
                                            <h4 style="font-size: 15px; font-weight: 600; margin-bottom: 4px;">{{ $details['name'] }}</h4>
                                            <span class="text-xs text-muted uppercase">Ukuran: M</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center; font-size: 14px;">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </td>
                                <td style="text-align: center;">
                                    <div class="qty-selector" style="margin: 0 auto;">
                                        <button type="button" class="qty-down" data-id="{{ $id }}">−</button>
                                        <input type="number" value="{{ $details['quantity'] }}" min="1"
                                               class="update-cart" data-id="{{ $id }}">
                                        <button type="button" class="qty-up" data-id="{{ $id }}">+</button>
                                    </div>
                                </td>
                                <td style="text-align: right; font-weight: 700; font-size: 14px;">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </td>
                                <td style="text-align: center;">
                                    <button class="remove-from-cart" data-id="{{ $id }}"
                                            style="background: none; border: none; color: var(--color-text-muted); cursor: pointer; padding: 8px; transition: color 0.2s;">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="flex items-center gap-sm text-sm" style="color: var(--color-accent); font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="sticky-sidebar">
                <div class="card card-body" style="padding: 32px;">
                    <h3 class="font-display" style="font-size: 20px; margin-bottom: 24px;">Ringkasan Pesanan</h3>

                    <div class="info-row">
                        <span class="label">Subtotal</span>
                        <span class="value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @if($coupon)
                        <div class="info-row">
                            <span class="label" style="color: var(--color-success);">Diskon Kupon ({{ $coupon }})</span>
                            <span class="value" style="color: var(--color-success); font-weight: 600;">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="info-row">
                        <span class="label">Pengiriman</span>
                        <span class="value" style="color: var(--color-success); font-weight: 600;">Gratis</span>
                    </div>
                    <div class="info-row info-row-total">
                        <span class="label">Total</span>
                        <span class="value">Rp {{ number_format(max(0, $total - $discount), 0, ',', '.') }}</span>
                    </div>

                    <div style="margin: 24px 0; border-top: 1px solid var(--color-border-light); padding-top: 24px;">
                        @if($coupon)
                            <div style="display: flex; gap: 8px; align-items: center; justify-content: space-between; background: rgba(39, 174, 96, 0.1); padding: 12px; border-radius: var(--radius-sm);">
                                <div>
                                    <span style="font-weight: 600; color: var(--color-success); font-size: 14px;"><i class="fa-solid fa-check-circle"></i> Kupon digunakan</span>
                                </div>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger" style="background:none; border:none; cursor:pointer; font-size:12px; text-decoration:underline;">Hapus Kupon</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" style="display: flex; gap: 8px;">
                                @csrf
                                <input type="text" name="code" class="form-input" placeholder="Kode Promo" style="flex: 1;" required>
                                <button type="submit" class="btn btn-outline">Terapkan</button>
                            </form>
                            @if(session('error'))
                                <p class="text-danger text-xs mt-1">{{ session('error') }}</p>
                            @endif
                        @endif
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-block btn-lg mt-3">
                        Checkout Sekarang
                    </a>

                    <div class="text-center mt-3">
                        <p class="text-xs text-muted"><i class="fa-solid fa-lock" style="margin-right: 6px;"></i>Transaksi aman & terenkripsi</p>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- Empty Cart --}}
        <div class="card" style="max-width: 520px; margin: 0 auto; text-align: center; padding: 64px 32px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--color-border-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 32px; color: var(--color-text-muted);"></i>
            </div>
            <h2 class="font-display" style="font-size: 24px; margin-bottom: 12px;">Keranjang Kosong</h2>
            <p class="text-muted mb-4">Sepertinya Anda belum menambahkan produk apapun.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Mulai Belanja</a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(".update-cart").change(function(e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('cart.update') }}',
            method: "patch",
            data: { _token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.val() },
            success: function() { window.location.reload(); }
        });
    });

    $(".qty-down").click(function() {
        var input = $(this).siblings('input');
        var val = parseInt(input.val()) - 1;
        if (val >= 1) { input.val(val).trigger('change'); }
    });
    $(".qty-up").click(function() {
        var input = $(this).siblings('input');
        input.val(parseInt(input.val()) + 1).trigger('change');
    });

    $(".remove-from-cart").click(function(e) {
        e.preventDefault();
        if (confirm("Hapus produk ini dari keranjang?")) {
            $.ajax({
                url: '{{ route('cart.remove') }}',
                method: "DELETE",
                data: { _token: '{{ csrf_token() }}', id: $(this).attr("data-id") },
                success: function() { window.location.reload(); }
            });
        }
    });
</script>
@endpush
