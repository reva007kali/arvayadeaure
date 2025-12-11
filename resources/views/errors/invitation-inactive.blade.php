<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Undangan Belum Aktif - Arvaya De Aure</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .font-display {
            font-family: 'Cinzel Decorative', cursive;
        }

        .font-sans {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F9F7F2] text-[#5E4926] font-sans h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full text-center">
        {{-- Icon Gembok --}}
        <div
            class="w-20 h-20 bg-[#F2ECDC] rounded-full flex items-center justify-center mx-auto mb-6 border border-[#E6D9B8] shadow-sm animate-pulse">
            <i class="fa-solid fa-lock text-3xl text-[#B89760]"></i>
        </div>

        <h1 class="font-display text-3xl font-bold mb-3">Undangan Belum Aktif</h1>

        <p class="text-[#7C6339] text-sm mb-8 leading-relaxed">
            Mohon maaf, tautan undangan ini belum dapat diakses publik karena masih dalam tahap persiapan atau
            verifikasi oleh pemilik acara.
        </p>

        <div class="bg-white p-6 rounded-2xl border border-[#E6D9B8] shadow-sm mb-8">
            <p class="text-xs font-bold uppercase tracking-widest text-[#9A7D4C] mb-2">Pesan Untuk Pemilik Acara</p>
            <p class="text-xs text-[#5E4926]">
                Jika Anda adalah pemilik undangan ini, silakan login ke Dashboard dan selesaikan pembayaran untuk
                mengaktifkan undangan.
            </p>
        </div>

        <a href="{{ route('login') }}"
            class="inline-block px-8 py-3 bg-[#B89760] text-white rounded-full font-bold uppercase text-xs tracking-widest hover:bg-[#9A7D4C] transition shadow-lg">
            Login Dashboard
        </a>

        <div class="mt-8 text-[10px] text-[#9A7D4C] uppercase tracking-[0.2em]">
            Arvaya De Aure
        </div>
    </div>

</body>

</html>
