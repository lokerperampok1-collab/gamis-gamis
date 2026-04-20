@extends('layouts.store')

@section('title', 'Verifikasi Email — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 520px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; background: rgba(196,162,101,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-envelope-open-text" style="font-size: 24px; color: var(--color-accent);"></i>
                </div>
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Verifikasi Email Anda</h1>
                <p class="text-sm text-muted">Terima kasih telah mendaftar! Harap verifikasi alamat email Anda melalui link yang baru saja kami kirimkan.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" style="margin-bottom: 24px; padding: 16px; background: rgba(16,185,129,0.1); color: #10b981; border-radius: 8px; font-size: 14px;">
                    Link verifikasi baru telah dikirimkan ke alamat email Anda.
                </div>
            @endif

            <div class="flex flex-col gap-md">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim Ulang Email Verifikasi</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-block">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
