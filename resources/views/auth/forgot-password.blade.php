@extends('layouts.store')

@section('title', 'Lupa Password — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 460px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; background: rgba(196,162,101,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-key" style="font-size: 24px; color: var(--color-accent);"></i>
                </div>
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Lupa Password?</h1>
                <p class="text-sm text-muted">Jangan khawatir, masukkan email Anda dan kami akan mengirimkan link reset password.</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-input @error('email') is-invalid @enderror"
                           required autofocus
                           placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim Link Reset</button>
            </form>

            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--color-border-light);">
                <p class="text-sm">Kembali ke
                    <a href="{{ route('login') }}" style="color: var(--color-accent); font-weight: 600;">Halaman Masuk</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
