@extends('layouts.store')

@section('title', 'Konfirmasi Password — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 460px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; background: rgba(196,162,101,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-user-shield" style="font-size: 24px; color: var(--color-accent);"></i>
                </div>
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Area Terproteksi</h1>
                <p class="text-sm text-muted">Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           required autocomplete="current-password"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Konfirmasi</button>
            </form>
        </div>
    </div>
</section>
@endsection
