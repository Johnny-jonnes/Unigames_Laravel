<x-guest-layout>
    <div class="flex min-h-screen w-full items-center justify-center bg-bg-app p-8">
        <div class="enterprise-card p-8 w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-[22px] font-bold text-text-primary">Confirmer le mot de passe</h2>
                <p class="text-[13px] text-text-muted mt-2">Veuillez confirmer votre mot de passe pour continuer.</p>
            </div>
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="password" class="enterprise-label">Mot de passe</label>
                    <input id="password" type="password" name="password" class="enterprise-input {{ $errors->has('password') ? 'border-danger' : '' }}" required autocomplete="current-password">
                    @error('password') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full enterprise-btn-primary h-[48px]">Confirmer &rarr;</button>
            </form>
        </div>
    </div>
</x-guest-layout>
