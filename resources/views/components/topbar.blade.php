<header class="sticky top-0 z-40 bg-white border-b border-border-color h-[64px] flex items-center px-8 shadow-sm">
    <div class="flex-1 flex items-center text-[13px] font-medium text-text-muted">
        <!-- Breadcrumb basique basé sur la route -->
        <span class="text-primary font-bold">Dashboard</span>
        @if(!request()->routeIs('dashboard'))
            <span class="mx-2 text-border-color">/</span>
            <span class="text-text-primary capitalize">{{ explode('.', request()->route()->getName())[0] ?? '' }}</span>
            @if(Str::contains(request()->route()->getName(), 'create'))
                <span class="mx-2 text-border-color">/</span>
                <span class="text-text-muted">Ajouter</span>
            @elseif(Str::contains(request()->route()->getName(), 'edit'))
                <span class="mx-2 text-border-color">/</span>
                <span class="text-text-muted">Modifier</span>
            @elseif(Str::contains(request()->route()->getName(), 'show'))
                <span class="mx-2 text-border-color">/</span>
                <span class="text-text-muted">Détails</span>
            @endif
        @endif
    </div>
    
    <div class="flex items-center gap-4">
        <!-- Notification Bell (Dynamique) -->
        <x-dropdown align="right" width="80">
            <x-slot name="trigger">
                <button class="w-9 h-9 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary hover:bg-slate-100 transition-colors relative focus:outline-none focus:shadow-focus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if($recentMatches->count() > 0)
                        <span class="absolute top-0 right-0 flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-danger border border-white"></span>
                        </span>
                    @endif
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 border-b border-border-color flex justify-between items-center">
                    <p class="text-[13px] font-bold text-text-primary">Derniers résultats</p>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 bg-primary/10 text-primary rounded">{{ $recentMatches->count() }}</span>
                </div>
                <div class="max-h-[350px] overflow-y-auto">
                    @forelse($recentMatches as $match)
                        <a href="{{ route('matchs.show', $match) }}" class="px-4 py-3 hover:bg-slate-50 border-b border-border-color transition-colors flex gap-3 group">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="text-[12px] font-bold text-text-primary leading-tight">{{ $match->discipline->nom }}</p>
                                    <span class="text-[10px] text-text-muted">{{ $match->date_match->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] text-text-muted mt-0.5">
                                    <span class="{{ $match->score_a > $match->score_b ? 'font-bold text-text-primary' : '' }}">{{ $match->equipeA->nom }}</span>
                                    <span class="font-mono px-1">{{ $match->score_a }} - {{ $match->score_b }}</span>
                                    <span class="{{ $match->score_b > $match->score_a ? 'font-bold text-text-primary' : '' }}">{{ $match->equipeB->nom }}</span>
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="px-8 py-12 text-center">
                            <svg class="w-10 h-10 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="text-[12px] text-text-muted">Aucune notification pour le moment.</p>
                        </div>
                    @endforelse
                </div>
                <div class="px-4 py-2 border-t border-border-color text-center bg-slate-50">
                    <a href="{{ route('matchs.index') }}" class="text-[12px] font-semibold text-primary hover:text-primary-light">Voir tous les matchs</a>
                </div>
            </x-slot>
        </x-dropdown>

        <div class="h-6 w-px bg-border-color mx-1"></div>

        <!-- User Dropdown (Simplified visually, uses Alpine from Breeze) -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-3 hover:bg-slate-50 p-1.5 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-[13px] font-bold text-text-primary leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] font-medium text-text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-sm font-bold text-white shadow-sm">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="text-[13px] font-medium">Profil & Paramètres</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-[13px] font-medium text-danger hover:bg-red-50">
                        Se déconnecter
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
