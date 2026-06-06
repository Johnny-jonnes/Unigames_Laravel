<x-app-layout>
    <x-slot name="header">
        <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Éditions du Tournoi</h1>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('editions.create') }}" class="enterprise-btn-primary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nouvelle Édition
        </a>
        @endif
    </x-slot>

    <div class="enterprise-card overflow-hidden h-full flex flex-col">
        <div class="px-6 py-4 flex items-center justify-between border-b-[2px] border-border-color bg-white">
            <h2 class="text-[14px] font-bold text-text-primary">Toutes les éditions ({{ $editions->count() }})</h2>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" class="h-[34px] border-[1.5px] border-border-color rounded-[6px] pl-9 pr-3 text-[12px] text-text-primary outline-none focus:border-primary focus:ring-1 focus:ring-primary w-64 bg-slate-50 transition-all" placeholder="Rechercher une édition...">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b-[2px] border-border-color">
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">Édition</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">Période</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Équipes</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]">
                    @forelse($editions as $edition)
                        <tr class="hover:bg-[#F0F4FA] transition-colors group">
                            <td class="px-6 py-4">
                                <p class="text-[13px] font-bold text-text-primary">{{ $edition->nom }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[12px] font-medium text-text-muted">
                                    {{ $edition->date_debut->format('d M Y') }} - {{ $edition->date_fin->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[13px] font-mono font-bold text-primary">{{ $edition->equipes_count }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($edition->statut === 'en_cours')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#DCFCE7] text-[#166534]">En cours</span>
                                @elseif($edition->statut === 'terminee')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#F1F5F9] text-[#475569]">Terminé</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#DBEAFE] text-[#1E40AF]">À venir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('editions.show', $edition) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-border-color text-[11px] font-semibold text-slate-600 hover:text-primary hover:border-primary hover:bg-blue-50 transition-colors bg-white">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Voir
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('editions.edit', $edition) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md border border-blue-200 text-[11px] font-semibold text-blue-600 hover:bg-blue-50 transition-colors bg-blue-50/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Modifier
                                    </a>
                                    <form action="{{ route('editions.destroy', $edition) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette édition ?')">
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
                        <tr><td colspan="5" class="px-6 py-12 text-center text-[13px] text-text-muted">Aucune édition enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
