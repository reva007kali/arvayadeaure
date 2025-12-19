<div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm text-center">
    <div
        class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center text-[#D4AF37] mx-auto mb-4 text-2xl">
        <i class="fa-brands fa-youtube"></i>
    </div>
    <h4 class="font-bold text-[#E0E0E0] text-lg mb-2">Latar Musik (YouTube)</h4>
    <p class="text-sm text-[#A0A0A0] mb-6 max-w-md mx-auto">Tempelkan link video YouTube
        lagu yang Anda inginkan. Kami akan memutarnya secara otomatis di undangan.</p>

    <div class="relative max-w-xl mx-auto">
        <span
            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-red-500">
            <i class="fa-solid fa-play"></i>
        </span>
        <input type="text" wire:model="theme.music_url"
            placeholder="https://www.youtube.com/watch?v=..."
            class="w-full pl-10 py-3 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
    </div>

    @if (!empty($theme['music_url']))
        <div
            class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-green-500 bg-green-900/20 px-4 py-2 rounded-full border border-green-900/30 animate-fade-in-up">
            <i class="fa-solid fa-circle-check"></i> Link valid
        </div>
    @endif
</div>
