<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('matchs.index') }}" class="w-10 h-10 rounded-full bg-white border border-border-color flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Détails du Match</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">{{ $match->discipline->nom }} · {{ $match->phase ?? '' }}</p>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('matchs.edit', $match) }}" class="enterprise-btn-secondary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Modifier
        </a>
        @endif
    </x-slot>

    <!-- Scoreboard -->
    <div class="enterprise-card p-8 mb-6">
        <div class="flex items-center justify-center gap-8">
            <!-- Équipe A -->
            <div class="text-center flex-1">
                <div class="w-14 h-14 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center text-[18px] font-bold text-primary mx-auto mb-2">
                    {{ substr($match->equipeA->nom ?? 'A', 0, 2) }}
                </div>
                <h3 class="text-[16px] font-bold text-text-primary">{{ $match->equipeA->nom }}</h3>
                <p class="text-[12px] text-text-muted">{{ $match->equipeA->faculte->nom ?? '' }}</p>
                
                @php
                    $buteurs = $match->buteurs;
                    if (is_string($buteurs)) $buteurs = json_decode($buteurs, true);
                    $buteursA = $buteurs['equipe_a'] ?? [];
                @endphp
                @if($match->statut === 'joue' && !empty($buteursA))
                    <div class="mt-4 text-left inline-block space-y-1">
                        @foreach($buteursA as $buteur)
                            @php $joueur = \App\Models\Joueur::find($buteur['id'] ?? null); @endphp
                            @if($joueur)
                                <p class="text-[11px] text-text-muted flex items-center gap-1 font-medium">
                                    <svg class="w-3 h-3 text-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                                    {{ $joueur->nom }} <span class="text-primary font-bold">({{ $buteur['nb_buts'] ?? 0 }})</span>
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Score -->
            <div class="text-center shrink-0">
                @if($match->statut === 'joue')
                    <div class="flex items-center gap-3">
                        <span class="text-[36px] font-mono font-black text-text-primary">{{ $match->score_a }}</span>
                        <span class="text-[18px] font-bold text-text-muted">-</span>
                        <span class="text-[36px] font-mono font-black text-text-primary">{{ $match->score_b }}</span>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-[#DCFCE7] text-[#166534] mt-2">Terminé</span>
                @else
                    <span class="text-[18px] font-bold text-text-muted">VS</span>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-[#DBEAFE] text-[#1E40AF]">Planifié</span>
                    </div>
                @endif
            </div>

            <!-- Équipe B -->
            <div class="text-center flex-1">
                <div class="w-14 h-14 rounded-full bg-accent/10 border-2 border-accent/20 flex items-center justify-center text-[18px] font-bold text-accent mx-auto mb-2">
                    {{ substr($match->equipeB->nom ?? 'B', 0, 2) }}
                </div>
                <h3 class="text-[16px] font-bold text-text-primary">{{ $match->equipeB->nom }}</h3>
                <p class="text-[12px] text-text-muted">{{ $match->equipeB->faculte->nom ?? '' }}</p>

                @php
                    $buteursB = $buteurs['equipe_b'] ?? [];
                @endphp
                @if($match->statut === 'joue' && !empty($buteursB))
                    <div class="mt-4 text-right inline-block space-y-1">
                        @foreach($buteursB as $buteur)
                            @php $joueur = \App\Models\Joueur::find($buteur['id'] ?? null); @endphp
                            @if($joueur)
                                <p class="text-[11px] text-text-muted flex items-center justify-end gap-1 font-medium">
                                    <span class="text-primary font-bold">({{ $buteur['nb_buts'] ?? 0 }})</span> {{ $joueur->nom }}
                                    <svg class="w-3 h-3 text-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Infos -->
        <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Date</p>
                <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $match->date_match->format('d M Y • H:i') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Lieu</p>
                <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $match->lieu ?? 'Non défini' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-text-muted uppercase tracking-wider">Phase</p>
                <p class="text-[14px] font-semibold text-text-primary mt-1">{{ $match->phase ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Score Entry Form (only if match not yet played) -->
    @if($match->statut !== 'joue' && in_array(auth()->user()->role, ['admin', 'staff']))
        <div class="enterprise-card p-8" x-data="{ 
            scoreA: 0, 
            scoreB: 0,
            buteursA: [],
            buteursB: [],
            addButeurA() { this.buteursA.push({ id: '', nb_buts: 1 }); },
            removeButeurA(index) { this.buteursA.splice(index, 1); },
            addButeurB() { this.buteursB.push({ id: '', nb_buts: 1 }); },
            removeButeurB(index) { this.buteursB.splice(index, 1); }
        }">
            <h2 class="text-[11px] font-bold text-text-muted uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Saisie du Score et des Buteurs</h2>
            <form action="{{ route('matchs.score', $match) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-6">
                    <!-- Equipe A -->
                    <div>
                        <div class="mb-4">
                            <label class="enterprise-label">{{ $match->equipeA->nom }} (Score)</label>
                            <input type="number" name="score_a" x-model="scoreA" min="0" class="enterprise-input font-mono text-[24px] text-center font-bold h-16" required>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="enterprise-label">Buteurs ({{ $match->equipeA->nom }})</label>
                            <template x-for="(buteur, index) in buteursA" :key="index">
                                <div class="flex gap-2 items-center">
                                    <select :name="'buteurs_a['+index+'][id]'" class="enterprise-input h-10 text-[13px] flex-1" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($match->equipeA->joueurs as $joueur)
                                            <option value="{{ $joueur->id }}">{{ $joueur->nom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" :name="'buteurs_a['+index+'][nb_buts]'" x-model="buteur.nb_buts" min="1" class="enterprise-input h-10 w-16 text-center font-bold" title="Nombre de buts">
                                    <button type="button" @click="removeButeurA(index)" class="text-danger hover:bg-red-50 p-2 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addButeurA()" class="text-[12px] font-bold text-primary flex items-center gap-1 hover:underline">
                                + Ajouter un buteur
                            </button>
                        </div>
                    </div>

                    <!-- Equipe B -->
                    <div>
                        <div class="mb-4">
                            <label class="enterprise-label">{{ $match->equipeB->nom }} (Score)</label>
                            <input type="number" name="score_b" x-model="scoreB" min="0" class="enterprise-input font-mono text-[24px] text-center font-bold h-16" required>
                        </div>

                        <div class="space-y-3">
                            <label class="enterprise-label">Buteurs ({{ $match->equipeB->nom }})</label>
                            <template x-for="(buteur, index) in buteursB" :key="index">
                                <div class="flex gap-2 items-center">
                                    <select :name="'buteurs_b['+index+'][id]'" class="enterprise-input h-10 text-[13px] flex-1" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($match->equipeB->joueurs as $joueur)
                                            <option value="{{ $joueur->id }}">{{ $joueur->nom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" :name="'buteurs_b['+index+'][nb_buts]'" x-model="buteur.nb_buts" min="1" class="enterprise-input h-10 w-16 text-center font-bold" title="Nombre de buts">
                                    <button type="button" @click="removeButeurB(index)" class="text-danger hover:bg-red-50 p-2 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addButeurB()" class="text-[12px] font-bold text-primary flex items-center gap-1 hover:underline">
                                + Ajouter un buteur
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="enterprise-btn-primary gap-2 h-12 px-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Enregistrer le résultat final
                    </button>
                </div>
            </form>
        </div>
    @endif
</x-app-layout>
