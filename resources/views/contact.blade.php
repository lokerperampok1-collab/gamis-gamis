@extends('layouts.store')

@section('title', 'Hubungi Kami — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Kami senang mendengar dari Anda</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container" style="max-width: 960px;">
        <div class="grid" style="grid-template-columns: 1fr 320px; gap: 48px;">
            {{-- Contact Form --}}
            <div class="card card-body" style="padding: 40px;">
                <h3 class="font-display" style="font-size: 22px; margin-bottom: 8px;">Kirim Pesan</h3>
                <p class="text-muted text-sm mb-4">Isi formulir di bawah ini dan tim kami akan menghubungi Anda dalam 24 jam.</p>

                <form action="#" method="POST">
                    @csrf
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" name="name" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" name="email" placeholder="email@contoh.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subjek</label>
                        <input type="text" class="form-input" name="subject" placeholder="Tujuan pesan Anda">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pesan</label>
                        <textarea class="form-input" name="message" rows="5" placeholder="Tuliskan pesan Anda..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-full">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div>
                <div class="card card-body mb-3" style="padding: 28px;">
                    <div class="flex items-center gap-md mb-2">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-brands fa-whatsapp" style="font-size: 20px; color: var(--color-accent);"></i>
                        </div>
                        <div>
                            <h5 style="font-family: var(--font-body); font-size: 14px; font-weight: 700; margin-bottom: 2px;">WhatsApp</h5>
                            <p class="text-sm text-muted" style="margin: 0;">+62 813-8968-1142</p>
                        </div>
                    </div>
                </div>

                <div class="card card-body mb-3" style="padding: 28px;">
                    <div class="flex items-center gap-md mb-2">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-envelope" style="font-size: 18px; color: var(--color-accent);"></i>
                        </div>
                        <div>
                            <h5 style="font-family: var(--font-body); font-size: 14px; font-weight: 700; margin-bottom: 2px;">Email</h5>
                            <p class="text-sm text-muted" style="margin: 0;">cs@ranti.co.id</p>
                        </div>
                    </div>
                </div>

                <div class="card card-body" style="padding: 28px;">
                    <div class="flex items-center gap-md mb-2">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(196,162,101,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-location-dot" style="font-size: 18px; color: var(--color-accent);"></i>
                        </div>
                        <div>
                            <h5 style="font-family: var(--font-body); font-size: 14px; font-weight: 700; margin-bottom: 2px;">Alamat</h5>
                            <p class="text-sm text-muted" style="margin: 0;">Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
