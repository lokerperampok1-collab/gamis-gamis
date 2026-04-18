@extends('layouts.store')

@section('title', 'Daftar — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 500px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Buat Akun</h1>
                <p class="text-sm text-muted">Bergabung dengan Ranti untuk pengalaman belanja premium</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           class="form-input @error('name') is-invalid @enderror"
                           required autofocus autocomplete="name"
                           placeholder="Nama lengkap Anda">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-input @error('email') is-invalid @enderror"
                           required autocomplete="username"
                           placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input id="password" type="password" name="password"
                               class="form-input @error('password') is-invalid @enderror"
                               required autocomplete="new-password"
                               placeholder="Min. 8 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input"
                               required autocomplete="new-password"
                               placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Daftar Sekarang</button>
            </form>

            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--color-border-light);">
                <p class="text-sm">Sudah punya akun?
                    <a href="{{ route('login') }}" style="color: var(--color-accent); font-weight: 600;">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
