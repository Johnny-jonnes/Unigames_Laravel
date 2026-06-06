<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('editions.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">{{ $edition->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $edition->date_debut->format('d M Y') }} — {{ $edition->date_fin->format('d M Y') }}</p>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('editions.edit', $edition) }}" class="enterprise-btn-secondary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Modifier
        </a>
        @endif
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Période</p>
            <p class="text-[14px] font-semibold text-text-primary">{{ $edition->date_debut->format('d M Y') }} — {{ $edition->date_fin->format('d M Y') }}</p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Équipes Inscrites</p>
            <p class="text-[28px] font-mono font-bold text-primary">{{ $edition->equipes->count() }}</p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Statut</p>
            @if($edition->statut === 'en_cours')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-bold bg-[#DCFCE7] text-[#166534] mt-1">En cours</span>
            @elseif($edition->statut === 'terminee')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-bold bg-[#F1F5F9] text-[#475569] mt-1">Terminée</span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-bold bg-[#DBEAFE] text-[#1E40AF] mt-1">À venir</span>
            @endif
        </div>
        </div>
    </div>

    <!-- Actions Supplémentaires -->
    <div class="mt-8 flex gap-4">
        <a href="{{ route('editions.arbre', $edition) }}" class="enterprise-btn-primary gap-2 h-14 px-8 shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
            Voir l'Arbre du Tournoi (Bracket)
        </a>
    </div>
</x-app-layout>
