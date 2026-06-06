<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Classements & Statistiques</h1>
            <p class="text-[13px] font-medium text-text-muted mt-0.5">Résultats officiels et performances individuelles.</p>
        </div>
    </x-slot>

    @if(isset($noEdition) && $noEdition)
        <x-edition-required />
    @else
    <!-- Filtres -->
    <div class="enterprise-card p-5 mb-6">
        <form method="GET" action="{{ route('classements.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="enterprise-label">Discipline</label>
                <select name="discipline_id" class="enterprise-input px-4 appearance-none" onchange="this.form.submit()">
                    <option value="">Toutes les disciplines</option>
                    @foreach($disciplines as $discipline)
                        <option value="{{ $discipline->id }}" {{ $disciplineId == $discipline->id ? 'selected' : '' }}>{{ $discipline->nom }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="enterprise-btn-primary h-[48px]">Filtrer</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Classement par équipe (8 cols) -->
        <div class="lg:col-span-8">
            @if($classement->count() > 0)
                <div class="enterprise-card overflow-hidden">
                    <div class="px-5 py-3 flex items-center justify-between border-b border-border-color bg-white">
                        <h2 class="text-[14px] font-bold text-text-primary">Classement Général</h2>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#DCFCE7] text-[#166534]">En cours</span>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-border-color">
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest w-16 text-center">#</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest">Équipe</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">Pts</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">J</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">G</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">N</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">D</th>
                                <th class="px-5 py-2.5 text-[10px] font-bold text-text-muted uppercase tracking-widest text-center">Diff</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @foreach($classement as $index => $stat)
                                <tr class="hover:bg-[#F0F4FA] transition-colors">
                                    <td class="px-5 py-3 text-center">
                                        @if($index === 0)
                                            <div class="mx-auto w-6 h-6 rounded flex items-center justify-center text-[11px] font-bold bg-[#FEF3C7] text-[#92400E]">1</div>
                                        @elseif($index === 1)
                                            <div class="mx-auto w-6 h-6 rounded flex items-center justify-center text-[11px] font-bold bg-[#F1F5F9] text-[#475569]">2</div>
                                        @elseif($index === 2)
                                            <div class="mx-auto w-6 h-6 rounded flex items-center justify-center text-[11px] font-bold bg-[#FEF0E7] text-[#9A3412]">3</div>
                                        @else
                                            <span class="text-[11px] font-bold text-text-muted">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <p class="text-[13px] font-bold text-text-primary">{{ $stat['equipe']->nom }}</p>
                                        <p class="text-[10px] text-text-muted">{{ $stat['equipe']->faculte->nom ?? '' }}</p>
                                    </td>
                                    <td class="px-5 py-3 text-center text-[14px] font-mono font-black text-primary">{{ $stat['points'] }}</td>
                                    <td class="px-5 py-3 text-center text-[12px] font-mono text-text-muted">{{ $stat['matchs_joues'] }}</td>
                                    <td class="px-5 py-3 text-center text-[12px] font-mono font-bold text-[#166534]">{{ $stat['victoires'] }}</td>
                                    <td class="px-5 py-3 text-center text-[12px] font-mono font-bold text-[#475569]">{{ $stat['nuls'] }}</td>
                                    <td class="px-5 py-3 text-center text-[12px] font-mono font-bold text-[#991B1B]">{{ $stat['defaites'] }}</td>
                                    <td class="px-5 py-3 text-center text-[12px] font-mono font-bold {{ $stat['difference'] >= 0 ? 'text-[#166534]' : 'text-[#991B1B]' }}">{{ $stat['difference'] >= 0 ? '+' : '' }}{{ $stat['difference'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="enterprise-card p-12 text-center">
                    <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="text-[14px] font-semibold text-text-primary">Sélectionnez une discipline</p>
                    <p class="text-[13px] text-text-muted mt-1">Utilisez le filtre ci-dessus pour afficher le classement.</p>
                </div>
            @endif
        </div>

        <!-- Meilleurs buteurs (4 cols) -->
        <div class="lg:col-span-4">
            <div class="enterprise-card overflow-hidden">
                <div class="px-5 py-4 border-b border-border-color bg-white">
                    <h2 class="text-[14px] font-bold text-text-primary">Meilleures Performances</h2>
                </div>
                <div class="p-2">
                    @forelse($meilleursButeurs as $index => $buteur)
                        @php
                            $maxButs = $meilleursButeurs->first()->buts > 0 ? $meilleursButeurs->first()->buts : 1;
                            $percent = ($buteur->buts / $maxButs) * 100;
                            $rankClass = match($index) {
                                0 => 'bg-[#FEF3C7] text-[#92400E]',
                                1 => 'bg-[#F1F5F9] text-[#475569]',
                                2 => 'bg-[#FEF0E7] text-[#9A3412]',
                                default => 'bg-[#F8FAFC] text-slate-500',
                            };
                        @endphp
                        <div class="p-3 hover:bg-[#F8FAFC] rounded-lg transition-colors mb-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-bold {{ $rankClass }} shrink-0">{{ $index + 1 }}</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12px] font-bold text-text-primary truncate">{{ $buteur->prenom }} {{ $buteur->nom }}</p>
                                    <p class="text-[10px] text-text-muted truncate">{{ $buteur->equipe->nom ?? '' }}</p>
                                </div>
                                <span class="text-[13px] font-mono font-black text-primary shrink-0">{{ $buteur->buts }}</span>
                            </div>
                            <div class="ml-9 w-[calc(100%-36px)] h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[12px] text-text-muted">Aucune donnée de performance.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
