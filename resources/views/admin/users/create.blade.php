<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Ajouter un Organisateur</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Créez un nouveau compte pour le staff UniGames.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="enterprise-card p-8 space-y-6">
                <div>
                    <label for="name" class="enterprise-label">Nom complet</label>
                    <input type="text" name="name" id="name" class="enterprise-input" value="{{ old('name') }}" required autofocus>
                    @error('name') <p class="mt-1 text-[12px] text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="enterprise-label">Adresse email</label>
                    <input type="email" name="email" id="email" class="enterprise-input" value="{{ old('email') }}" required>
                    @error('email') <p class="mt-1 text-[12px] text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="enterprise-label">Rôle d'accès</label>
                    <select name="role" id="role" class="enterprise-input appearance-none px-4" required>
                        <option value="staff" selected>Organisateur (Saisie des scores)</option>
                        <option value="admin">Administrateur (Gestion totale)</option>
                        <option value="viewer">Lecteur (Consultation seulement)</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="enterprise-label">Mot de passe <span class="text-[10px] text-text-muted font-normal">(Min. 8 caractères)</span></label>
                        <input type="password" name="password" id="password" class="enterprise-input font-mono" required placeholder="••••••••">
                        @error('password') <p class="mt-1 text-[12px] text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="enterprise-label">Confirmer</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="enterprise-input font-mono" required>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary px-8">Créer le compte &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
