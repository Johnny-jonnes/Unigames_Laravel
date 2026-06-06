<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start gap-4">
            <a href="{{ route('joueurs.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Ajouter un Joueur</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Enregistrez un nouvel athlète et affiliez-le à une équipe.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl" x-data="{ 
        selectedDiscipline: '', 
        equipes: {{ $equipes->map(fn($e) => ['id' => $e->id, 'nom' => $e->nom, 'discipline_id' => $e->discipline_id, 'faculte' => $e->faculte->nom])->toJson() }},
        get filteredEquipes() {
            if (!this.selectedDiscipline) return [];
            return this.equipes.filter(e => e.discipline_id == this.selectedDiscipline);
        }
    }">
        <form action="{{ route('joueurs.store') }}" method="POST">
            @csrf
            
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Profil de l'Athlète</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prénom -->
                        <div>
                            <label for="prenom" class="enterprise-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" id="prenom" class="enterprise-input {{ $errors->has('prenom') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('prenom') }}" placeholder="Ex: Mamadou" required>
                            @error('prenom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="nom" class="enterprise-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('nom') }}" placeholder="Ex: Diallo" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Sexe -->
                        <div>
                            <label for="sexe" class="enterprise-label">Sexe <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="sexe" id="sexe" class="enterprise-input {{ $errors->has('sexe') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin (M)</option>
                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin (F)</option>
                                </select>
                            </div>
                            @error('sexe') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Numéro -->
                        <div>
                            <label for="numero" class="enterprise-label">Numéro de maillot (optionnel)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-[12px] font-bold text-slate-400">#</span>
                                </div>
                                <input type="number" name="numero" id="numero" min="1" max="99" class="enterprise-input pl-8 font-mono {{ $errors->has('numero') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('numero') }}" placeholder="10">
                            </div>
                            @error('numero') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Sélection d'affiliation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-50">
                        <!-- Discipline Filter -->
                        <div>
                            <label for="discipline_filter" class="enterprise-label">Filtrer par Discipline <span class="text-danger">*</span></label>
                            <select id="discipline_filter" x-model="selectedDiscipline" class="enterprise-input px-4 appearance-none" required>
                                <option value="">Choisir la discipline ▾</option>
                                @foreach($disciplines as $discipline)
                                    <option value="{{ $discipline->id }}">{{ $discipline->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Équipe d'affiliation -->
                        <div>
                            <label for="equipe_id" class="enterprise-label">Équipe d'affiliation <span class="text-danger">*</span></label>
                            <select 
                                name="equipe_id" 
                                id="equipe_id" 
                                class="enterprise-input px-4 appearance-none {{ $errors->has('equipe_id') ? 'border-danger' : '' }}" 
                                :disabled="!selectedDiscipline"
                                required
                            >
                                <option value="" x-show="!selectedDiscipline">Veuillez d'abord choisir une discipline</option>
                                <option value="" x-show="selectedDiscipline && filteredEquipes.length > 0">Sélectionner l'équipe ▾</option>
                                <option value="" x-show="selectedDiscipline && filteredEquipes.length === 0">Aucune équipe pour cette discipline</option>
                                <template x-for="equipe in filteredEquipes" :key="equipe.id">
                                    <option :value="equipe.id" x-text="equipe.nom + ' (' + equipe.faculte + ')'"></option>
                                </template>
                            </select>
                            @error('equipe_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('joueurs.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary gap-2" x-data="{ loading: false }" x-on:click="loading = true" :class="{'opacity-80': loading}">
                    <span x-show="!loading">Enregistrer le joueur &rarr;</span>
                    <span x-show="loading" style="display: none;" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Traitement...
                    </span>
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
