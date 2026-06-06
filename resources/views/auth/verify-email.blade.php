<x-guest-layout>
    <div class="flex min-h-screen w-full items-center justify-center bg-bg-app p-8">
        <div class="enterprise-card p-8 w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-[22px] font-bold text-text-primary">Vérification de l'email</h2>
                <p class="text-[13px] text-text-muted mt-2">Un lien de vérification a été envoyé à votre adresse email.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 bg-[#ECFDF5] border border-[#A7F3D0] text-[#065F46] rounded-[8px] text-[13px] font-semibold">
                    Un nouveau lien a été envoyé à votre adresse.
                </div>
            @endif

            <div class="flex items-center justify-between gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="enterprise-btn-primary">Renvoyer le lien</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="enterprise-btn-secondary">Se déconnecter</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
