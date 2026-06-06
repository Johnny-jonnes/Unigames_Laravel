<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start gap-4">
            <a href="{{ route('disciplines.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Ajouter une Discipline</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Paramétrez une nouvelle discipline sportive pour vos événements.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('disciplines.store') }}" method="POST">
            @csrf
            
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Générales</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="nom" class="enterprise-label">Nom de la discipline <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('nom') }}" placeholder="Ex: Basketball" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre de joueurs -->
                        <div>
                            <label for="nombre_joueurs_par_equipe" class="enterprise-label">Joueurs par équipe <span class="text-danger">*</span></label>
                            <div class="relative">
                                <input type="number" name="nombre_joueurs_par_equipe" id="nombre_joueurs_par_equipe" min="1" class="enterprise-input font-mono pr-12 {{ $errors->has('nombre_joueurs_par_equipe') ? 'border-danger focus:border-danger focus:ring-danger/20' : '' }}" value="{{ old('nombre_joueurs_par_equipe') }}" placeholder="Ex: 5" required>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-[11px] font-bold text-slate-400">max</span>
                                </div>
                            </div>
                            @error('nombre_joueurs_par_equipe') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="enterprise-label">Règles ou Description (optionnelle)</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-[8px] border-[1.5px] border-border-color p-4 text-[14px] text-text-primary bg-white transition-all duration-180 focus:border-primary-light focus:shadow-focus outline-none placeholder:text-slate-400 resize-none {{ $errors->has('description') ? 'border-danger' : '' }}" placeholder="Informations complémentaires...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('disciplines.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary gap-2" x-data="{ loading: false }" x-on:click="loading = true" :class="{'opacity-80': loading}">
                    <span x-show="!loading">Enregistrer la discipline &rarr;</span>
                    <span x-show="loading" style="display: none;" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Traitement...
                    </span>
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
