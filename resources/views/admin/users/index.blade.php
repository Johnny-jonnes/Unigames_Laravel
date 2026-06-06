<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-[20px] font-bold text-text-primary tracking-tight">Gestion du Staff</h1>
                <p class="text-[13px] font-medium text-text-muted mt-0.5">Administrez les comptes des organisateurs UniGames.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="enterprise-btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Ajouter un membre
            </a>
        </div>
    </x-slot>

    <div class="enterprise-card overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-border-color">
                    <th class="px-6 py-4 text-[11px] font-bold text-text-muted uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-text-muted uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-text-muted uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-text-muted uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[12px] font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-[14px] font-semibold text-text-primary">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-text-muted">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-accent/10 text-accent uppercase">Administrateur</span>
                            @elseif($user->role === 'staff')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-primary uppercase">Organisateur</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 uppercase">Lecteur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-primary hover:text-primary-light p-2 rounded-lg hover:bg-blue-50 transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer ce compte ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-danger hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors" title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
