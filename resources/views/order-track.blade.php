@extends('layouts.store')

@section('title', 'Lacak Pesanan — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Lacak Pesanan</h1>
        <p>Masukkan detail pesanan Anda untuk melihat status terkini</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container" style="max-width: 560px;">
        <div class="card card-body" style="padding: 40px;">
            @if(!$searched || ($searched && !$order))
                <div style="text-align: center; margin-bottom: 32px;">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 24px; color: var(--color-accent);"></i>
                    </div>
                    @if($searched && !$order)
                        <div class="alert alert-danger" style="margin-bottom: 24px; padding: 12px; border-radius: 8px; font-size: 14px;">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>
                            Maaf, pesanan tidak ditemukan. Pastikan ID Pesanan dan Email sudah benar.
                        </div>
                    @endif
                </div>

                <form action="{{ route('order-track') }}" method="GET">
                    <div class="form-group">
                        <label class="form-label">Nomor Resi</label>
                        <input type="text" class="form-input" name="tracking_number" value="{{ request('tracking_number') }}"
                            placeholder="Contoh: RT12345678" required>
                        <p class="text-xs text-muted mt-1">Dapatkan nomor resi dari email pengiriman Anda.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Penagihan</label>
                        <input type="email" class="form-input" name="email" value="{{ request('email') }}"
                            placeholder="Email yang digunakan saat checkout" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-2">
                        <i class="fa-solid fa-search"></i> Lacak Sekarang
                    </button>
                </form>
            @else
                {{-- Tracking Results --}}
                <div style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 24px; margin-bottom: 24px;">
                    <div class="flex justify-between items-center flex-wrap gap-sm">
                        <div>
                            <span class="text-xs text-muted uppercase font-bold" style="letter-spacing: 1px;">Status Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            <h2 class="font-display" style="font-size: 24px; margin-top: 4px;">
                                @switch($order->status)
                                    @case('pending') Menunggu Pembayaran @break
                                    @case('payment_uploaded') Menunggu Verifikasi @break
                                    @case('processing') Sedang Diproses @break
                                    @case('shipped') Sedang Dikirim @break
                                    @case('completed') Selesai @break
                                    @case('cancelled') Dibatalkan @break
                                    @default {{ ucfirst($order->status) }}
                                @endswitch
                            </h2>
                        </div>
                        <a href="{{ route('order-track') }}" class="btn btn-ghost btn-sm">Lacak Lagi</a>
                    </div>
                </div>

                {{-- Resi Card (Only if Shipped or Processing) --}}
                @if($order->tracking_number)
                <div style="background: var(--color-bg-warm); border-radius: 12px; padding: 24px; margin-bottom: 24px; border-left: 4px solid var(--color-accent);">
                    <div class="flex items-center gap-md">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-truck-fast" style="color: var(--color-accent);"></i>
                        </div>
                        <div>
                            <p class="text-xs text-muted uppercase font-bold" style="margin-bottom: 2px;">Nomor Resi Pelacakan</p>
                            <p style="font-family: var(--font-body); font-weight: 700; font-size: 18px; color: var(--color-primary);">{{ $order->tracking_number }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Status Progress --}}
                <div style="margin-bottom: 32px; padding: 0 10px;">
                    <div style="display: flex; justify-content: space-between; position: relative;">
                        {{-- Progress Line --}}
                        <div style="position: absolute; top: 15px; left: 0; width: 100%; height: 2px; background: var(--color-border-light); z-index: 1;"></div>
                        
                        @php
                            $statuses = [
                                'pending' => ['icon' => 'fa-wallet', 'label' => 'Order'],
                                'processing' => ['icon' => 'fa-box', 'label' => 'Proses'],
                                'shipped' => ['icon' => 'fa-truck', 'label' => 'Kirim'],
                                'completed' => ['icon' => 'fa-check-double', 'label' => 'Selesai']
                            ];
                            $reached = false;
                            $currentStatus = $order->status === 'payment_uploaded' ? 'pending' : $order->status;
                        @endphp

                        @foreach($statuses as $key => $val)
                            @php
                                $isActive = ($currentStatus === $key);
                                $isPast = false;
                                if ($currentStatus === 'completed') $isPast = true;
                                elseif ($currentStatus === 'shipped' && in_array($key, ['pending', 'processing'])) $isPast = true;
                                elseif ($currentStatus === 'processing' && $key === 'pending') $isPast = true;
                            @endphp
                            <div style="text-align: center; z-index: 2; position: relative; width: 25%;">
                                <div style="
                                    width: 32px; height: 32px; border-radius: 50%; margin: 0 auto 8px;
                                    display: flex; align-items: center; justify-content: center; font-size: 14px;
                                    background: {{ $isActive || $isPast ? 'var(--color-primary)' : '#fff' }};
                                    color: {{ $isActive || $isPast ? '#fff' : 'var(--color-text-muted)' }};
                                    border: 2px solid {{ $isActive || $isPast ? 'var(--color-primary)' : 'var(--color-border-light)' }};
                                ">
                                    <i class="fa-solid {{ $val['icon'] }}"></i>
                                </div>
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: {{ $isActive ? 'var(--color-primary)' : 'var(--color-text-muted)' }}">{{ $val['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tracking Logs Timeline --}}
                <div style="background: var(--color-bg); border-radius: 12px; padding: 24px; margin-bottom: 32px; border: 1px solid var(--color-border-light);">
                    <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 20px; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 12px;">
                        <i class="fa-solid fa-history" style="margin-right: 8px;"></i> Riwayat Perjalanan
                    </h4>
                    <div style="padding-left: 15px; border-left: 2px solid var(--color-border-light); margin-left: 10px;">
                        @forelse($order->trackingLogs as $log)
                            <div style="position: relative; margin-bottom: 24px;">
                                <div style="position: absolute; left: -21px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: var(--color-accent); box-shadow: 0 0 0 4px #fff;"></div>
                                <p style="font-weight: 700; font-size: 14px; margin-bottom: 4px; color: var(--color-text);">{{ $log->status_text }}</p>
                                <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
                                    <p class="text-xs text-muted">
                                        <i class="fa-solid fa-clock" style="margin-right: 4px;"></i>
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </p>
                                    @if($log->location)
                                        <span class="text-xs" style="background: rgba(196,162,101,0.08); color: var(--color-accent); padding: 2px 10px; border-radius: 10px; font-weight: 600;">
                                            <i class="fa-solid fa-location-dot" style="margin-right: 4px;"></i> {{ $log->location }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-muted">Belum ada riwayat perjalanan yang tersedia.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Order Summary --}}
                <div style="padding-top: 24px; border-top: 1px solid var(--color-border-light);">
                    <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 16px;">Ringkasan Barang</h4>
                    @foreach($order->items as $item)
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <img src="{{ asset('assets/product/' . $item->product->image) }}" style="width: 40px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <div style="flex: 1;">
                                <p style="font-size: 14px; font-weight: 500; margin-bottom: 2px;">{{ $item->product->name }}</p>
                                <p class="text-xs text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div style="margin-top: 16px; padding-top: 12px; border-top: 1px dashed var(--color-border-light); display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; font-size: 14px;">Total Akhir</span>
                        <span style="font-weight: 700; font-size: 16px; color: var(--color-primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Help CTA --}}
        <div class="text-center mt-5" style="padding-top: 32px; border-top: 1px solid var(--color-border-light);">
            <h3 class="font-display" style="font-size: 18px; margin-bottom: 8px;">Butuh Bantuan?</h3>
            <p class="text-sm text-muted mb-3">Hubungi tim dukungan kami jika Anda mengalami kendala.</p>
            <a href="{{ url('/contact') }}" class="btn btn-outline btn-sm">Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection
