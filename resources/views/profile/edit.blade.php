<x-app-layout>
    <x-slot name="header">
        <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Profil & Paramètres</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">
        <!-- Update Profile -->
        <div class="enterprise-card p-8">
            <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations du Profil</h2>
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf @method('patch')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="enterprise-label">Nom complet</label>
                        <input id="name" name="name" type="text" class="enterprise-input" value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="enterprise-label">Adresse Email</label>
                        <input id="email" name="email" type="email" class="enterprise-input" value="{{ old('email', $user->email) }}" required>
                        @error('email') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="enterprise-btn-primary">Sauvegarder &rarr;</button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="enterprise-card p-8">
            <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Mot de Passe</h2>
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf @method('put')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="enterprise-label">Mot de passe actuel</label>
                        <input id="current_password" name="current_password" type="password" class="enterprise-input" autocomplete="current-password">
                        @error('current_password', 'updatePassword') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="enterprise-label">Nouveau mot de passe</label>
                        <input id="password" name="password" type="password" class="enterprise-input" autocomplete="new-password">
                        @error('password', 'updatePassword') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="enterprise-label">Confirmer</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="enterprise-input" autocomplete="new-password">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="enterprise-btn-primary">Mettre à jour &rarr;</button>
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="enterprise-card p-8 border-l-4 border-l-danger">
            <h2 class="text-[11px] font-bold text-danger uppercase tracking-widest mb-2">Zone Dangereuse</h2>
            <p class="text-[13px] text-text-muted mb-4">La suppression du compte est irréversible. Toutes les données seront perdues.</p>
            <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
                @csrf @method('delete')
                <div class="max-w-sm mb-4">
                    <label for="delete_password" class="enterprise-label">Confirmez votre mot de passe</label>
                    <input id="delete_password" name="password" type="password" class="enterprise-input border-danger/30 focus:border-danger" placeholder="Votre mot de passe">
                    @error('password', 'userDeletion') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="inline-flex items-center justify-center h-[44px] px-6 rounded-[8px] bg-danger text-white font-semibold text-[14px] transition-all hover:bg-red-600">Supprimer le compte</button>
            </form>
        </div>
    </div>
</x-app-layout>
