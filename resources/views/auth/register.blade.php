<x-guest-layout>
    <div class="flex min-h-screen w-full">
        <!-- LEFT PANEL : Branding -->
        <div class="hidden lg:flex w-1/2 bg-bg-sidebar relative flex-col justify-center items-center overflow-hidden p-12">
            <div class="absolute inset-0 opacity-5">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M0 40L40 0H20L0 20M40 40V20L20 40" fill="none" stroke="#FFFFFF" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
            </div>
            <div class="relative z-10 max-w-md w-full">
                <div class="flex flex-col items-center text-center mb-12">
                    <svg class="w-16 h-16 mb-4" fill="url(#trophy-reg)" viewBox="0 0 24 24">
                        <defs><linearGradient id="trophy-reg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#F59E0B" /><stop offset="100%" stop-color="#EF4444" /></linearGradient></defs>
                        <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3"/>
                        <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" fill="currentColor"/>
                    </svg>
                    <h1 class="font-syne text-[32px] text-white tracking-tight">UniGames</h1>
                    <p class="font-syne text-[24px] text-white/90 mt-4 leading-tight">Join the<br>Competition</p>
                </div>
            </div>
            <div class="absolute bottom-8 text-[12px] text-white/40 font-mono">System Build v1.0.0</div>
        </div>

        <!-- RIGHT PANEL : Form -->
        <div class="w-full lg:w-1/2 bg-bg-app flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative">
            <div class="w-full max-w-[420px]">
                <div class="flex lg:hidden items-center justify-center mb-10 gap-3">
                    <svg class="w-10 h-10" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3"/></svg>
                    <span class="font-syne text-[24px] font-bold text-primary">UniGames</span>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-[28px] font-bold text-text-primary tracking-tight">Créer un compte</h2>
                    <p class="text-[14px] text-text-muted font-medium mt-1">Inscrivez-vous pour accéder à la plateforme</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="enterprise-label">Nom complet <span class="text-danger">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="enterprise-input {{ $errors->has('name') ? 'border-danger' : '' }}" placeholder="Ex: Mamadou Diallo">
                        @error('name') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="enterprise-label">Adresse Email <span class="text-danger">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="enterprise-input {{ $errors->has('email') ? 'border-danger' : '' }}" placeholder="admin@unigames.gn">
                        @error('email') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="enterprise-label">Mot de passe <span class="text-danger">*</span></label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="enterprise-input {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="••••••••">
                            @error('password') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="enterprise-label">Confirmer <span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="enterprise-input" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full enterprise-btn-primary h-[48px]">Créer le compte &rarr;</button>
                    </div>

                    <p class="text-center text-[13px] text-text-muted">Déjà inscrit ? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-light transition-colors">Se connecter</a></p>
                </form>
            </div>
            <div class="absolute bottom-8 w-full text-center">
                <p class="text-[12px] font-medium text-slate-400">© {{ date('Y') }} UniGames · All rights reserved</p>
            </div>
        </div>
    </div>
</x-guest-layout>
