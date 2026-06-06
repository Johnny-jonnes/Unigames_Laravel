<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('equipes.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">{{ $equipe->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $equipe->discipline->nom }} · {{ $equipe->faculte->nom }}</p>
            </div>
        </div>
        <a href="{{ route('equipes.edit', $equipe) }}" class="enterprise-btn-secondary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Modifier
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 space-y-6">
            <div class="enterprise-card p-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-4 pb-2 border-b border-slate-100">Fiche Équipe</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Discipline</p>
                        <span class="inline-flex px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-[11px] font-bold text-slate-700 mt-1">{{ $equipe->discipline->nom }}</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Institution</p>
                        <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $equipe->faculte->nom }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Édition</p>
                        <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $equipe->edition->nom }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Effectif</p>
                        <p class="text-[22px] font-mono font-bold text-primary mt-1">{{ $equipe->joueurs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="enterprise-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border-color bg-white flex items-center justify-between">
                    <h2 class="text-[14px] font-bold text-text-primary">Effectif ({{ $equipe->joueurs->count() }})</h2>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-border-color">
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider">Joueur</th>
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Âge</th>
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">N°</th>
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Perf.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($equipe->joueurs as $joueur)
                            <tr class="hover:bg-[#F0F4FA] transition-colors">
                                <td class="px-5 py-3 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-[9px] font-bold text-slate-500 uppercase border border-slate-200">{{ substr($joueur->prenom, 0, 1) }}{{ substr($joueur->nom, 0, 1) }}</div>
                                    <span class="text-[13px] font-bold text-text-primary">{{ $joueur->prenom }} {{ $joueur->nom }}</span>
                                </td>
                                <td class="px-5 py-3 text-center text-[12px] text-text-muted">{{ $joueur->age }} ans</td>
                                <td class="px-5 py-3 text-center">
                                    @if($joueur->numero_maillot)
                                        <span class="inline-flex w-6 h-6 bg-primary/10 text-primary border border-primary/20 rounded items-center justify-center text-[11px] font-bold font-mono">{{ $joueur->numero_maillot }}</span>
                                    @else
                                        <span class="text-text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right text-[13px] font-mono font-bold text-primary">{{ $joueur->buts }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-8 text-center text-[13px] text-text-muted">Aucun joueur dans cette équipe.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
