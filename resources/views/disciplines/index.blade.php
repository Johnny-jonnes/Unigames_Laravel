<x-app-layout>
    <x-slot name="header">
        <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Disciplines Sportives</h1>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('disciplines.create') }}" class="enterprise-btn-primary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter
        </a>
        @endif
    </x-slot>

    <div class="enterprise-card overflow-hidden h-full flex flex-col">
        <div class="px-6 py-4 flex items-center justify-between border-b-[2px] border-border-color bg-white">
            <h2 class="text-[14px] font-bold text-text-primary">Toutes les disciplines ({{ $disciplines->count() }})</h2>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" class="h-[34px] border-[1.5px] border-border-color rounded-[6px] pl-9 pr-3 text-[12px] text-text-primary outline-none focus:border-primary focus:ring-1 focus:ring-primary w-64 bg-slate-50 transition-all" placeholder="Rechercher une discipline...">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b-[2px] border-border-color">
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">
                            <a href="{{ route('disciplines.index', ['sort' => 'nom', 'direction' => $sort === 'nom' && $direction === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
                                Discipline
                                @if($sort === 'nom') <svg class="w-3 h-3 {{ $direction === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"></path></svg> @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Format</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">
                            <a href="{{ route('disciplines.index', ['sort' => 'equipes_count', 'direction' => $sort === 'equipes_count' && $direction === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 justify-center hover:text-primary">
                                Équipes
                                @if($sort === 'equipes_count') <svg class="w-3 h-3 {{ $direction === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"></path></svg> @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">
                            <a href="{{ route('disciplines.index', ['sort' => 'matchs_count', 'direction' => $sort === 'matchs_count' && $direction === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 justify-center hover:text-primary">
                                Matchs Joués
                                @if($sort === 'matchs_count') <svg class="w-3 h-3 {{ $direction === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"></path></svg> @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]">
                    @forelse($disciplines as $discipline)
                        <tr class="hover:bg-[#F0F4FA] transition-colors group">
                            <td class="px-6 py-4">
                                <p class="text-[13px] font-bold text-text-primary">{{ $discipline->nom }}</p>
                                @if($discipline->description)
                                    <p class="text-[11px] text-text-muted mt-0.5 truncate max-w-xs">{{ $discipline->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-[11px] font-bold text-slate-700 font-mono">{{ $discipline->nombre_joueurs_par_equipe }} / équipe</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[13px] font-mono font-bold text-primary">{{ $discipline->equipes_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[13px] font-mono font-bold text-primary">{{ $discipline->matchs_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('disciplines.show', $discipline) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-border-color text-[11px] font-semibold text-slate-600 hover:text-primary hover:border-primary hover:bg-blue-50 transition-colors bg-white">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Voir
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('disciplines.edit', $discipline) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-blue-200 text-[11px] font-semibold text-blue-600 hover:bg-blue-50 transition-colors bg-blue-50/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Modifier
                                    </a>
                                    <form action="{{ route('disciplines.destroy', $discipline) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette discipline ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-red-200 text-[11px] font-semibold text-red-600 hover:bg-red-50 transition-colors bg-red-50/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Supprimer
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-[13px] text-text-muted">Aucune discipline enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
