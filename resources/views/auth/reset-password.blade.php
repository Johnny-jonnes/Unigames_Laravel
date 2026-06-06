<x-guest-layout>
    <div class="flex min-h-screen w-full items-center justify-center bg-bg-app p-8">
        <div class="enterprise-card p-8 w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-[22px] font-bold text-text-primary">Réinitialiser le mot de passe</h2>
            </div>
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div>
                    <label for="email" class="enterprise-label">Email</label>
                    <input id="email" type="email" name="email" class="enterprise-input {{ $errors->has('email') ? 'border-danger' : '' }}" value="{{ old('email', $request->email) }}" required autofocus>
                    @error('email') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password" class="enterprise-label">Nouveau mot de passe</label>
                    <input id="password" type="password" name="password" class="enterprise-input {{ $errors->has('password') ? 'border-danger' : '' }}" required>
                    @error('password') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="enterprise-label">Confirmer</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="enterprise-input" required>
                </div>
                <button type="submit" class="w-full enterprise-btn-primary h-[48px]">Réinitialiser &rarr;</button>
            </form>
        </div>
    </div>
</x-guest-layout>
