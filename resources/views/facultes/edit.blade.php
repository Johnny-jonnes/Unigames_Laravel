<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('facultes.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Modifier : {{ $faculte->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Mettez à jour les informations de cette institution.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('facultes.update', $faculte) }}" method="POST">
            @csrf @method('PUT')
            <div class="enterprise-card p-8 mb-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informations Générales</h2>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="enterprise-label">Nom de la faculté <span class="text-danger">*</span></label>
                            <input type="text" name="nom" id="nom" class="enterprise-input {{ $errors->has('nom') ? 'border-danger' : '' }}" value="{{ old('nom', $faculte->nom) }}" required>
                            @error('nom') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="universite" class="enterprise-label">Université <span class="text-danger">*</span></label>
                            <input type="text" name="universite" id="universite" class="enterprise-input {{ $errors->has('universite') ? 'border-danger' : '' }}" value="{{ old('universite', $faculte->universite) }}" required>
                            @error('universite') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="edition_id" class="enterprise-label">Édition associée <span class="text-danger">*</span></label>
                        <select name="edition_id" id="edition_id" class="enterprise-input px-4 appearance-none {{ $errors->has('edition_id') ? 'border-danger' : '' }}" required>
                            @foreach($editions as $edition)
                                <option value="{{ $edition->id }}" {{ old('edition_id', $faculte->edition_id) == $edition->id ? 'selected' : '' }}>{{ $edition->nom }}</option>
                            @endforeach
                        </select>
                        @error('edition_id') <p class="mt-1.5 text-[12px] font-medium text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-xl border border-border-color shadow-sm">
                <a href="{{ route('facultes.index') }}" class="enterprise-btn-secondary">Annuler</a>
                <button type="submit" class="enterprise-btn-primary">Mettre à jour &rarr;</button>
            </div>
        </form>
    </div>
</x-app-layout>
