<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('facultes.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">{{ $faculte->nom }}</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $faculte->universite }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('facultes.edit', $faculte) }}" class="enterprise-btn-secondary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Modifier
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Infos principales -->
        <div class="lg:col-span-4">
            <div class="enterprise-card p-6">
                <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-4 pb-2 border-b border-slate-100">Informations</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Nom</p>
                        <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $faculte->nom }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Université</p>
                        <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $faculte->universite }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Édition</p>
                        <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $faculte->edition->nom ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Total Équipes</p>
                        <p class="text-[22px] font-mono font-bold text-primary mt-1">{{ $faculte->equipes->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Équipes de la faculté -->
        <div class="lg:col-span-8">
            <div class="enterprise-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border-color bg-white flex items-center justify-between">
                    <h2 class="text-[14px] font-bold text-text-primary">Équipes inscrites</h2>
                    <span class="text-[12px] font-mono font-bold text-primary">{{ $faculte->equipes->count() }}</span>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-border-color">
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider">Équipe</th>
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider">Discipline</th>
                            <th class="px-5 py-2.5 text-[11px] font-bold text-text-muted uppercase tracking-wider text-center">Joueurs</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($faculte->equipes as $equipe)
                            <tr class="hover:bg-[#F0F4FA] transition-colors">
                                <td class="px-5 py-3"><span class="text-[13px] font-bold text-text-primary">{{ $equipe->nom }}</span></td>
                                <td class="px-5 py-3"><span class="inline-flex px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-[10px] font-bold text-slate-700">{{ $equipe->discipline->nom }}</span></td>
                                <td class="px-5 py-3 text-center"><span class="text-[13px] font-mono font-bold text-primary">{{ $equipe->joueurs->count() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-5 py-8 text-center text-[13px] text-text-muted">Aucune équipe inscrite.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
