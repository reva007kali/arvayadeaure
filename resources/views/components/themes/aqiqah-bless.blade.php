@props(['invitation', 'guest'])

@php
    $data = $invitation->couple_data;
    $events = $invitation->event_data ?? [];
    $gallery = $invitation->gallery_data ?? [];
    $primaryColor = $invitation->theme_config['primary_color'] ?? '#0D9488'; // Teal Green
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

<div class="min-h-screen bg-[#FDFBF7] font-serif text-slate-800 overflow-x-hidden">
    {{-- Hero --}}
    <section class="h-screen relative flex items-center justify-center text-center px-6">
        {{-- Ornament Top --}}
        <img src="https://i.imgur.com/u5x1D5V.png" class="absolute top-0 left-0 w-32 md:w-64 opacity-50 rotate-180">
        <img src="https://i.imgur.com/u5x1D5V.png" class="absolute top-0 right-0 w-32 md:w-64 opacity-50 rotate-180 scale-x-[-1]">

        <div class="relative z-10 animate-fade-in-up max-w-2xl">
            <div class="mb-6 mx-auto w-16">
                <img src="https://cdn-icons-png.flaticon.com/512/2880/2880659.png" class="w-full opacity-60 grayscale">
            </div>
            
            <p class="text-sm uppercase tracking-[0.3em] text-[{{ $primaryColor }}] mb-6">Tasyakuran Aqiqah</p>
            
            <div class="relative w-48 h-48 mx-auto mb-8">
                <div class="absolute inset-0 rounded-full border border-[{{ $primaryColor }}] opacity-30 animate-ping"></div>
                <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-2xl relative z-10">
                    <img src="{{ !empty($gallery['cover']) ? asset($gallery['cover']) : 'https://placehold.co/400x400?text=Baby' }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-4 text-[{{ $primaryColor }}]">
                {{ $data['child_name'] ?? 'Nama Bayi' }}
            </h1>
            <p class="text-lg text-slate-500">{{ $data['child_fullname'] ?? 'Nama Lengkap Bayi' }}</p>

            @if($guest)
                <div class="mt-12 border-t border-slate-200 pt-6">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Kepada Yth:</p>
                    <p class="text-xl font-bold">{{ $guest->name }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Doa / Intro --}}
    <section class="py-20 px-6 bg-white">
        <div class="container mx-auto max-w-3xl text-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/Basmala.svg" class="h-12 mx-auto mb-8 opacity-70">
            
            <p class="text-lg leading-loose text-slate-600 mb-8">
                "{{ $data['quote'] ?? 'Semoga menjadi anak yang sholeh/sholehah, berbakti kepada kedua orang tua, dan berguna bagi agama, nusa, dan bangsa.' }}"
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 bg-[#FDFBF7] p-8 rounded-2xl border border-slate-100">
                <div>
                    <p class="text-xs uppercase tracking-widest text-slate-400 mb-2">Ayah</p>
                    <p class="text-xl font-bold text-[{{ $primaryColor }}]">{{ $data['father'] ?? '...' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest text-slate-400 mb-2">Ibu</p>
                    <p class="text-xl font-bold text-[{{ $primaryColor }}]">{{ $data['mother'] ?? '...' }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Event --}}
    <section class="py-20 px-6 bg-[{{ $primaryColor }}] text-white">
        <div class="container mx-auto max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-12">Insya Allah akan dilaksanakan pada:</h2>
            
            <div class="grid md:grid-cols-1 gap-6">
                @foreach($events as $event)
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-2xl">
                        <h3 class="text-2xl font-bold mb-4">{{ $event['title'] }}</h3>
                        <p class="text-4xl font-bold mb-2">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</p>
                        <p class="text-xl uppercase tracking-widest mb-6">{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('F Y') }}</p>
                        
                        <div class="flex flex-col md:flex-row justify-center gap-8 text-sm opacity-90">
                            <div class="flex items-center justify-center gap-2">
                                <i class="fa-regular fa-clock"></i>
                                <span>Pukul {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $event['location'] }}</span>
                            </div>
                        </div>

                        <p class="mt-6 text-sm opacity-80 max-w-xl mx-auto">{{ $event['address'] }}</p>
                        
                        @if(!empty($event['map_link']))
                            <a href="{{ $event['map_link'] }}" target="_blank" 
                               class="inline-block mt-8 px-8 py-3 bg-white text-[{{ $primaryColor }}] rounded-full font-bold hover:bg-slate-100 transition shadow-lg">
                                Lihat Lokasi
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
