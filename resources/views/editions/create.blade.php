<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start gap-4">
            <a href="{{ route('editions.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Nouvelle Édition</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Configurez un nouvel événement ou tournoi sportif.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('editions.store') }}" method="POST">
            @csrf
            
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Principales</h2>
                
                <div class="space-y-6">
                    <!-- Nom et Lieu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="enterprise-label">Nom de l'édition <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('nom') }}" placeholder="Ex: UniGames 2024" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="lieu" class="enterprise-label">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="lieu" id="lieu" class="enterprise-input {{ $errors->has('lieu') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('lieu') }}" placeholder="Ex: Stade du 28 Septembre" required>
                            @error('lieu') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Date de début -->
                        <div>
                            <label for="date_debut" class="enterprise-label">Date de début <span class="text-danger">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="date_debut" id="date_debut" class="enterprise-input pl-10 font-mono text-[13px] {{ $errors->has('date_debut') ? 'border-danger' : '' }}" value="{{ old('date_debut') }}" required>
                            </div>
                            @error('date_debut') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date de fin -->
                        <div>
                            <label for="date_fin" class="enterprise-label">Date de fin <span class="text-danger">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="date_fin" id="date_fin" class="enterprise-input pl-10 font-mono text-[13px] {{ $errors->has('date_fin') ? 'border-danger' : '' }}" value="{{ old('date_fin') }}" required>
                            </div>
                            @error('date_fin') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="statut" class="enterprise-label">Statut <span class="text-danger">*</span></label>
                            <select name="statut" id="statut" class="enterprise-input px-4 appearance-none {{ $errors->has('statut') ? 'border-danger' : '' }}" required>
                                <option value="a_venir" {{ old('statut') == 'a_venir' ? 'selected' : '' }}>À venir</option>
                                <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminee" {{ old('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
                            </select>
                            @error('statut') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="enterprise-label">Description (Optionnelle)</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-[8px] border-[1.5px] border-border-color p-4 text-[14px] text-text-primary bg-white transition-all duration-180 focus:border-primary-light focus:shadow-focus outline-none placeholder:text-slate-400 resize-none {{ $errors->has('description') ? 'border-danger' : '' }}" placeholder="Informations complémentaires...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-[12px] border border-border-color shadow-sm">
                <a href="{{ route('editions.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary gap-2" x-data="{ loading: false }" x-on:click="loading = true" :class="{'opacity-80': loading}">
                    <span x-show="!loading">Créer l'édition &rarr;</span>
                    <span x-show="loading" style="display: none;" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Traitement...
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
