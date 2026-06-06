<x-app-layout>
    <x-slot name="header">
        <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Répertoire par Équipe</h1>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('joueurs.create') }}" class="enterprise-btn-primary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter un Joueur
        </a>
        @endif
    </x-slot>

    @if(isset($noEdition) && $noEdition)
        <x-edition-required />
    @else
    <div class="space-y-4" x-data="{ search: '', activeTeam: {{ $equipesWithJoueurs->firstWhere(fn($e) => $e->joueurs->count() > 0)?->id ?? 'null' }} }">
        <!-- Barre de recherche -->
        <div class="enterprise-card overflow-hidden">
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between bg-white gap-4">
                <h2 class="text-[14px] font-bold text-text-primary">Tous les joueurs</h2>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="search" class="h-[34px] border border-border-color rounded-[6px] pl-9 pr-3 text-[12px] text-text-primary outline-none focus:border-primary w-full sm:w-64 bg-[#F8FAFC] transition-all" placeholder="Rechercher un joueur...">
                </div>
            </div>
        </div>

        @forelse($equipesWithJoueurs as $equipe)
            <div class="enterprise-card overflow-hidden transition-all duration-300" 
                 x-show="search === '' || '{{ strtolower(addslashes($equipe->nom)) }}'.includes(search.toLowerCase()) || Array.from($el.querySelectorAll('.joueur-row')).some(row => row.getAttribute('data-search').includes(search.toLowerCase()))"
                 :class="activeTeam === {{ $equipe->id }} ? 'ring-2 ring-primary/20 shadow-lg' : ''">
                <!-- Team Header (Clickable) -->
                <button 
                    @click="activeTeam = activeTeam === {{ $equipe->id }} ? null : {{ $equipe->id }}"
                    class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-slate-50 transition-colors text-left"
                >
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200 shrink-0">
                            <span class="text-primary font-bold text-[14px]">{{ substr($equipe->nom, 0, 2) }}</span>
                        </div>
                        <div>
                            <h3 class="text-[15px] font-bold text-text-primary">{{ $equipe->nom }}</h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[11px] text-text-muted font-medium uppercase tracking-wider">{{ $equipe->discipline->nom }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-[11px] text-text-muted font-medium">{{ $equipe->faculte->nom }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-right hidden sm:block">
                            <p class="text-[13px] font-bold text-primary">{{ $equipe->joueurs_count }} joueurs</p>
                            <p class="text-[11px] text-text-muted">Inscrits</p>
                        </div>
                        <svg 
                            class="w-5 h-5 text-slate-400 transition-transform duration-300" 
                            :class="activeTeam === {{ $equipe->id }} ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>

                <!-- Players List (Accordion Content) -->
                <div 
                    x-show="activeTeam === {{ $equipe->id }} || search !== ''" 
                    x-collapse
                    class="border-t border-slate-100 bg-[#F8FAFC]/50"
                >
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100">
                                    <th class="px-8 py-3 text-[10px] font-bold text-text-muted uppercase tracking-widest">Athlète</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">Poste</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">N°</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">Buts/Pts</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="px-8 py-3 text-[10px] font-bold text-text-muted uppercase tracking-widest text-right">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($equipe->joueurs as $joueur)
                                    <tr class="hover:bg-white transition-colors group joueur-row"
                                        data-search="{{ strtolower(addslashes($joueur->prenom . ' ' . $joueur->nom)) }}"
                                        x-show="search === '' || '{{ strtolower(addslashes($joueur->prenom . ' ' . $joueur->nom)) }}'.includes(search.toLowerCase())">
                                        <td class="px-8 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full bg-primary/5 flex items-center justify-center text-[9px] font-bold text-primary border border-primary/10">
                                                    {{ substr($joueur->prenom, 0, 1) }}{{ substr($joueur->nom, 0, 1) }}
                                                </div>
                                                <span class="text-[13px] font-semibold text-text-primary">{{ $joueur->prenom }} {{ $joueur->nom }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="text-[12px] text-text-muted">{{ $joueur->poste ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="text-[13px] font-mono font-bold text-text-primary">{{ $joueur->numero_maillot ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="font-bold text-primary text-[13px]">{{ $joueur->buts }}</span>
                                        </td>
                                        @if(auth()->user()->role === 'admin')
                                        <td class="px-8 py-3 text-right">
                                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('joueurs.edit', $joueur) }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                <form action="{{ route('joueurs.destroy', $joueur) }}" method="POST" onsubmit="return confirm('Supprimer ce joueur ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-danger transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-8 py-6 text-center text-[12px] text-text-muted italic">Aucun joueur dans cette équipe.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-3 bg-slate-50/50 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('equipes.show', $equipe) }}" class="text-[11px] font-bold text-primary hover:underline uppercase tracking-wider">Voir les stats d'équipe &rarr;</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="enterprise-card p-12 text-center">
                <p class="text-text-muted">Aucune équipe enregistrée.</p>
            </div>
        @endforelse
    </div>
    @endif
</x-app-layout>
