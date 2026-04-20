@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . ' — Ranti Admin')
@section('page-title', 'Detail Pesanan')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.orders') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 28px;">
    {{-- Left Column --}}
    <div>
        {{-- Order Info --}}
        <div class="admin-table-wrapper" style="margin-bottom: 28px;">
            <div class="admin-table-header">
                <h3><i class="fa-solid fa-receipt" style="color: var(--color-accent); margin-right: 8px;"></i> Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                <div>
                    @switch($order->status)
                        @case('pending')
                            <span class="badge badge-warning">Menunggu Pembayaran</span>
                            @break
                        @case('payment_uploaded')
                            <span class="badge" style="background: rgba(59,130,246,0.12); color: #3b82f6;">Perlu Verifikasi</span>
                            @break
                        @case('processing')
                            <span class="badge badge-success">Sedang Diproses</span>
                            @break
                        @default
                            <span class="badge">{{ ucfirst($order->status) }}</span>
                    @endswitch
                </div>
            </div>
            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p class="text-xs text-muted uppercase font-bold mb-1">Tanggal Pesanan</p>
                        <p style="font-weight: 600;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase font-bold mb-1">Total</p>
                        <p style="font-weight: 700; font-size: 18px; color: var(--color-primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase font-bold mb-1">Metode Pembayaran</p>
                        <p style="font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '-')) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase font-bold mb-1">Pelanggan</p>
                        <p style="font-weight: 600;">{{ $order->first_name }} {{ $order->last_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Details --}}
        <div class="admin-table-wrapper" style="margin-bottom: 28px;">
            <div class="admin-table-header">
                <h3><i class="fa-solid fa-truck" style="color: var(--color-accent); margin-right: 8px;"></i> Alamat Pengiriman</h3>
            </div>
            <div style="padding: 24px;">
                <p style="font-weight: 600; margin-bottom: 4px;">{{ $order->first_name }} {{ $order->last_name }}</p>
                <p class="text-sm text-muted">{{ $order->phone }}</p>
                <p class="text-sm" style="margin-top: 8px;">{{ $order->address }}</p>
                <p class="text-sm">{{ $order->city }}, {{ $order->zip }}</p>
                <p class="text-sm text-muted">{{ $order->email }}</p>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="admin-table-wrapper" style="margin-bottom: 28px;">
            <div class="admin-table-header">
                <h3><i class="fa-solid fa-box-open" style="color: var(--color-accent); margin-right: 8px;"></i> Item Pesanan</h3>
            </div>
            @if($order->items->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($item->product)
                                <img src="{{ asset('assets/product/' . $item->product->image) }}"
                                     class="product-thumb" alt="{{ $item->product->name }}"
                                     onerror="this.src='https://placehold.co/52x52/e8e4df/9ca3af?text=?'">
                                <span style="font-weight: 600;">{{ $item->product->name }}</span>
                                @else
                                <span class="text-muted">Produk dihapus</span>
                                @endif
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="padding: 24px; text-align: center;" class="text-muted">
                Detail item tidak tersedia.
            </div>
            @endif
        </div>

        {{-- Logistics & Tracking --}}
        @if($order->tracking_number)
        <div class="admin-table-wrapper">
            <div class="admin-table-header">
                <h3><i class="fa-solid fa-truck-ramp-box" style="color: var(--color-accent); margin-right: 8px;"></i> Logistik & Pelacakan</h3>
                <span class="text-xs font-bold" style="background: var(--color-primary-dark); color: #fff; padding: 4px 8px; border-radius: 4px;">RESI: {{ $order->tracking_number }}</span>
            </div>
            <div style="padding: 24px;">
                {{-- Add Log Form --}}
                <form action="{{ route('admin.orders.log', $order) }}" method="POST" style="background: var(--color-bg-warm); padding: 20px; border-radius: var(--radius-md); margin-bottom: 24px; border: 1px solid var(--color-border-light);">
                    @csrf
                    <p class="text-xs text-muted uppercase font-bold mb-3">Input Catatan Perjalanan Baru</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 12px;">
                        <div>
                            <label class="text-xs text-muted">Deskripsi Status</label>
                            <input type="text" name="status_text" class="form-control" placeholder="Contoh: Paket sampai di sortir Jakarta" required style="width:100%; padding: 8px; font-size:14px; border: 1px solid var(--color-border);">
                        </div>
                        <div>
                            <label class="text-xs text-muted">Lokasi (Opsional)</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Jakarta Selatan" style="width:100%; padding: 8px; font-size:14px; border: 1px solid var(--color-border);">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus-circle"></i> Tambah Catatan
                    </button>
                </form>

                {{-- Log Timeline --}}
                <div style="padding-left: 20px; border-left: 2px solid var(--color-border-light); margin-left: 10px;">
                    @forelse($order->trackingLogs as $log)
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -26px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: var(--color-accent);"></div>
                            <p style="font-weight: 700; font-size: 14px; margin-bottom: 2px; color: var(--color-primary);">{{ $log->status_text }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <p class="text-xs text-muted">
                                    <i class="fa-solid fa-clock" style="margin-right: 4px;"></i>
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </p>
                                @if($log->location)
                                    <span class="text-xs" style="background: rgba(196,162,101,0.1); color: var(--color-accent); padding: 2px 8px; border-radius: 10px; font-weight: 600;">{{ $log->location }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-muted">Belum ada catatan perjalanan paket.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Right Column: Payment Proof --}}
    <div>
        <div class="admin-table-wrapper" style="position: sticky; top: 80px;">
            <div class="admin-table-header">
                <h3><i class="fa-solid fa-credit-card" style="color: var(--color-accent); margin-right: 8px;"></i> Bukti Pembayaran</h3>
            </div>
            <div style="padding: 24px;">
                @if($order->payment_proof)
                    <div style="margin-bottom: 20px;">
                        <img src="{{ asset('assets/payments/' . $order->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             style="width: 100%; border-radius: var(--radius-md); border: 1px solid var(--color-border);"
                             onerror="this.src='https://placehold.co/300x400/e8e4df/9ca3af?text=Error'">
                    </div>
                    <p class="text-xs text-muted" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-clock" style="margin-right: 4px;"></i>
                        Diunggah {{ $order->updated_at->diffForHumans() }}
                    </p>
                @else
                    <div style="text-align: center; padding: 40px 20px; border-bottom: 1px solid var(--color-border-light); margin-bottom: 20px;">
                        <i class="fa-solid fa-image" style="font-size: 40px; color: var(--color-text-muted); margin-bottom: 12px;"></i>
                        <p class="text-muted">Bulkt pembayaran kosong.</p>
                    </div>
                @endif

                {{-- Action Area --}}
                <div style="display: flex; gap: 10px; flex-direction: column;">
                    @if($order->status === 'payment_uploaded')
                        <form method="POST" action="{{ route('admin.orders.verify', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                    onclick="return confirm('Verifikasi pembayaran ini?')">
                                <i class="fa-solid fa-check-circle"></i> Verifikasi Pembayaran
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.orders.reject', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="width: 100%; color: var(--color-danger); border-color: var(--color-danger);"
                                    onclick="return confirm('Tolak pembayaran ini? Pelanggan harus upload ulang.')">
                                <i class="fa-solid fa-times-circle"></i> Tolak Pembayaran
                            </button>
                        </form>
                    @elseif($order->status === 'processing')
                        <form method="POST" action="{{ route('admin.orders.ship', $order) }}">
                            @csrf
                            @method('PATCH')
                            <div style="margin-bottom: 12px;">
                                <label class="text-xs text-muted uppercase font-bold mb-1" style="display:block;">Nomor Resi (Opsional)</label>
                                <input type="text" name="tracking_number" class="form-control" placeholder="ABC123456" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; background: #3b82f6; border-color: #3b82f6;">
                                <i class="fa-solid fa-truck-fast"></i> Kirim Pesanan
                            </button>
                        </form>
                    @elseif($order->status === 'shipped')
                        <div style="text-align: center; padding: 12px; background: rgba(59,130,246,0.08); border-radius: var(--radius-sm); margin-bottom: 12px;">
                            <p class="text-xs text-muted uppercase font-bold">Resi Pengiriman</p>
                            <p style="font-weight: 700; color: #3b82f6;">{{ $order->tracking_number ?? 'Tanpa Resi' }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success" style="width: 100%; background: var(--color-success); color: white; border-color: var(--color-success);">
                                <i class="fa-solid fa-clipboard-check"></i> Selesaikan Pesanan
                            </button>
                        </form>
                    @elseif($order->status === 'completed')
                        <div style="text-align: center; padding: 12px; background: rgba(39,174,96,0.08); border-radius: var(--radius-sm);">
                            <i class="fa-solid fa-check-circle" style="color: var(--color-success); margin-right: 4px;"></i>
                            <span style="color: var(--color-success); font-weight: 600;">Pesanan Selesai</span>
                        </div>
                    @elseif($order->status === 'cancelled')
                        <div style="text-align: center; padding: 12px; background: rgba(239,68,68,0.08); border-radius: var(--radius-sm);">
                            <i class="fa-solid fa-ban" style="color: var(--color-danger); margin-right: 4px;"></i>
                            <span style="color: var(--color-danger); font-weight: 600;">Pesanan Dibatalkan</span>
                        </div>
                    @endif

                    @if(!in_array($order->status, ['completed', 'cancelled']))
                        <div style="margin-top: 16px; border-top: 1px solid var(--color-border-light); padding-top: 16px;">
                            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-ghost" style="width: 100%; color: var(--color-danger);"
                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini secara paksa? Stok akan otomatis dikembalikan.')">
                                    <i class="fa-solid fa-trash"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
