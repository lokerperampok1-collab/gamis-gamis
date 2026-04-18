<section>
    <header>
        <h2 class="font-display" style="font-size: 20px; color: var(--color-text);">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group mb-4">
            <label for="name" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Nama Lengkap</label>
            <input id="name" name="name" type="text" 
                class="form-control" 
                style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <p class="text-danger text-xs mt-1">{{ $errors->get('name')[0] }}</p>
            @endif
        </div>

        <div class="form-group mb-4">
            <label for="email" class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Alamat Email</label>
            <input id="email" name="email" type="email" 
                class="form-control" 
                style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <p class="text-danger text-xs mt-1">{{ $errors->get('email')[0] }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary btn-sm">{{ __('Simpan Perubahan') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

