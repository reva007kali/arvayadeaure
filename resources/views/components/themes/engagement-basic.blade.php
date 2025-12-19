@props(['invitation', 'guest'])

@php
    $couple = $invitation->couple_data;
    $events = $invitation->event_data ?? [];
    $gallery = $invitation->gallery_data ?? [];
    $primaryColor = $invitation->theme_config['primary_color'] ?? '#B89760';
@endphp

@slot('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Cutive+Mono&family=Parisienne&family=Special+Elite&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400&family=Kalam:wght@300;400;700&family=Nanum+Pen+Script&display=swap"
    rel="stylesheet">
@endslot



<div class="min-h-screen bg-stone-50 font-serif text-stone-800 overflow-x-hidden">
    {{-- Cover --}}
    <section class="h-screen relative flex items-center justify-center text-center bg-cover bg-center"
        style="background-image: url('{{ !empty($gallery['cover']) ? asset($gallery['cover']) : 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=2070&auto=format&fit=crop' }}');">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-white px-6 animate-fade-in-up">
            <p class="text-sm uppercase tracking-[0.3em] mb-4">The Engagement Of</p>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 font-handwriting">
                {{ $couple['groom']['nickname'] ?? 'Pria' }} & {{ $couple['bride']['nickname'] ?? 'Wanita' }}
            </h1>
            <p class="text-lg italic mb-8">{{ \Carbon\Carbon::parse($events[0]['date'] ?? now())->translatedFormat('l, d F Y') }}</p>
            
            @if($guest)
                <div class="mt-8 bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20 inline-block">
                    <p class="text-xs uppercase tracking-widest mb-2">Kepada Yth:</p>
                    <p class="text-2xl font-bold">{{ $guest->name }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Couple --}}
    <section class="py-20 px-6 container mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-[{{ $primaryColor }}]">Pasangan Berbahagia</h2>
            <p class="text-stone-500 italic">"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri..."</p>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center gap-12">
            {{-- Groom --}}
            <div class="text-center w-full md:w-1/3">
                <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-6 border-4 border-[{{ $primaryColor }}] shadow-xl">
                    <img src="{{ !empty($gallery['groom']) ? asset($gallery['groom']) : 'https://placehold.co/400x400?text=Groom' }}" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-bold mb-2">{{ $couple['groom']['fullname'] ?? 'Nama Pria' }}</h3>
                <p class="text-stone-500">Putra dari Bpk. {{ $couple['groom']['father'] ?? '...' }} & Ibu {{ $couple['groom']['mother'] ?? '...' }}</p>
                @if(!empty($couple['groom']['instagram']))
                    <a href="https://instagram.com/{{ $couple['groom']['instagram'] }}" target="_blank" class="inline-block mt-4 text-[{{ $primaryColor }}]">
                        <i class="fa-brands fa-instagram"></i> {{ $couple['groom']['instagram'] }}
                    </a>
                @endif
            </div>

            <div class="text-6xl text-[{{ $primaryColor }}] font-handwriting">&</div>

            {{-- Bride --}}
            <div class="text-center w-full md:w-1/3">
                <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-6 border-4 border-[{{ $primaryColor }}] shadow-xl">
                    <img src="{{ !empty($gallery['bride']) ? asset($gallery['bride']) : 'https://placehold.co/400x400?text=Bride' }}" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-bold mb-2">{{ $couple['bride']['fullname'] ?? 'Nama Wanita' }}</h3>
                <p class="text-stone-500">Putri dari Bpk. {{ $couple['bride']['father'] ?? '...' }} & Ibu {{ $couple['bride']['mother'] ?? '...' }}</p>
                @if(!empty($couple['bride']['instagram']))
                    <a href="https://instagram.com/{{ $couple['bride']['instagram'] }}" target="_blank" class="inline-block mt-4 text-[{{ $primaryColor }}]">
                        <i class="fa-brands fa-instagram"></i> {{ $couple['bride']['instagram'] }}
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Events --}}
    <section class="py-20 bg-[{{ $primaryColor }}]/5">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12 text-[{{ $primaryColor }}]">Rangkaian Acara</h2>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($events as $event)
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-l-4 border-[{{ $primaryColor }}]">
                        <h3 class="text-2xl font-bold mb-4">{{ $event['title'] }}</h3>
                        
                        <div class="space-y-3 text-stone-600">
                            <div class="flex items-start gap-3">
                                <i class="fa-regular fa-clock mt-1 text-[{{ $primaryColor }}]"></i>
                                <div>
                                    <p class="font-bold">{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('l, d F Y') }}</p>
                                    <p>{{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB - Selesai</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-map-location-dot mt-1 text-[{{ $primaryColor }}]"></i>
                                <div>
                                    <p class="font-bold">{{ $event['location'] }}</p>
                                    <p class="text-sm">{{ $event['address'] }}</p>
                                </div>
                            </div>
                        </div>

                        @if(!empty($event['map_link']))
                            <a href="{{ $event['map_link'] }}" target="_blank" 
                               class="mt-6 block w-full py-3 bg-[{{ $primaryColor }}] text-white text-center rounded-xl font-bold hover:opacity-90 transition">
                                <i class="fa-solid fa-location-arrow mr-2"></i> Petunjuk Arah
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#1a1a1a] text-white py-12 text-center">
        <h2 class="text-4xl font-handwriting mb-4">{{ $couple['groom']['nickname'] ?? 'Pria' }} & {{ $couple['bride']['nickname'] ?? 'Wanita' }}</h2>
        <p class="text-sm opacity-60">Created with Arvaya De Aure</p>
    </footer>
</div>
