<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen font-sans antialiased">

    <div class="fixed inset-0 z-0">
        <img src="/img/login.png" alt="Background" class="w-full h-full object-cover">
        {{-- Overlay to ensure text readability if needed, keeping it minimal --}}
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-5 md:p-10">
        {{ $slot }}
    </div>

    @fluxScripts
</body>

</html>