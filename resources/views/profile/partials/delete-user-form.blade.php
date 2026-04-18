<section class="space-y-6">
    <header>
        <h2 class="font-display" style="font-size: 20px; color: var(--color-danger);">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda pertahankan.') }}
        </p>
    </header>

    <button
        class="btn btn-outline btn-sm text-danger"
        style="border-color: var(--color-danger); color: var(--color-danger);"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-display" style="font-size: 20px; color: var(--color-text); margin-bottom: 12px;">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="text-sm text-muted mb-6">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="form-group mb-6">
                <label for="password" class="sr-only">{{ __('Kata Sandi') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    style="width: 100%; padding: 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-family: var(--font-body);"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                @if($errors->userDeletion->get('password'))
                    <p class="text-danger text-xs mt-1">{{ $errors->userDeletion->get('password')[0] }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" class="btn btn-ghost btn-sm" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="btn btn-primary btn-sm" style="background: var(--color-danger); border-color: var(--color-danger);">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

