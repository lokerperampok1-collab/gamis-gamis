@extends('layouts.store')

@section('title', 'Atur Ulang Password — Ranti')

@section('content')
<section class="section" style="background: var(--color-bg); display: flex; align-items: center; min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 480px;">
        <div class="card card-body" style="padding: 48px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; background: rgba(196,162,101,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-lock-open" style="font-size: 24px; color: var(--color-accent);"></i>
                </div>
                <h1 class="font-display" style="font-size: 28px; margin-bottom: 8px;">Reset Password</h1>
                <p class="text-sm text-muted">Silakan buat password baru untuk akun Ranti Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                           class="form-input @error('email') is-invalid @enderror"
                           required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password Baru</label>
                    <input id="password" type="password" name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           required autocomplete="new-password"
                           placeholder="Min. 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-input"
                           required autocomplete="new-password"
                           placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan Password Baru</button>
            </form>
        </div>
    </div>
</section>
@endsection
