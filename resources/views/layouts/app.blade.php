<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UniGames') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=DM+Mono:ital,wght@0,400;0,500;1,400;1,500&family=Syne:wght@700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-bg-app text-text-primary antialiased selection:bg-primary-light selection:text-white">
        <div class="min-h-screen flex w-full">
            
            <!-- Sidebar Enterprise (Fixed 260px) -->
            <x-sidebar />

            <!-- Main Content Wrapper (Margin Left 260px) -->
            <div class="flex-1 ml-[260px] flex flex-col min-h-screen w-[calc(100%-260px)]">
                
                <!-- Topbar Enterprise (Sticky 64px) -->
                <x-topbar />

                <!-- Page Content (Padding 32px as requested) -->
                <main class="flex-1 p-8">
                    <!-- Page Header Slot (if provided by view) -->
                    @if (isset($header))
                        <div class="mb-6 flex items-center justify-between">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-[#ECFDF5] border border-[#A7F3D0] text-[#065F46] rounded-[8px] text-[13px] font-semibold flex items-center shadow-sm">
                            <svg class="w-[18px] h-[18px] mr-2 text-[#10B981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Main View Slot -->
                    {{ $slot }}
                </main>
                
            </div>
        </div>
    </body>
</html>
