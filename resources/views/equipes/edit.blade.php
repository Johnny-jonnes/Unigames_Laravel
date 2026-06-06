<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('equipes.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier : {{ $equipe->nom }}</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('equipes.update', $equipe) }}" method="POST">
            @csrf @method('PUT')
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Générales</h2>
                <div class="space-y-6">
                    <div>
                        <label for="nom" class="enterprise-label">Nom de l'équipe <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger' : '' }}" value="{{ old('nom', $equipe->nom) }}" required>
                        @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="faculte_id" class="enterprise-label">Institution <span class="text-danger">*</span></label>
                            <select name="faculte_id" id="faculte_id" class="enterprise-input px-4 appearance-none" required>
                                @foreach($facultes as $faculte)
                                    <option value="{{ $faculte->id }}" {{ old('faculte_id', $equipe->faculte_id) == $faculte->id ? 'selected' : '' }}>{{ $faculte->nom }}</option>
                                @endforeach
                            </select>
                            @error('faculte_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="discipline_id" class="enterprise-label">Discipline <span class="text-danger">*</span></label>
                            <select name="discipline_id" id="discipline_id" class="enterprise-input px-4 appearance-none" required>
                                @foreach($disciplines as $discipline)
                                    <option value="{{ $discipline->id }}" {{ old('discipline_id', $equipe->discipline_id) == $discipline->id ? 'selected' : '' }}>{{ $discipline->nom }}</option>
                                @endforeach
                            </select>
                            @error('discipline_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="edition_id" class="enterprise-label">Édition <span class="text-danger">*</span></label>
                        <select name="edition_id" id="edition_id" class="enterprise-input px-4 appearance-none" required>
                            @foreach($editions as $edition)
                                <option value="{{ $edition->id }}" {{ old('edition_id', $equipe->edition_id) == $edition->id ? 'selected' : '' }}>{{ $edition->nom }}</option>
                            @endforeach
                        </select>
                        @error('edition_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('equipes.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary">Mettre à jour &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
