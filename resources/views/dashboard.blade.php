<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Tableau de Bord</h1>
            
            <!-- Sélecteur d'édition -->
            <form id="edition-form" action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                <label for="edition_id" class="text-sm font-medium text-gray-700">Édition :</label>
                <select name="edition_id" id="edition_id" onchange="document.getElementById('edition-form').submit()" 
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5">
                    <option value="" disabled {{ !$selectedEditionId ? 'selected' : '' }}>Sélectionnez une édition</option>
                    @foreach($editions as $edition)
                        <option value="{{ $edition->id }}" {{ $selectedEditionId == $edition->id ? 'selected' : '' }}>
                            {{ $edition->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(!$selectedEditionId)
            <x-edition-required />
        @else
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="enterprise-card p-5 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-[#1A4BAD]"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Facultés</p>
                        <p class="text-[28px] font-mono font-bold text-text-primary leading-none">{{ $stats['facultes'] ?? 0 }}</p>
                        <p class="text-[11px] text-text-muted mt-1">engagées</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-[#1A4BAD] group-hover:bg-[#1A4BAD] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="enterprise-card p-5 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-[#10B981]"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Équipes</p>
                        <p class="text-[28px] font-mono font-bold text-text-primary leading-none">{{ $stats['equipes'] }}</p>
                        <p class="text-[11px] text-text-muted mt-1">inscrites</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-[#10B981] group-hover:bg-[#10B981] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="enterprise-card p-5 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-[#F59E0B]"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Matchs</p>
                        <p class="text-[28px] font-mono font-bold text-text-primary leading-none">{{ $stats['matchs_joues'] }}</p>
                        <p class="text-[11px] text-text-muted mt-1">joués</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-[#F59E0B] group-hover:bg-[#F59E0B] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"></path></svg>
                    </div>
                </div>
            </div>
            <div class="enterprise-card p-5 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-[#EF4444]"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider mb-1">Joueurs</p>
                        <p class="text-[28px] font-mono font-bold text-text-primary leading-none">{{ $stats['joueurs'] }}</p>
                        <p class="text-[11px] text-text-muted mt-1">enregistrés</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-[#EF4444] group-hover:bg-[#EF4444] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Matchs récents -->
            <div class="enterprise-card overflow-hidden">
                <div class="px-5 py-3 flex items-center justify-between border-b border-border-color bg-white">
                    <h2 class="text-[14px] font-bold text-text-primary">Matchs récents</h2>
                    <a href="{{ route('matchs.index') }}" class="text-[12px] font-semibold text-primary hover:text-primary-light transition-colors border border-primary/30 px-3 py-1 rounded-[6px]">Voir tout</a>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-border-color">
                            <th class="px-5 py-2 text-[10px] font-bold text-text-muted uppercase tracking-wider">Équipes</th>
                            <th class="px-5 py-2 text-[10px] font-bold text-text-muted uppercase tracking-wider text-center">Score</th>
                            <th class="px-5 py-2 text-[10px] font-bold text-text-muted uppercase tracking-wider text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($derniersResultats as $match)
                            <tr class="hover:bg-[#F0F4FA] transition-colors">
                                <td class="px-5 py-3 text-[12px] font-semibold text-text-primary">{{ $match->equipeA->nom }} vs {{ $match->equipeB->nom }}</td>
                                <td class="px-5 py-3 text-center text-[13px] font-mono font-bold text-text-primary">{{ $match->score_a }} – {{ $match->score_b }}</td>
                                <td class="px-5 py-3 text-right"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#DCFCE7] text-[#166534]">Joué</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-5 py-6 text-center text-[12px] text-text-muted">Aucun résultat</td></tr>
                        @endforelse

                        @forelse($prochainsMatchs as $match)
                            <tr class="hover:bg-[#F0F4FA] transition-colors">
                                <td class="px-5 py-3 text-[12px] font-semibold text-text-primary">{{ $match->equipeA->nom }} vs {{ $match->equipeB->nom }}</td>
                                <td class="px-5 py-3 text-center text-[12px] text-text-muted">– – –</td>
                                <td class="px-5 py-3 text-right"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#DBEAFE] text-[#1E40AF]">Planifié</span></td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Top classement -->
            <div class="enterprise-card overflow-hidden">
                <div class="px-5 py-3 border-b border-border-color bg-white">
                    <h2 class="text-[14px] font-bold text-text-primary">Top classement</h2>
                </div>
                <div class="p-2">
                    @forelse($meilleursButeurs as $index => $joueur)
                        @php
                            $rankClass = match($index) {
                                0 => 'bg-[#FEF3C7] text-[#92400E]',
                                1 => 'bg-[#F1F5F9] text-[#475569]',
                                2 => 'bg-[#FEF0E7] text-[#9A3412]',
                                default => 'bg-[#F8FAFC] text-slate-500',
                            };
                        @endphp
                        <div class="flex items-center gap-3 px-3 py-2.5 hover:bg-[#F8FAFC] rounded-lg transition-colors border-b border-[#F1F5F9] last:border-0">
                            <div class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-bold {{ $rankClass }} shrink-0">{{ $index + 1 }}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[12px] font-bold text-text-primary truncate">{{ $joueur->prenom }} {{ $joueur->nom }}</p>
                            </div>
                            <span class="text-[13px] font-mono font-bold text-primary shrink-0">N°{{ $joueur->numero }}</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[12px] text-text-muted">Aucune donnée</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- ARBORESCENCE DU TOURNOI (Demi → Finale)      --}}
        {{-- ============================================ --}}
        @if(count($arborescence) > 0)
        <div class="enterprise-card overflow-hidden">
            <div class="px-5 py-4 border-b border-border-color bg-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Phases Finales</h2>
                </div>
                @if($editionEnCours)
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-indigo-100">{{ $editionEnCours->nom }}</span>
                @endif
            </div>

            <div class="p-6 space-y-12 bg-slate-50">
                @foreach($arborescence as $disciplineNom => $phases)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        {{-- Discipline Header --}}
                        <div class="flex items-center gap-3 mb-8">
                            <h3 class="text-lg font-bold text-slate-800">{{ $disciplineNom }}</h3>
                            <div class="flex-1 h-px bg-slate-200"></div>
                        </div>

                        {{-- Bracket Grid: Demi → Finale --}}
                        <div class="flex flex-col md:flex-row items-stretch justify-center gap-6">

                            {{-- DEMI-FINALES (Gauche) --}}
                            <div class="flex-1 space-y-6">
                                <div class="text-center mb-4"><span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Demi-Finales</span></div>
                                @if(isset($phases['Demi']))
                                    @foreach($phases['Demi'] as $match)
                                    <a href="{{ route('matchs.show', $match) }}" class="bg-white border-2 border-slate-100 rounded-lg p-0 overflow-hidden shadow-sm hover:border-indigo-100 transition-colors relative z-10 block">
                                        <div class="flex items-center justify-between p-3 border-b border-slate-100 {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'bg-indigo-50/50' : '' }}">
                                            <span class="text-sm font-semibold {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'text-indigo-700' : 'text-slate-700' }}">{{ $match->equipeA->nom }}</span>
                                            @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                <span class="font-mono text-sm font-bold {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'text-indigo-700' : 'text-slate-600' }}">{{ $match->score_a }}</span>
                                            @else
                                                <span class="font-mono text-sm font-bold text-slate-400">-</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between p-3 {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'bg-indigo-50/50' : '' }}">
                                            <span class="text-sm font-semibold {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'text-indigo-700' : 'text-slate-700' }}">{{ $match->equipeB->nom }}</span>
                                            @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                <span class="font-mono text-sm font-bold {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'text-indigo-700' : 'text-slate-600' }}">{{ $match->score_b }}</span>
                                            @else
                                                <span class="font-mono text-sm font-bold text-slate-400">-</span>
                                            @endif
                                        </div>
                                        <div class="bg-slate-50 px-3 py-2 border-t border-slate-100 text-center">
                                            @if($match->statut === 'planifie')
                                                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($match->date_match)->format('d M • H:i') }}</p>
                                            @elseif($match->statut === 'en_cours')
                                                <p class="text-xs text-amber-600 font-bold flex items-center justify-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> En cours</p>
                                            @else
                                                <p class="text-xs text-slate-400">Terminé</p>
                                            @endif
                                        </div>
                                    </a>
                                    @endforeach
                                @endif
                            </div>

                            {{-- CONNECTEUR CENTRAL --}}
                            <div class="hidden md:flex flex-col justify-center items-center relative w-16">
                                <div class="absolute left-0 top-1/4 bottom-1/4 w-8 border-y-2 border-r-2 border-slate-200 rounded-r-xl"></div>
                                <div class="absolute left-8 top-1/2 w-8 border-b-2 border-slate-200"></div>
                            </div>

                            {{-- FINALE (Droite) --}}
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="text-center mb-4"><span class="text-xs font-bold text-amber-500 uppercase tracking-widest">Finale</span></div>
                                @if(isset($phases['Finale']))
                                    @foreach($phases['Finale'] as $match)
                                    <a href="{{ route('matchs.show', $match) }}" class="bg-gradient-to-b from-amber-50 to-white border-2 border-amber-200 rounded-xl p-0 overflow-hidden shadow-md relative z-10 transform hover:-translate-y-1 hover:shadow-lg transition-all block">
                                        <div class="absolute top-0 right-0 bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-bl-lg border-b border-l border-amber-200">OR</div>
                                        <div class="flex items-center justify-between p-4 border-b border-amber-100 {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'bg-amber-100/50' : '' }}">
                                            <span class="text-base font-bold {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'text-amber-700' : 'text-slate-800' }}">
                                                @if($match->statut === 'joue' && $match->score_a > $match->score_b) 👑 @endif {{ $match->equipeA->nom }}
                                            </span>
                                            @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                <span class="font-mono text-lg font-bold {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'text-amber-700' : 'text-slate-700' }}">{{ $match->score_a }}</span>
                                            @else
                                                <span class="font-mono text-lg font-bold text-slate-400">-</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between p-4 {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'bg-amber-100/50' : '' }}">
                                            <span class="text-base font-bold {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'text-amber-700' : 'text-slate-800' }}">
                                                @if($match->statut === 'joue' && $match->score_b > $match->score_a) 👑 @endif {{ $match->equipeB->nom }}
                                            </span>
                                            @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                <span class="font-mono text-lg font-bold {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'text-amber-700' : 'text-slate-700' }}">{{ $match->score_b }}</span>
                                            @else
                                                <span class="font-mono text-lg font-bold text-slate-400">-</span>
                                            @endif
                                        </div>
                                        <div class="bg-amber-50/50 px-4 py-3 border-t border-amber-100 text-center">
                                            @if($match->statut === 'planifie')
                                                <p class="text-sm text-amber-700 font-medium">📅 {{ \Carbon\Carbon::parse($match->date_match)->format('d M Y • H:i') }}</p>
                                            @elseif($match->statut === 'en_cours')
                                                <p class="text-sm text-red-600 font-bold flex items-center justify-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span> Match en cours
                                                </p>
                                            @else
                                                <p class="text-sm text-amber-600 font-medium">Champion couronné !</p>
                                            @endif
                                        </div>
                                    </a>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($editionEnCours)
        <div class="enterprise-card p-6 border-l-4 border-l-primary-light">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-[16px] font-bold text-text-primary">Édition Sélectionnée</h2>
                @if($editionEnCours->statut === 'en_cours')
                <span class="px-3 py-1 bg-[#DCFCE7] text-[#166534] rounded-full text-[11px] font-bold uppercase tracking-wider border border-[#A7F3D0]">En cours</span>
                @elseif($editionEnCours->statut === 'terminee')
                <span class="px-3 py-1 bg-[#F1F5F9] text-[#475569] rounded-full text-[11px] font-bold uppercase tracking-wider border border-[#E2E8F0]">Terminée</span>
                @else
                <span class="px-3 py-1 bg-[#DBEAFE] text-[#1E40AF] rounded-full text-[11px] font-bold uppercase tracking-wider border border-[#93C5FD]">À venir</span>
                @endif
            </div>
            <p class="text-[18px] font-bold text-primary">{{ $editionEnCours->nom }}</p>
            <p class="text-[12px] text-text-muted mt-1">{{ \Carbon\Carbon::parse($editionEnCours->date_debut)->format('d M Y') }} → {{ \Carbon\Carbon::parse($editionEnCours->date_fin)->format('d M Y') }}</p>
        </div>
        @endif
        @endif
    </div>
</x-app-layout>
