<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('joueurs.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier : {{ $joueur->prenom }} {{ $joueur->nom }}</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl" x-data="{ 
        selectedDiscipline: '{{ old('discipline_id', $joueur->equipe->discipline_id) }}', 
        equipes: {{ $equipes->map(fn($e) => ['id' => $e->id, 'nom' => $e->nom, 'discipline_id' => $e->discipline_id, 'faculte' => $e->faculte->nom])->toJson() }},
        get filteredEquipes() {
            if (!this.selectedDiscipline) return [];
            return this.equipes.filter(e => e.discipline_id == this.selectedDiscipline);
        },
        selectedEquipe: '{{ old('equipe_id', $joueur->equipe_id) }}'
    }">
        <form action="{{ route('joueurs.update', $joueur) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Profil de l'Athlète</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prénom -->
                        <div>
                            <label for="prenom" class="enterprise-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" id="prenom" class="enterprise-input {{ $errors->has('prenom') ? 'border-danger focus:border-danger' : '' }}" value="{{ old('prenom', $joueur->prenom) }}" required>
                            @error('prenom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="nom" class="enterprise-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger focus:border-danger' : '' }}" value="{{ old('nom', $joueur->nom) }}" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Âge -->
                        <div>
                            <label for="age" class="enterprise-label">Âge <span class="text-danger">*</span></label>
                            <input type="number" name="age" id="age" min="16" max="40" class="enterprise-input font-mono {{ $errors->has('age') ? 'border-danger focus:border-danger' : '' }}" value="{{ old('age', $joueur->age) }}" required>
                            @error('age') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Numéro -->
                        <div>
                            <label for="numero_maillot" class="enterprise-label">Numéro de maillot</label>
                            <input type="number" name="numero_maillot" id="numero_maillot" min="1" max="99" class="enterprise-input font-mono" value="{{ old('numero_maillot', $joueur->numero_maillot) }}">
                            @error('numero_maillot') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Sélection d'affiliation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-50">
                        <!-- Discipline Filter -->
                        <div>
                            <label for="discipline_filter" class="enterprise-label">Discipline <span class="text-danger">*</span></label>
                            <select id="discipline_filter" x-model="selectedDiscipline" @change="selectedEquipe = ''" class="enterprise-input px-4 appearance-none" required>
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
                                x-model="selectedEquipe"
                                class="enterprise-input px-4 appearance-none {{ $errors->has('equipe_id') ? 'border-danger' : '' }}" 
                                required
                            >
                                <option value="" x-show="filteredEquipes.length > 0">Sélectionner l'équipe ▾</option>
                                <template x-for="equipe in filteredEquipes" :key="equipe.id">
                                    <option :value="equipe.id" x-text="equipe.nom + ' (' + equipe.faculte + ')'" :selected="equipe.id == selectedEquipe"></option>
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
                <button type="submit" class="enterprise-btn-primary">Mettre à jour le joueur &rarr;</button>
            </div>

        </form>
    </div>
</x-app-layout>
