@extends('layouts.store')

@section('title', 'Pesanan Berhasil — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg);">
    <div class="container" style="max-width: 640px;">
        <div class="card" style="text-align: center; padding: 56px 40px;">
            <div class="success-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <h1 class="font-display" style="font-size: 30px; margin-bottom: 12px;">Pesanan Berhasil!</h1>
            <p class="text-muted" style="max-width: 420px; margin: 0 auto 32px;">
                Terima kasih atas pesanan Anda. Kami akan segera memprosesnya setelah konfirmasi pembayaran diterima.
            </p>

            {{-- Order Details --}}
            <div style="background: var(--color-bg); border-radius: var(--radius-md); padding: 28px; text-align: left; margin-bottom: 32px;">
                <div class="info-row">
                    <span class="label">Nomor Pesanan</span>
                    <span class="value font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total Pembayaran</span>
                    <span class="value" style="color: var(--color-primary); font-weight: 700;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Status</span>
                    @switch($order->status)
                        @case('pending')
                            <span class="badge badge-warning">Menunggu Pembayaran</span>
                            @break
                        @case('payment_uploaded')
                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Menunggu Verifikasi</span>
                            @break
                        @case('processing')
                            <span class="badge badge-success">Sedang Diproses</span>
                            @break
                        @case('shipped')
                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Sedang Dikirim</span>
                            @break
                        @case('completed')
                            <span class="badge badge-success">Selesai</span>
                            @break
                        @case('cancelled')
                            <span class="badge" style="background: rgba(239,68,68,0.12); color: #ef4444;">Dibatalkan</span>
                            @break
                        @default
                            <span class="badge">{{ ucfirst($order->status) }}</span>
                    @endswitch
                </div>
                @if($order->tracking_number)
                <div class="info-row">
                    <span class="label">Nomor Resi</span>
                    <span class="value" style="font-weight: 700; color: #3b82f6;">{{ $order->tracking_number }}</span>
                </div>
                @endif
            </div>

            {{-- Products in this Order --}}
            <div style="background: var(--color-bg); border-radius: var(--radius-md); padding: 28px; text-align: left; margin-bottom: 32px;">
                <h3 class="font-display" style="font-size: 18px; margin-bottom: 16px;">Produk yang Dibeli</h3>
                @foreach($order->items as $item)
                <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--color-border-light); padding-bottom: 16px;">
                    <img src="{{ asset('assets/product/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 60px; height: 75px; object-fit: cover; border-radius: var(--radius-sm);">
                    <div style="flex: 1;">
                        <h4 style="font-weight: 600; font-size: 15px; margin-bottom: 4px;">{{ $item->product->name }}</h4>
                        <p class="text-sm text-muted mb-2">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        
                        @if($order->status === 'completed')
                            @php
                                $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                    ->where('order_id', $order->id)
                                    ->where('product_id', $item->product_id)
                                    ->first();
                            @endphp
                            
                            @if($existingReview)
                                <div style="background: rgba(39, 174, 96, 0.05); padding: 12px; border-radius: var(--radius-sm); border-left: 3px solid var(--color-success);">
                                    <div style="color: #f59e0b; font-size: 12px; margin-bottom: 4px;">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-{{ $i <= $existingReview->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="text-sm" style="margin:0;">{{ $existingReview->comment }}</p>
                                </div>
                            @else
                                <div style="margin-top: 12px; border: 1px solid var(--color-border); padding: 16px; border-radius: var(--radius-sm);">
                                    <h5 style="font-size: 13px; font-weight: 700; margin-bottom: 8px;">Tulis Ulasan Anda</h5>
                                    <form action="{{ route('reviews.store', ['order' => $order->id, 'product' => $item->product_id]) }}" method="POST">
                                        @csrf
                                        <div style="margin-bottom: 8px;">
                                            <select name="rating" class="form-control" style="padding: 6px; font-size: 13px;" required>
                                                <option value="">Pilih Rating...</option>
                                                <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus</option>
                                                <option value="4">⭐⭐⭐⭐ Bagus</option>
                                                <option value="3">⭐⭐⭐ Lumayan</option>
                                                <option value="2">⭐⭐ Kurang</option>
                                                <option value="1">⭐ Sangat Kurang</option>
                                            </select>
                                        </div>
                                        <div style="margin-bottom: 8px;">
                                            <textarea name="comment" class="form-control" rows="2" placeholder="Bagaimana kualitas produk ini?" style="font-size: 13px; padding: 8px;" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Kirim Ulasan</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Payment Instructions (Only show if still pending) --}}
            @if($order->status === 'pending')
            <div style="text-align: left; margin-bottom: 32px;">
                <h3 class="font-display" style="font-size: 18px; margin-bottom: 16px; text-align: center;">Instruksi Pembayaran</h3>
                @if($paymentMethodDetails)
                    <p class="text-sm text-muted text-center mb-3">Silakan lakukan pembayaran sejumlah <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                    <div style="border: 1.5px solid var(--color-border); border-radius: var(--radius-md); padding: 24px; text-align: center; max-width: 400px; margin: 0 auto;">
                        <p class="text-sm text-muted uppercase font-bold mb-2">{{ $paymentMethodDetails->name }}</p>
                        <p style="font-size: 24px; font-weight: 700; color: var(--color-primary); margin-bottom: 8px;">{{ $paymentMethodDetails->account_number }}</p>
                        <p class="text-sm mb-4">a.n. <strong>{{ $paymentMethodDetails->account_name }}</strong></p>
                        
                        @if($paymentMethodDetails->instructions)
                            <div class="text-xs text-muted" style="background: var(--color-bg-warm); padding: 12px; border-radius: var(--radius-sm); text-align: left;">
                                {!! nl2br(e($paymentMethodDetails->instructions)) !!}
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-muted text-center">Menunggu informasi pembayaran...</p>
                @endif
            </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 24px;">
                    <i class="fa-solid fa-check-circle" style="margin-right: 8px;"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex justify-center gap-md flex-wrap">
                <a href="{{ url('/') }}" class="btn btn-outline">Kembali ke Beranda</a>
                @if($order->status === 'pending')
                    <a href="{{ route('payment.show', $order) }}" class="btn btn-primary">
                        <i class="fa-solid fa-credit-card"></i> Konfirmasi Pembayaran
                    </a>
                @elseif($order->status === 'payment_uploaded')
                    <span class="btn btn-ghost" style="pointer-events: none; opacity: 0.7;">
                        <i class="fa-solid fa-clock"></i> Menunggu Verifikasi Admin
                    </span>
                @else
                    <a href="{{ url('/order-track') }}" class="btn btn-primary">Lacak Pesanan</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
