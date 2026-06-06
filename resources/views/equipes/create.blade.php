<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start gap-4">
            <a href="{{ route('equipes.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Ajouter une Équipe</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Remplissez les informations requises pour inscrire une nouvelle équipe.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('equipes.store') }}" method="POST">
            @csrf
            
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[12px] font-bold text-text-muted uppercase tracking-wider mb-6 pb-2 border-b border-slate-100">Informations Générales</h2>
                
                <div class="space-y-6">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="enterprise-label">Nom de l'équipe <span class="text-danger">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-[18px] h-[18px] text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <input type="text" name="nom" id="nom" class="enterprise-input pl-11 {{ $errors->has('nom') ? 'border-danger' : '' }}" value="{{ old('nom') }}" placeholder="Ex: Les Lions de la FST" required>
                        </div>
                        @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- 2 Columns: Faculté & Discipline -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="faculte_id" class="enterprise-label">Institution / Faculté <span class="text-danger">*</span></label>
                            <select name="faculte_id" id="faculte_id" class="enterprise-input px-4 appearance-none {{ $errors->has('faculte_id') ? 'border-danger' : '' }}" required>
                                <option value="" disabled selected>Sélectionner ▾</option>
                                @foreach(\App\Models\Faculte::all() as $faculte)
                                    <option value="{{ $faculte->id }}" {{ old('faculte_id') == $faculte->id ? 'selected' : '' }}>{{ $faculte->nom }}</option>
                                @endforeach
                            </select>
                            @error('faculte_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="discipline_id" class="enterprise-label">Discipline Sportive <span class="text-danger">*</span></label>
                            <select name="discipline_id" id="discipline_id" class="enterprise-input px-4 appearance-none {{ $errors->has('discipline_id') ? 'border-danger' : '' }}" required>
                                <option value="" disabled selected>Sélectionner ▾</option>
                                @foreach(\App\Models\Discipline::all() as $discipline)
                                    <option value="{{ $discipline->id }}" {{ old('discipline_id') == $discipline->id ? 'selected' : '' }}>{{ $discipline->nom }}</option>
                                @endforeach
                            </select>
                            @error('discipline_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Édition -->
                    <div>
                        <label for="edition_id" class="enterprise-label">Édition associée <span class="text-danger">*</span></label>
                        <select name="edition_id" id="edition_id" class="enterprise-input px-4 appearance-none {{ $errors->has('edition_id') ? 'border-danger' : '' }}" required>
                            <option value="" disabled selected>Sélectionner ▾</option>
                            @foreach(\App\Models\Edition::all() as $edition)
                                <option value="{{ $edition->id }}" {{ old('edition_id') == $edition->id ? 'selected' : '' }}>{{ $edition->nom }}</option>
                            @endforeach
                        </select>
                        @error('edition_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('equipes.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary gap-2" x-data="{ loading: false }" x-on:click="loading = true" :class="{'opacity-80': loading}">
                    <span x-show="!loading">Enregistrer l'équipe &rarr;</span>
                    <span x-show="loading" style="display: none;" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Traitement...
                    </span>
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
