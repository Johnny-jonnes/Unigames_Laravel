<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('editions.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier : {{ $edition->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Mettez à jour les informations de cette édition.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('editions.update', $edition) }}" method="POST">
            @csrf @method('PUT')
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Principales</h2>
                <div class="space-y-6">
                    <!-- Nom et Lieu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="enterprise-label">Nom de l'édition <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger' : '' }}" value="{{ old('nom', $edition->nom) }}" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="lieu" class="enterprise-label">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="lieu" id="lieu" class="enterprise-input {{ $errors->has('lieu') ? 'border-danger' : '' }}" value="{{ old('lieu', $edition->lieu) }}" required>
                            @error('lieu') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Dates et Statut -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="date_debut" class="enterprise-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="enterprise-input font-mono text-[13px] {{ $errors->has('date_debut') ? 'border-danger' : '' }}" value="{{ old('date_debut', $edition->date_debut->format('Y-m-d')) }}" required>
                            @error('date_debut') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="date_fin" class="enterprise-label">Date de fin <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="enterprise-input font-mono text-[13px] {{ $errors->has('date_fin') ? 'border-danger' : '' }}" value="{{ old('date_fin', $edition->date_fin->format('Y-m-d')) }}" required>
                            @error('date_fin') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="statut" class="enterprise-label">Statut <span class="text-danger">*</span></label>
                            <select name="statut" id="statut" class="enterprise-input px-4 appearance-none {{ $errors->has('statut') ? 'border-danger' : '' }}" required>
                                <option value="a_venir" {{ old('statut', $edition->statut) == 'a_venir' ? 'selected' : '' }}>À venir</option>
                                <option value="en_cours" {{ old('statut', $edition->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminee" {{ old('statut', $edition->statut) == 'terminee' ? 'selected' : '' }}>Terminée</option>
                            </select>
                            @error('statut') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="enterprise-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-[8px] border-[1.5px] border-border-color p-4 text-[14px] text-text-primary bg-white transition-all duration-180 focus:border-primary-light focus:shadow-focus outline-none placeholder:text-slate-400 resize-none {{ $errors->has('description') ? 'border-danger' : '' }}">{{ old('description', $edition->description) }}</textarea>
                        @error('description') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-[12px] border border-border-color shadow-sm">
                <a href="{{ route('editions.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary">Mettre à jour &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
