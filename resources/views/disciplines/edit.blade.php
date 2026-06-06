<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('disciplines.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier : {{ $discipline->nom }}</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('disciplines.update', $discipline) }}" method="POST">
            @csrf @method('PUT')
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Générales</h2>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="enterprise-label">Nom de la discipline <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger' : '' }}" value="{{ old('nom', $discipline->nom) }}" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nombre_joueurs_par_equipe" class="enterprise-label">Joueurs par équipe <span class="text-danger">*</span></label>
                            <input type="number" name="nombre_joueurs_par_equipe" id="nombre_joueurs_par_equipe" min="1" class="enterprise-input font-mono {{ $errors->has('nombre_joueurs_par_equipe') ? 'border-danger' : '' }}" value="{{ old('nombre_joueurs_par_equipe', $discipline->nombre_joueurs_par_equipe) }}" required>
                            @error('nombre_joueurs_par_equipe') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="enterprise-label">Description (optionnelle)</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-[8px] border-[1.5px] border-border-color p-4 text-[14px] text-text-primary bg-white transition-all focus:border-primary-light outline-none placeholder:text-slate-400 resize-none">{{ old('description', $discipline->description) }}</textarea>
                        @error('description') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('disciplines.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary">Mettre à jour &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
