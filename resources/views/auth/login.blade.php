@extends('layouts.store')

@section('title', 'Masuk — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 460px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Selamat Datang</h1>
                <p class="text-sm text-muted">Masuk ke akun Ranti Exclusive Anda</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-input @error('email') is-invalid @enderror"
                           required autofocus autocomplete="username"
                           placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="flex justify-between items-center mb-1">
                        <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs" style="color: var(--color-accent);">Lupa Password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           required autocomplete="current-password"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="checkbox-custom">
                        <input type="checkbox" name="remember">
                        <span class="text-sm">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Masuk</button>
            </form>

            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--color-border-light);">
                <p class="text-sm">Belum punya akun?
                    <a href="{{ route('register') }}" style="color: var(--color-accent); font-weight: 600;">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
