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

                <div style="display: flex; align-items: center; margin: 24px 0;">
                    <hr style="flex: 1; border: 0; border-top: 1px solid var(--color-border-light);">
                    <span style="padding: 0 16px; font-size: 13px; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.5px;">atau</span>
                    <hr style="flex: 1; border: 0; border-top: 1px solid var(--color-border-light);">
                </div>

                <a href="{{ route('auth.google') }}" class="btn btn-block btn-lg" style="
                    background: transparent;
                    border: 1.5px solid var(--color-border);
                    color: var(--color-text);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 12px;
                    transition: all 0.2s ease;
                ">
                    <svg width="20" height="20" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z"></path>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </svg>
                    Google
                </a>
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
