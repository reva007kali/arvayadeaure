@props(['invitation', 'guest'])

@php
    $data = $invitation->couple_data;
    $events = $invitation->event_data ?? [];
    $gallery = $invitation->gallery_data ?? [];
    $primaryColor = $invitation->theme_config['primary_color'] ?? '#FF6B6B'; // Default Red/Pink
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

<div class="min-h-screen bg-yellow-50 font-sans text-gray-800 overflow-x-hidden">
    {{-- Hero --}}
    <section class="h-screen relative flex flex-col items-center justify-center text-center bg-white overflow-hidden">
        {{-- Confetti Background (CSS Pattern) --}}
        <div class="absolute inset-0 opacity-10" 
             style="background-image: radial-gradient(#FF6B6B 2px, transparent 2px), radial-gradient(#4ECDC4 2px, transparent 2px); background-size: 30px 30px; background-position: 0 0, 15px 15px;">
        </div>

        <div class="relative z-10 animate-bounce-slow">
            <p class="text-xl font-bold text-[#4ECDC4] tracking-widest uppercase mb-4">You Are Invited To</p>
            <h1 class="text-6xl md:text-8xl font-black text-[{{ $primaryColor }}] mb-2 drop-shadow-lg" style="font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;">
                {{ $data['name'] ?? 'Name' }}'s
            </h1>
            <div class="inline-block bg-[#4ECDC4] text-white text-2xl md:text-4xl font-bold px-8 py-2 rounded-full transform -rotate-2 shadow-lg mb-8">
                {{ $data['age'] ?? '1st' }} Birthday Party!
            </div>
            
            <div class="w-64 h-64 mx-auto rounded-full border-8 border-white shadow-2xl overflow-hidden mb-8 transform hover:scale-105 transition duration-500">
                <img src="{{ !empty($gallery['cover']) ? asset($gallery['cover']) : 'https://placehold.co/400x400?text=Photo' }}" 
                     class="w-full h-full object-cover">
            </div>

            @if($guest)
                <div class="mt-4 bg-white p-4 rounded-2xl shadow-xl border-2 border-dashed border-gray-200 inline-block">
                    <p class="text-xs font-bold text-gray-400 uppercase">Special Guest</p>
                    <p class="text-xl font-black text-gray-800">{{ $guest->name }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Profile --}}
    <section class="py-20 px-6 bg-[{{ $primaryColor }}]">
        <div class="container mx-auto max-w-2xl bg-white rounded-3xl p-8 md:p-12 shadow-2xl text-center transform -translate-y-20">
            <h2 class="text-3xl font-bold mb-6">Hello Friends!</h2>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                {{ $data['quote'] ?? "Let's celebrate this special day together with joy, laughter, and lots of cake!" }}
            </p>
            
            <div class="grid grid-cols-2 gap-4 text-left bg-gray-50 p-6 rounded-2xl">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Full Name</p>
                    <p class="font-bold text-lg">{{ $data['fullname'] ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Born On</p>
                    <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($data['birth_date'] ?? now())->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Dad</p>
                    <p class="font-bold">{{ $data['father'] ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Mom</p>
                    <p class="font-bold">{{ $data['mother'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Event --}}
    <section class="pb-20 px-6">
        <div class="container mx-auto max-w-4xl">
            <h2 class="text-4xl font-black text-center mb-12 text-[{{ $primaryColor }}]">Save The Date!</h2>
            
            <div class="grid md:grid-cols-1 gap-8">
                @foreach($events as $event)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-lg flex flex-col md:flex-row">
                        <div class="bg-[#4ECDC4] p-8 flex flex-col items-center justify-center text-white md:w-1/3">
                            <span class="text-6xl font-black">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                            <span class="text-2xl font-bold uppercase">{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('F') }}</span>
                            <span class="opacity-80">{{ \Carbon\Carbon::parse($event['date'])->format('Y') }}</span>
                        </div>
                        <div class="p-8 md:w-2/3">
                            <h3 class="text-2xl font-bold mb-2">{{ $event['title'] }}</h3>
                            <p class="text-gray-500 mb-6 flex items-center gap-2">
                                <i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB - Finish
                            </p>
                            
                            <div class="mb-6">
                                <p class="font-bold text-lg">{{ $event['location'] }}</p>
                                <p class="text-gray-500">{{ $event['address'] }}</p>
                            </div>

                            @if(!empty($event['map_link']))
                                <a href="{{ $event['map_link'] }}" target="_blank" 
                                   class="inline-block px-6 py-3 bg-gray-800 text-white rounded-xl font-bold hover:bg-black transition">
                                    Open Google Maps
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Gallery --}}
    @if(!empty($gallery['moments']))
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Sweet Memories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($gallery['moments'] as $img)
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition transform hover:scale-105">
                        <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
