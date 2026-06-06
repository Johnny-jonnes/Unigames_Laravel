<x-app-layout>
    <x-slot name="header">
        <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Calendrier des Rencontres</h1>
        @if(auth()->user()->role === 'admin')
            @if(!isset($selectedEdition) || (isset($selectedEdition) && $selectedEdition->statut !== 'terminee'))
            <a href="{{ route('matchs.create') }}" class="enterprise-btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Programmer un match
            </a>
            @endif
        @endif
    </x-slot>

    @if(isset($noEdition) && $noEdition)
        <x-edition-required />
    @else
    <div class="space-y-4" x-data="{ search: '', activeDiscipline: {{ $disciplinesWithMatchs->firstWhere(fn($d) => $d->matchs->count() > 0)?->id ?? 'null' }} }">
        <!-- Barre de recherche -->
        <div class="enterprise-card overflow-hidden">
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between bg-white gap-4">
                <h2 class="text-[14px] font-bold text-text-primary">Tous les matchs</h2>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="search" class="h-[34px] border border-border-color rounded-[6px] pl-9 pr-3 text-[12px] text-text-primary outline-none focus:border-primary w-full sm:w-64 bg-[#F8FAFC] transition-all" placeholder="Rechercher une équipe ou stade...">
                </div>
            </div>
        </div>

        @forelse($disciplinesWithMatchs as $discipline)
            @if($discipline->matchs->count() > 0)
                <div class="enterprise-card overflow-hidden transition-all duration-300" 
                     x-show="search === '' || '{{ strtolower(addslashes($discipline->nom)) }}'.includes(search.toLowerCase()) || Array.from($el.querySelectorAll('.match-row')).some(row => row.getAttribute('data-search').includes(search.toLowerCase()))"
                     :class="activeDiscipline === {{ $discipline->id }} ? 'ring-2 ring-primary/20 shadow-lg' : ''">
                    <!-- Discipline Header (Clickable) -->
                    <button 
                        @click="activeDiscipline = activeDiscipline === {{ $discipline->id }} ? null : {{ $discipline->id }}"
                        class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-slate-50 transition-colors text-left border-b border-border-color"
                    >
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center border border-indigo-100 shrink-0">
                                <span class="text-indigo-600 font-bold text-[14px]">{{ substr($discipline->nom, 0, 2) }}</span>
                            </div>
                            <div>
                                <h3 class="text-[15px] font-bold text-text-primary">{{ $discipline->nom }}</h3>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[11px] text-text-muted font-medium">{{ $discipline->matchs->count() }} match(s) programmé(s)</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" 
                                 :class="activeDiscipline === {{ $discipline->id }} ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Matches List -->
                    <div x-show="activeDiscipline === {{ $discipline->id }} || search !== ''" 
                         x-collapse 
                         class="bg-[#F8FAFC]">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#F8FAFC] border-b border-border-color">
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">Date & Lieu</th>
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Équipe A</th>
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Score</th>
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">Équipe B</th>
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Statut</th>
                                        @if(in_array(auth()->user()->role, ['admin', 'staff']))
                                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#F1F5F9] bg-white">
                                    @foreach($discipline->matchs as $match)
                                        <tr class="hover:bg-[#F0F4FA] transition-colors group cursor-pointer match-row" 
                                            data-search="{{ strtolower(addslashes($match->equipeA->nom . ' ' . $match->equipeB->nom . ' ' . $match->lieu . ' ' . $match->phase)) }}"
                                            x-show="search === '' || '{{ strtolower(addslashes($match->equipeA->nom . ' ' . $match->equipeB->nom . ' ' . $match->lieu . ' ' . $match->phase)) }}'.includes(search.toLowerCase())"
                                            onclick="window.location='{{ route('matchs.show', $match) }}'">
                                            <td class="px-6 py-4">
                                                <p class="text-[13px] font-bold text-text-primary">{{ $match->date_match->format('d M Y • H:i') }}</p>
                                                @if($match->lieu)
                                                    <p class="text-[11px] text-text-muted mt-0.5">{{ $match->lieu }}</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="text-[13px] font-bold {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'text-primary' : 'text-text-primary' }}">{{ $match->equipeA->nom }}</p>
                                                <p class="text-[11px] text-text-muted">{{ $match->equipeA->faculte->nom }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($match->statut === 'joue')
                                                    <span class="inline-flex items-center justify-center px-3 py-1 bg-white border border-slate-200 rounded text-[14px] font-mono font-bold text-text-primary shadow-sm">{{ $match->score_a }} - {{ $match->score_b }}</span>
                                                @else
                                                    <span class="text-[12px] font-medium text-text-muted">VS</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-[13px] font-bold {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'text-primary' : 'text-text-primary' }}">{{ $match->equipeB->nom }}</p>
                                                <p class="text-[11px] text-text-muted">{{ $match->equipeB->faculte->nom }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($match->statut === 'joue')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#DCFCE7] text-[#166534]">Joué</span>
                                                @elseif($match->statut === 'en_cours')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FEF3C7] text-[#92400E]">En cours</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#DBEAFE] text-[#1E40AF]">Planifié</span>
                                                @endif
                                            </td>
                                            @if(in_array(auth()->user()->role, ['admin', 'staff']))
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('matchs.show', $match) }}" onclick="event.stopPropagation()" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-border-color text-[11px] font-semibold text-slate-600 hover:text-primary hover:border-primary hover:bg-blue-50 transition-colors bg-white">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        Voir
                                                    </a>
                                                    @if(auth()->user()->role === 'admin')
                                                    <a href="{{ route('matchs.edit', $match) }}" onclick="event.stopPropagation()" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-blue-200 text-[11px] font-semibold text-blue-600 hover:bg-blue-50 transition-colors bg-blue-50/50">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        Modifier
                                                    </a>
                                                    <form action="{{ route('matchs.destroy', $match) }}" method="POST" class="inline" onsubmit="event.stopPropagation(); return confirm('Supprimer ce match ?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="event.stopPropagation()" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-red-200 text-[11px] font-semibold text-red-600 hover:bg-red-50 transition-colors bg-red-50/50">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="enterprise-card p-12 text-center">
                <p class="text-[13px] text-text-muted">Aucun match programmé pour cette édition.</p>
            </div>
        @endforelse
    </div>
    @endif
</x-app-layout>
