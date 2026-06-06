<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('joueurs.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">{{ $joueur->prenom }} {{ $joueur->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $joueur->equipe->nom ?? 'Sans équipe' }} · {{ $joueur->equipe->discipline->nom ?? '' }}</p>
            </div>
        </div>
        <a href="{{ route('joueurs.edit', $joueur) }}" class="enterprise-btn-secondary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Modifier
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Profil Card -->
        <div class="enterprise-card p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center text-[20px] font-bold text-primary mx-auto mb-3">
                {{ substr($joueur->prenom, 0, 1) }}{{ substr($joueur->nom, 0, 1) }}
            </div>
            <h3 class="text-[16px] font-bold text-text-primary">{{ $joueur->prenom }} {{ $joueur->nom }}</h3>
            <p class="text-[13px] text-text-muted mt-0.5">{{ $joueur->equipe->nom ?? 'Sans équipe' }}</p>
            @if($joueur->numero_maillot)
                <div class="mt-3 inline-flex w-10 h-10 bg-primary text-white rounded-lg items-center justify-center text-[16px] font-bold font-mono">{{ $joueur->numero_maillot }}</div>
            @endif
        </div>

        <!-- Stats -->
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Âge</p>
            <p class="text-[22px] font-mono font-bold text-text-primary">{{ $joueur->age }} <span class="text-[13px] text-text-muted font-sans">ans</span></p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Performances</p>
            <p class="text-[22px] font-mono font-bold text-primary">{{ $joueur->buts }} <span class="text-[13px] text-text-muted font-sans">pts/buts</span></p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Discipline</p>
            <span class="inline-flex px-3 py-1 bg-slate-100 border border-slate-200 rounded text-[12px] font-bold text-slate-700 mt-1">{{ $joueur->equipe->discipline->nom ?? 'N/A' }}</span>
        </div>
    </div>
</x-app-layout>
