@use('Illuminate\Support\Str')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('editions.show', $edition) }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Arbre du Tournoi : {{ $edition->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Suivi des confrontations par discipline.</p>
            </div>
        </div>
    </x-slot>

    @foreach($disciplinesData as $data)
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="h-8 w-1 bg-primary rounded-full"></div>
                <h2 class="text-[24px] font-syne font-bold text-text-primary uppercase tracking-tight">{{ $data['discipline']->nom }}</h2>
            </div>

            <div class="overflow-x-auto pb-8">
                <div class="inline-flex gap-8 items-start min-w-full">
                    
                    <!-- Phase de Poules (Dynamique) -->
                    @php 
                        $poulesMatches = $data['phases']->filter(function($value, $key) {
                            return Str::contains(Str::lower($key), ['poule', 'groupe']);
                        })->flatten();
                    @endphp

                    @if($poulesMatches->count() > 0)
                        <div class="flex flex-col gap-4 w-[300px]">
                            <h3 class="text-[11px] font-bold text-text-muted uppercase tracking-widest text-center border-b border-slate-100 pb-2 mb-2">Phase de Poules</h3>
                            <div class="grid gap-3">
                                @foreach($poulesMatches as $match)
                                    <a href="{{ route('matchs.show', $match) }}" class="enterprise-card p-3 hover:border-primary transition-colors bg-slate-50/50 block">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-[9px] font-bold text-primary bg-primary/5 px-1.5 py-0.5 rounded uppercase">{{ $match->phase }}</span>
                                            <span class="text-[9px] font-mono text-text-muted">{{ $match->date_match->format('d/m H:i') }}</span>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'font-bold text-primary' : '' }}">
                                                <span class="text-[12px] truncate">{{ $match->equipeA->nom }}</span>
                                                <span class="text-[13px] font-mono">
                                                    @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                        {{ $match->score_a }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'font-bold text-primary' : '' }}">
                                                <span class="text-[12px] truncate">{{ $match->equipeB->nom }}</span>
                                                <span class="text-[13px] font-mono">
                                                    @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                        {{ $match->score_b }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="flex items-center justify-center h-full pt-20">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        </div>
                    @endif

                    <!-- Quart de Finales -->
                    @php 
                        $quartMatches = $data['phases']->filter(function($value, $key) {
                            return Str::contains(Str::lower($key), ['quart']);
                        })->flatten();
                    @endphp

                    @if($quartMatches->count() > 0)
                        <div class="flex flex-col gap-6 w-[280px]">
                            <h3 class="text-[11px] font-bold text-text-muted uppercase tracking-widest text-center border-b border-slate-100 pb-2 mb-2">Quarts de Finale</h3>
                            @foreach($quartMatches as $match)
                                <a href="{{ route('matchs.show', $match) }}" class="enterprise-card p-4 hover:border-primary transition-colors block">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[10px] font-mono text-text-muted">{{ $match->date_match->format('d/m H:i') }}</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-slate-100 uppercase">{{ $match->statut }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'font-bold' : '' }}">
                                            <span class="text-[13px] text-text-primary truncate pr-2">{{ $match->equipeA->nom }}</span>
                                            <span class="text-[14px] font-mono">
                                                @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                    {{ $match->score_a }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'font-bold' : '' }}">
                                            <span class="text-[13px] text-text-primary truncate pr-2">{{ $match->equipeB->nom }}</span>
                                            <span class="text-[14px] font-mono">
                                                @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                    {{ $match->score_b }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Demi Finales -->
                    @php 
                        $demiMatches = $data['phases']->filter(function($value, $key) {
                            return Str::contains(Str::lower($key), ['demi']);
                        })->flatten();
                    @endphp

                    @if($demiMatches->count() > 0)
                        <div class="flex flex-col gap-12 w-[280px] pt-12">
                            <h3 class="text-[11px] font-bold text-text-muted uppercase tracking-widest text-center border-b border-slate-100 pb-2 mb-2">Demi-Finales</h3>
                            @foreach($demiMatches as $match)
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
                        </div>
                    @endif

                    <!-- Petite Finale -->
                    @php 
                        $petiteFinaleMatches = $data['phases']->filter(function($value, $key) {
                            return Str::contains(Str::lower($key), ['petite finale']);
                        })->flatten();
                    @endphp

                    @if($petiteFinaleMatches->count() > 0)
                        <div class="flex flex-col gap-8 w-[280px] pt-12">
                            <h3 class="text-[11px] font-bold text-text-muted uppercase tracking-widest text-center border-b border-slate-100 pb-2 mb-2">Petite Finale (3ème place)</h3>
                            @foreach($petiteFinaleMatches as $match)
                                <a href="{{ route('matchs.show', $match) }}" class="enterprise-card p-4 hover:bg-slate-50 transition-colors border-dashed border-2 block">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[10px] font-mono text-text-muted">{{ $match->date_match->format('d/m H:i') }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_a > $match->score_b ? 'font-bold' : '' }}">
                                            <span class="text-[13px] text-text-primary">{{ $match->equipeA->nom }}</span>
                                            <span class="text-[14px] font-mono">
                                                @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                    {{ $match->score_a }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center {{ $match->statut === 'joue' && $match->score_b > $match->score_a ? 'font-bold' : '' }}">
                                            <span class="text-[13px] text-text-primary">{{ $match->equipeB->nom }}</span>
                                            <span class="text-[14px] font-mono">
                                                @if($match->statut === 'joue' || $match->statut === 'en_cours')
                                                    {{ $match->score_b }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Finale -->
                    @php 
                        $finaleMatches = $data['phases']->filter(function($value, $key) {
                            return Str::lower($key) === 'finale' || Str::lower($key) === 'grande finale';
                        })->flatten();
                    @endphp

                    @if($finaleMatches->count() > 0)
                        <div class="flex flex-col gap-8 w-[320px] pt-24">
                            <h3 class="text-[12px] font-bold text-amber-500 uppercase tracking-widest text-center mb-4 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                                GRANDE FINALE
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                            </h3>
                            @foreach($finaleMatches as $match)
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
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endforeach

    @if(empty($disciplinesData))
        <div class="enterprise-card p-12 text-center">
            <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-[18px] font-bold text-text-primary">Aucun match programmé</h3>
            <p class="text-[14px] text-text-muted mt-1">L'arbre du tournoi sera visible dès que des matchs seront ajoutés.</p>
            @if(auth()->user()->role === 'admin' && $edition->statut !== 'terminee')
            <a href="{{ route('matchs.create') }}" class="enterprise-btn-primary mt-6">Programmer un match</a>
            @endif
        </div>
    @endif

</x-app-layout>
