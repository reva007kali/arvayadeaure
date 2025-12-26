<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Arvaya De Aure</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .error-text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="bg-[#1a1a1a] text-[#E0E0E0] font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-full h-full opacity-5 pointer-events-none" style="background-image: radial-gradient(#333 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-[#D4AF37] rounded-full blur-[150px] opacity-10"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-[#D4AF37] rounded-full blur-[150px] opacity-5"></div>

    <div class="relative z-10 text-center px-6 max-w-2xl mx-auto animate-fade-in-up">
        <!-- Code Display -->
        <div class="mb-6 relative inline-block">
             <h1 class="font-serif text-[6rem] md:text-[10rem] font-bold leading-none text-transparent bg-clip-text bg-gradient-to-b from-[#D4AF37] to-[#8a7224] opacity-90 select-none error-text-shadow">
                @yield('code')
            </h1>
        </div>

        <!-- Message -->
        <h2 class="font-serif text-2xl md:text-4xl font-bold text-[#E0E0E0] mb-4">
            @yield('message')
        </h2>

        <!-- Description -->
        <p class="text-[#A0A0A0] text-base md:text-lg mb-10 font-light max-w-md mx-auto leading-relaxed">
            @yield('description')
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ url('/') }}" class="px-8 py-3 rounded-full bg-[#D4AF37] text-[#121212] font-bold hover:bg-[#B4912F] transition shadow-[0_0_20px_rgba(212,175,55,0.3)] transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fa-solid fa-house"></i> Kembali ke Beranda
            </a>
            @yield('actions')
        </div>
    </div>
</body>
</html>
