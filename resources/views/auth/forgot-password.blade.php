<x-guest-layout>
    <div class="flex min-h-screen w-full items-center justify-center bg-bg-app p-8">
        <div class="enterprise-card p-8 w-full max-w-md">
            <div class="text-center mb-8">
                <svg class="w-12 h-12 mx-auto mb-4" fill="url(#trophy-fp)" viewBox="0 0 24 24">
                    <defs><linearGradient id="trophy-fp" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#F59E0B" /><stop offset="100%" stop-color="#EF4444" /></linearGradient></defs>
                    <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3"/>
                </svg>
                <h2 class="text-[22px] font-bold text-text-primary">Mot de passe oublié ?</h2>
                <p class="text-[13px] text-text-muted mt-2">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="enterprise-label">Email <span class="text-danger">*</span></label>
                    <input id="email" type="email" name="email" class="enterprise-input {{ $errors->has('email') ? 'border-danger' : '' }}" value="{{ old('email') }}" required autofocus placeholder="admin@unigames.gn">
                    @error('email') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full enterprise-btn-primary h-[48px]">Envoyer le lien &rarr;</button>
                <p class="text-center text-[13px] text-text-muted"><a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-light">Retour à la connexion</a></p>
            </form>
        </div>
    </div>
</x-guest-layout>
