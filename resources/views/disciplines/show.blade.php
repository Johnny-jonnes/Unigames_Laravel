<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('disciplines.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">{{ $discipline->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $discipline->nombre_joueurs_par_equipe }} joueurs par équipe</p>
            </div>
        </div>
        <a href="{{ route('disciplines.edit', $discipline) }}" class="enterprise-btn-secondary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Modifier
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Format</p>
            <p class="text-[22px] font-mono font-bold text-primary">{{ $discipline->nombre_joueurs_par_equipe }} <span class="text-[13px] text-text-muted font-sans">/ équipe</span></p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Équipes</p>
            <p class="text-[22px] font-mono font-bold text-primary">{{ $discipline->equipes->count() }}</p>
        </div>
        <div class="enterprise-card p-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Matchs</p>
            <p class="text-[22px] font-mono font-bold text-primary">{{ $discipline->matchs->count() }}</p>
        </div>
    </div>

    @if($discipline->description)
        <div class="enterprise-card p-6 mb-6">
            <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-2">Description</p>
            <p class="text-[14px] text-text-primary leading-relaxed">{{ $discipline->description }}</p>
        </div>
    @endif
</x-app-layout>
