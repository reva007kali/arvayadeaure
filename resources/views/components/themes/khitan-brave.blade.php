@props(['invitation', 'guest'])

@php
    $data = $invitation->couple_data;
    $events = $invitation->event_data ?? [];
    $gallery = $invitation->gallery_data ?? [];
    $primaryColor = $invitation->theme_config['primary_color'] ?? '#1E40AF'; // Blue
@endphp

@slot('head')
<title>Tasykuran Khitanan {{ $data['child_name'] ?? 'Nama Anak' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Cutive+Mono&family=Parisienne&family=Special+Elite&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400&family=Kalam:wght@300;400;700&family=Nanum+Pen+Script&display=swap"
    rel="stylesheet">
@endslot

<div class="min-h-screen bg-slate-50 font-sans text-slate-900 overflow-x-hidden">

    {{-- Hero --}}
    <section class="h-screen relative flex items-center justify-center bg-[{{ $primaryColor }}] overflow-hidden">
        {{-- Geometric Shapes --}}
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
        </div>

        <div class="relative z-10 text-center px-6 text-white animate-fade-in-up">
            <div
                class="inline-block px-4 py-1 border border-white/30 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                Tasyakuran Khitan
            </div>

            <h1 class="text-5xl md:text-7xl font-bold mb-4 tracking-tight">
                {{ $data['child_name'] ?? 'Nama Anak' }}
            </h1>

            <div class="w-24 h-1 bg-white/30 mx-auto mb-8 rounded-full"></div>

            <div
                class="w-40 h-40 md:w-56 md:h-56 mx-auto bg-white p-2 rounded-full shadow-2xl mb-8 transform hover:scale-105 transition duration-500">
                <img src="{{ !empty($gallery['cover']) ? asset($gallery['cover']) : 'https://placehold.co/400x400?text=Boy' }}"
                    class="w-full h-full object-cover rounded-full">
            </div>

            <p class="text-lg opacity-90 max-w-lg mx-auto mb-8">
                Putra dari Bapak {{ $data['father'] ?? '...' }} & Ibu {{ $data['mother'] ?? '...' }}
            </p>

            @if($guest)
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 inline-block border border-white/10">
                    <p class="text-[10px] uppercase tracking-widest opacity-70 mb-1">Tamu Undangan</p>
                    <p class="font-bold text-xl">{{ $guest->name }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Content --}}
    <section class="py-20 px-6">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-16">
                <p class="text-slate-500 italic mb-6">
                    "{{ $data['quote'] ?? 'Mohon doa restu agar anak kami menjadi anak yang sholeh, berbakti kepada orang tua, dan berguna bagi agama dan bangsa.' }}"
                </p>
                <h2 class="text-3xl font-bold text-[{{ $primaryColor }}]">Detail Acara</h2>
            </div>

            <div class="grid gap-6">
                @foreach($events as $event)
                    <div
                        class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100 group hover:border-[{{ $primaryColor }}] transition">
                        <div
                            class="bg-slate-100 p-8 flex flex-col items-center justify-center md:w-48 group-hover:bg-[{{ $primaryColor }}] group-hover:text-white transition">
                            <span class="text-5xl font-bold">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                            <span
                                class="text-sm font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('M Y') }}</span>
                        </div>
                        <div class="p-8 flex-1">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                <h3 class="text-2xl font-bold text-slate-800">{{ $event['title'] }}</h3>
                                <span
                                    class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold flex items-center gap-2 w-fit">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB
                                </span>
                            </div>

                            <div class="flex items-start gap-3 text-slate-600 mb-6">
                                <i class="fa-solid fa-map-pin mt-1 text-[{{ $primaryColor }}]"></i>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $event['location'] }}</p>
                                    <p class="text-sm">{{ $event['address'] }}</p>
                                </div>
                            </div>

                            @if(!empty($event['map_link']))
                                <a href="{{ $event['map_link'] }}" target="_blank"
                                    class="text-[{{ $primaryColor }}] font-bold text-sm hover:underline flex items-center gap-2">
                                    Buka Google Maps <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>