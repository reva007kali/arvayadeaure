@props(['invitation', 'guest'])

@php
    $data = $invitation->couple_data; // contains title, organizer, description
    $events = $invitation->event_data ?? [];
    $gallery = $invitation->gallery_data ?? [];
    $primaryColor = $invitation->theme_config['primary_color'] ?? '#2563EB'; // Corporate Blue
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

<div class="min-h-screen bg-white font-sans text-gray-900 overflow-x-hidden">
    {{-- Header / Banner --}}
    <header class="relative bg-gray-900 text-white">
        <div class="absolute inset-0">
             @if(!empty($gallery['cover']))
                <img src="{{ asset($gallery['cover']) }}" class="w-full h-full object-cover opacity-30">
             @else
                <div class="w-full h-full bg-gradient-to-r from-gray-900 to-gray-800 opacity-90"></div>
             @endif
        </div>
        
        <div class="relative z-10 container mx-auto px-6 py-24 md:py-32">
            <div class="max-w-3xl">
                <p class="text-[{{ $primaryColor }}] font-bold uppercase tracking-widest mb-4">Official Invitation</p>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                    {{ $data['title'] ?? 'Event Title Here' }}
                </h1>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-1 bg-[{{ $primaryColor }}]"></div>
                    <p class="text-xl text-gray-300">Organized by <span class="text-white font-bold">{{ $data['organizer'] ?? 'Organization Name' }}</span></p>
                </div>

                @if($guest)
                    <div class="inline-flex items-center gap-4 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg border border-white/10">
                        <span class="text-sm text-gray-400 uppercase font-bold">Attendee:</span>
                        <span class="text-xl font-bold">{{ $guest->name }}</span>
                    </div>
                @endif
            </div>
        </div>
    </header>

    {{-- Description --}}
    <section class="py-16 px-6 border-b border-gray-100">
        <div class="container mx-auto max-w-4xl grid md:grid-cols-3 gap-12">
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold mb-6 text-gray-900">About This Event</h2>
                <div class="prose prose-lg text-gray-600">
                    <p class="whitespace-pre-line">{{ $data['description'] ?? 'Event description goes here...' }}</p>
                </div>
            </div>
            <div>
                 @if(!empty($gallery['moments']))
                    <div class="grid grid-cols-2 gap-2">
                         @foreach(array_slice($gallery['moments'], 0, 4) as $img)
                            <img src="{{ asset($img) }}" class="w-full h-24 object-cover rounded-lg">
                         @endforeach
                    </div>
                 @endif
            </div>
        </div>
    </section>

    {{-- Schedule --}}
    <section class="py-16 px-6 bg-gray-50">
        <div class="container mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold mb-8 text-gray-900 flex items-center gap-3">
                <i class="fa-regular fa-calendar-check text-[{{ $primaryColor }}]"></i> Event Schedule
            </h2>

            <div class="space-y-6">
                @foreach($events as $event)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <div class="flex-shrink-0 text-center md:text-left min-w-[100px]">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">{{ \Carbon\Carbon::parse($event['date'])->format('M Y') }}</p>
                                <p class="text-3xl font-extrabold text-[{{ $primaryColor }}]">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</p>
                                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($event['date'])->format('l') }}</p>
                            </div>
                            
                            <div class="flex-1 border-l-2 border-gray-100 pl-6 md:pl-8 ml-2 md:ml-0">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event['title'] }}</h3>
                                
                                <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-clock text-[{{ $primaryColor }}]"></i>
                                        {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} - End
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-[{{ $primaryColor }}]"></i>
                                        {{ $event['location'] }}
                                    </div>
                                </div>
                                
                                <p class="text-gray-500 text-sm mb-4">{{ $event['address'] }}</p>

                                @if(!empty($event['map_link']))
                                    <a href="{{ $event['map_link'] }}" target="_blank" class="text-sm font-bold text-[{{ $primaryColor }}] hover:underline">
                                        View on Map &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ $data['organizer'] ?? 'Organizer' }}. All rights reserved.</p>
        <p class="mt-2">Powered by Arvaya De Aure</p>
    </footer>
</div>
