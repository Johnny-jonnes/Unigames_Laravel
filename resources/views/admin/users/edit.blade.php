<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier le Profil</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Mise à jour des informations et réinitialisation de mot de passe.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="enterprise-card p-8 space-y-6">
                <div>
                    <label class="enterprise-label">Adresse email (Non modifiable)</label>
                    <input type="text" class="enterprise-input bg-slate-50 text-slate-400 cursor-not-allowed" value="{{ $user->email }}" disabled>
                </div>

                <div>
                    <label for="name" class="enterprise-label">Nom complet</label>
                    <input type="text" name="name" id="name" class="enterprise-input" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="mt-1 text-[12px] text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="enterprise-label">Rôle d'accès</label>
                    <select name="role" id="role" class="enterprise-input appearance-none px-4" required>
                        <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Organisateur (Saisie des scores)</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur (Gestion totale)</option>
                        <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>Lecteur (Consultation seulement)</option>
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-[14px] font-bold text-text-primary mb-1">Réinitialisation du mot de passe</h3>
                    <p class="text-[12px] text-text-muted mb-4">Laissez vide si vous ne souhaitez pas changer le mot de passe.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="enterprise-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="enterprise-input font-mono" placeholder="••••••••">
                            @error('password') <p class="mt-1 text-[12px] text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="enterprise-label">Confirmer</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="enterprise-input font-mono" placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary px-8">Enregistrer les modifications &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
