<aside class="fixed inset-y-0 left-0 w-[260px] bg-bg-sidebar flex flex-col z-50 text-white overflow-y-auto">
    
    <!-- Logo Zone (80px height) -->
    <div class="h-[80px] px-6 border-b border-white/10 flex items-center shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full group">
            <!-- Trophée stylisé SVG avec étoile -->
            <svg class="w-8 h-8 text-accent shrink-0 group-hover:scale-105 transition-transform" fill="url(#trophy-grad)" viewBox="0 0 24 24">
                <defs>
                    <linearGradient id="trophy-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#F59E0B" />
                        <stop offset="100%" stop-color="#EF4444" />
                    </linearGradient>
                </defs>
                <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.6-6.2-4.5-6.2 4.5 2.4-7.6-6.2-4.5h7.6z" opacity="0.3"/>
                <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" fill="currentColor"/>
            </svg>
            <div class="flex-1 overflow-hidden">
                <div class="font-syne text-[20px] font-bold text-white tracking-tight truncate">UniGames</div>
                <div class="flex items-center justify-between mt-0.5">
                    <span class="text-[10px] text-white/50 uppercase tracking-[0.08em] font-medium truncate">Sports Management</span>
                    <span class="text-[9px] bg-white/10 text-white/70 px-1.5 py-0.5 rounded ml-1 font-mono">v1.0</span>
                </div>
            </div>
        </a>
    </div>

    <!-- User Card -->
    <div class="p-4 shrink-0">
        <div class="bg-white/5 border border-white/10 rounded-xl p-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-primary-light flex items-center justify-center text-sm font-bold text-white shrink-0">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}{{ substr(explode(' ', Auth::user()->name ?? 'Admin')[1] ?? '', 0, 1) }}
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-[13px] font-semibold text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                @php
                    $roleLabel = match(Auth::user()->role ?? 'viewer') {
                        'admin' => 'Administrateur',
                        'staff' => 'Staff',
                        'viewer' => 'Lecteur',
                        default => 'Utilisateur',
                    };
                    $roleColor = match(Auth::user()->role ?? 'viewer') {
                        'admin' => 'text-accent',
                        'staff' => 'text-[#10B981]',
                        'viewer' => 'text-white/50',
                        default => 'text-white/50',
                    };
                @endphp
                <p class="text-[11px] {{ $roleColor }} font-medium mt-0.5 truncate">{{ $roleLabel }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Groups -->
    <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto">
        
        <!-- GÉNÉRAL -->
        <div>
            <p class="px-3 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-2">Général</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('dashboard') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Tableau de bord
                </a>
            </div>
        </div>

        <!-- GESTION -->
        <div>
            <p class="px-3 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-2">Gestion</p>
            <div class="space-y-1">
                <a href="{{ route('editions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('editions.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Éditions
                </a>
                <a href="{{ route('facultes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('facultes.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Facultés
                </a>
                <a href="{{ route('disciplines.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('disciplines.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Disciplines
                </a>
                <a href="{{ route('equipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('equipes.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Équipes
                </a>
                <a href="{{ route('joueurs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('joueurs.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Joueurs
                </a>
            </div>
        </div>

        <!-- COMPÉTITION -->
        <div>
            <p class="px-3 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-2">Compétition</p>
            <div class="space-y-1">
                <a href="{{ route('matchs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('matchs.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    Matchs & Programme
                </a>
                <a href="{{ route('classements.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('classements.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Classements
                </a>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <!-- ADMINISTRATION -->
        <div>
            <p class="px-3 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-2">Administration</p>
            <div class="space-y-1">
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-180 {{ request()->routeIs('admin.users.*') ? 'bg-primary-light text-white border-l-3 border-accent' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Gestion du Staff
                </a>
            </div>
        </div>
        @endif
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-white/10 shrink-0">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-white/55 hover:bg-white/5 hover:text-white transition-all duration-180">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Paramètres
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-danger/80 hover:bg-danger/10 hover:text-danger transition-all duration-180">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Se déconnecter
            </button>
        </form>
    </div>
</aside>
