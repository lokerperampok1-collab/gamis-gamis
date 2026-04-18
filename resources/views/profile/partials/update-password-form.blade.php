<section>
    <header>
        <h2 class="font-display" style="font-size: 20px; color: var(--color-text);">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group mb-4">
            <label for="update_password_current_password" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="form-control" 
                style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <p class="text-danger text-xs mt-1">{{ $errors->updatePassword->get('current_password')[0] }}</p>
            @endif
        </div>

        <div class="form-group mb-4">
            <label for="update_password_password" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" 
                class="form-control" 
                style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <p class="text-danger text-xs mt-1">{{ $errors->updatePassword->get('password')[0] }}</p>
            @endif
        </div>

        <div class="form-group mb-4">
            <label for="update_password_password_confirmation" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="form-control" 
                style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-danger text-xs mt-1">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary btn-sm">{{ __('Ubah Kata Sandi') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                >{{ __('Berhasil diubah.') }}</p>
            @endif
        </div>
    </form>
</section>

