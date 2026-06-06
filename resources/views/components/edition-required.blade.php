{{-- Composant "Blank State" affiché quand aucune édition n'est sélectionnée --}}
@php
    $editions = \App\Models\Edition::orderBy('date_debut', 'desc')->get();
@endphp

<div class="flex flex-col items-center justify-center py-24 px-6">
    <div class="w-20 h-20 rounded-2xl bg-indigo-50 border-2 border-indigo-100 flex items-center justify-center mb-6">
        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
    </div>
    <h2 class="text-xl font-bold text-slate-800 mb-2">Sélectionnez une édition</h2>
    <p class="text-sm text-slate-500 text-center max-w-md mb-8">
        Veuillez choisir une édition des Jeux Universitaires pour afficher les données correspondantes.
    </p>
    <div class="flex flex-wrap gap-3 justify-center">
        @foreach($editions as $edition)
            <a href="{{ route('dashboard', ['edition_id' => $edition->id]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border-2 transition-all
                      {{ $edition->statut === 'terminee' ? 'border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-emerald-700' : '' }}
                      {{ $edition->statut === 'en_cours' ? 'border-amber-200 bg-amber-50 hover:bg-amber-100 text-amber-700' : '' }}
                      {{ $edition->statut === 'a_venir' ? 'border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700' : '' }}
                      hover:shadow-md hover:-translate-y-0.5">
                @if($edition->statut === 'terminee')
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                @elseif($edition->statut === 'en_cours')
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                @else
                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                @endif
                <span class="font-semibold text-sm">{{ $edition->nom }}</span>
            </a>
        @endforeach
    </div>
</div>
