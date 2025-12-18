<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

{{-- PWA & SEO Meta Tags --}}
<meta name="theme-color" content="#1a1a1a">
<meta name="description" content="Arvaya De Aure - Undangan Pernikahan Digital Premium">
<meta property="og:title" content="{{ $title ?? config('app.name') }}">
<meta property="og:image" content="/logo.png">

<link rel="manifest" href="/manifest.json">
<link rel="icon" type="image/png" href="/logo.png">
<link rel="apple-touch-icon" href="/logo.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<!-- Fonts (Sama seperti Landing Page) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
