<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'bride' }} Wedding Invitation">
    <meta property="og:title"
        content="{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'bride' }} Wedding Invitation">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#1a1a1a">
    <meta property="og:image" content="/logo.png">
    
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/logo.png">
    <link rel="apple-touch-icon" href="/logo.png">


    {{ $head }}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="antialiased bg-black">


    {{ $slot }}

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .catch(function(e) { console.warn('SW registration failed', e) })
            })
        }
    </script>
</body>

</html>
