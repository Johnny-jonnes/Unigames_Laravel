<x-guest-layout>
    <div class="flex min-h-screen w-full">
        <!-- LEFT PANEL : Branding (50%) -->
        <div class="hidden lg:flex w-1/2 bg-bg-sidebar relative flex-col justify-center items-center overflow-hidden p-12">
            <!-- Background Pattern (Subtle geometric SVG) -->
            <div class="absolute inset-0 opacity-5">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40L40 0H20L0 20M40 40V20L20 40" fill="none" stroke="#FFFFFF" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)"/>
                </svg>
            </div>
            
            <div class="relative z-10 max-w-md w-full">
                <!-- Large Logo -->
                <div class="flex flex-col items-center text-center mb-12">
                    <svg class="w-16 h-16 mb-4" fill="url(#trophy-login)" viewBox="0 0 24 24">
                        <defs>
                            <linearGradient id="trophy-login" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F59E0B" />
                                <stop offset="100%" stop-color="#EF4444" />
                            </linearGradient>
                        </defs>
                        <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3"/>
                        <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" fill="currentColor"/>
                    </svg>
                    <h1 class="font-syne text-[32px] text-white tracking-tight">UniGames</h1>
                    <p class="font-syne text-[24px] text-white/90 mt-4 leading-tight">Là où les champions<br>sont forgés</p>
                </div>

                <!-- Feature Bullets -->
                <div class="space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-6 h-6 rounded-full bg-accent/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-[15px] font-medium text-white/80">Gestion de tournois en temps réel</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-6 h-6 rounded-full bg-accent/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-[15px] font-medium text-white/80">Classements et scores en direct</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-6 h-6 rounded-full bg-accent/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-[15px] font-medium text-white/80">Plateforme multisport universitaire</p>
                    </div>
                </div>
            </div>
            
            <div class="absolute bottom-8 text-[12px] text-white/40 font-mono">
                System Build v1.0.0
            </div>
        </div>

        <!-- RIGHT PANEL : Form (50%) -->
        <div class="w-full lg:w-1/2 bg-bg-app flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative">
            <div class="w-full max-w-[420px]">
                
                <!-- Mobile Logo (Hidden on Desktop) -->
                <div class="flex lg:hidden items-center justify-center mb-10 gap-3">
                    <svg class="w-10 h-10" fill="url(#trophy-mob)" viewBox="0 0 24 24">
                        <defs>
                            <linearGradient id="trophy-mob" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F59E0B" />
                                <stop offset="100%" stop-color="#EF4444" />
                            </linearGradient>
                        </defs>
                        <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3" fill="#F59E0B"/>
                        <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" fill="#0F2D6B"/>
                    </svg>
                    <span class="font-syne text-[24px] font-bold text-primary">UniGames</span>
                </div>

                <!-- Form Header -->
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-[28px] font-bold text-text-primary tracking-tight">Bon retour</h2>
                    <p class="text-[14px] text-text-muted font-medium mt-1">Connectez-vous à votre compte administrateur</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[13px] font-medium text-slate-700 mb-1.5">Adresse Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-[18px] w-[18px] text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                class="w-full h-[48px] rounded-[8px] border-[1.5px] border-border-color pl-11 pr-4 text-[14px] text-text-primary bg-white transition-all duration-180 focus:border-primary-light focus:shadow-focus outline-none placeholder:text-slate-400 {{ $errors->has('email') ? 'border-danger' : '' }}" 
                                placeholder="admin@unigames.gn">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-[13px] font-medium text-slate-700 mb-1.5">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-[18px] w-[18px] text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                                class="w-full h-[48px] rounded-[8px] border-[1.5px] border-border-color pl-11 pr-11 text-[14px] text-text-primary bg-white transition-all duration-180 focus:border-primary-light focus:shadow-focus outline-none placeholder:text-slate-400 {{ $errors->has('password') ? 'border-danger' : '' }}" 
                                placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" style="display: none;" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <!-- Custom Checkbox -->
                            <div class="relative flex items-center justify-center w-4 h-4 mr-2">
                                <input id="remember_me" type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-slate-300 rounded-[4px] bg-white checked:bg-primary checked:border-primary focus:shadow-focus focus:ring-offset-1 transition-all cursor-pointer">
                                <svg class="absolute w-2.5 h-2.5 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-[13px] font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-[13px] font-semibold text-primary hover:text-primary-light transition-colors" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="loading" :class="{'opacity-85 scale-[0.98]': loading}" class="w-full inline-flex items-center justify-center h-[48px] rounded-[8px] bg-primary text-white font-bold text-[14px] transition-all duration-180 hover:bg-primary-light focus:shadow-focus focus:outline-none disabled:cursor-not-allowed shadow-sm active:scale-[0.98]">
                            <span x-show="!loading">Se connecter</span>
                            <span x-show="loading" style="display: none;" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Authentification...
                            </span>
                        </button>
                    </div>
                </form>

            </div>
            
            <div class="absolute bottom-8 w-full text-center">
                <p class="text-[12px] font-medium text-slate-400">© {{ date('Y') }} UniGames · Tous droits réservés</p>
            </div>
        </div>
    </div>
</x-guest-layout>
