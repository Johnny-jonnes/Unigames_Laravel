<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('matchs.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Programmer un Match</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Planifiez une rencontre entre deux équipes.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl" x-data="{
        selectedDiscipline: '{{ old('discipline_id') }}',
        equipes: {{ $equipes->map(fn($e) => ['id' => $e->id, 'nom' => $e->nom, 'discipline_id' => $e->discipline_id, 'faculte' => $e->faculte->nom])->toJson() }},
        get filteredEquipes() {
            if (!this.selectedDiscipline) return [];
            return this.equipes.filter(e => e.discipline_id == this.selectedDiscipline);
        }
    }">
        <form action="{{ route('matchs.store') }}" method="POST">
            @csrf
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Détails de la Rencontre</h2>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="discipline_id" class="enterprise-label">Discipline <span class="text-danger">*</span></label>
                            <select name="discipline_id" id="discipline_id" x-model="selectedDiscipline" class="enterprise-input px-4 appearance-none {{ $errors->has('discipline_id') ? 'border-danger' : '' }}" required>
                                <option value="" disabled>Sélectionner ▾</option>
                                @foreach($disciplines as $discipline)
                                    <option value="{{ $discipline->id }}">{{ $discipline->nom }}</option>
                                @endforeach
                            </select>
                            @error('discipline_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="edition_id" class="enterprise-label">Édition <span class="text-danger">*</span></label>
                            <select name="edition_id" id="edition_id" class="enterprise-input px-4 appearance-none {{ $errors->has('edition_id') ? 'border-danger' : '' }}" required>
                                <option value="" disabled selected>Sélectionner ▾</option>
                                @foreach($editions as $edition)
                                    <option value="{{ $edition->id }}" {{ old('edition_id') == $edition->id ? 'selected' : '' }}>{{ $edition->nom }}</option>
                                @endforeach
                            </select>
                            @error('edition_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                        <div>
                            <label for="equipe_a_id" class="enterprise-label">Équipe A (Domicile) <span class="text-danger">*</span></label>
                            <select 
                                name="equipe_a_id" 
                                id="equipe_a_id" 
                                class="enterprise-input px-4 appearance-none {{ $errors->has('equipe_a_id') ? 'border-danger' : '' }}" 
                                :disabled="!selectedDiscipline"
                                required
                            >
                                <option value="" x-show="!selectedDiscipline">Choisir une discipline</option>
                                <option value="" x-show="selectedDiscipline">Sélectionner ▾</option>
                                <template x-for="equipe in filteredEquipes" :key="'a-'+equipe.id">
                                    <option :value="equipe.id" x-text="equipe.nom + ' (' + equipe.faculte + ')'" :selected="equipe.id == '{{ old('equipe_a_id') }}'"></option>
                                </template>
                            </select>
                            @error('equipe_a_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="equipe_b_id" class="enterprise-label">Équipe B (Extérieur) <span class="text-danger">*</span></label>
                            <select 
                                name="equipe_b_id" 
                                id="equipe_b_id" 
                                class="enterprise-input px-4 appearance-none {{ $errors->has('equipe_b_id') ? 'border-danger' : '' }}" 
                                :disabled="!selectedDiscipline"
                                required
                            >
                                <option value="" x-show="!selectedDiscipline">Choisir une discipline</option>
                                <option value="" x-show="selectedDiscipline">Sélectionner ▾</option>
                                <template x-for="equipe in filteredEquipes" :key="'b-'+equipe.id">
                                    <option :value="equipe.id" x-text="equipe.nom + ' (' + equipe.faculte + ')'" :selected="equipe.id == '{{ old('equipe_b_id') }}'"></option>
                                </template>
                            </select>
                            @error('equipe_b_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="date_match" class="enterprise-label">Date et Heure <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_match" id="date_match" class="enterprise-input font-mono text-[13px] {{ $errors->has('date_match') ? 'border-danger' : '' }}" value="{{ old('date_match') }}" required>
                            @error('date_match') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="lieu" class="enterprise-label">Lieu</label>
                            <input type="text" name="lieu" id="lieu" class="enterprise-input" value="{{ old('lieu') }}" placeholder="Ex: Stade du 28 Septembre">
                            @error('lieu') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phase" class="enterprise-label">Phase <span class="text-danger">*</span></label>
                            <select name="phase" id="phase" class="enterprise-input px-4 appearance-none {{ $errors->has('phase') ? 'border-danger' : '' }}" required>
                                <option value="" disabled selected>Sélectionner ▾</option>
                                @foreach($phases as $phase)
                                    <option value="{{ $phase }}" {{ old('phase') == $phase ? 'selected' : '' }}>{{ $phase }}</option>
                                @endforeach
                            </select>
                            @error('phase') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('matchs.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary">Planifier la rencontre &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
