<div class="space-y-6 max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h4 class="font-bold text-[#E0E0E0] text-lg">Video Undangan (YouTube)</h4>
            <p class="text-xs text-[#A0A0A0]">Tambahkan video kenangan atau teaser pernikahan dari YouTube.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold {{ ($theme['video_enabled'] ?? true) ? 'text-[#D4AF37]' : 'text-[#555]' }}">
                {{ ($theme['video_enabled'] ?? true) ? 'Aktif' : 'Nonaktif' }}
            </span>
            <button wire:click="$toggle('theme.video_enabled')"
                class="w-12 h-6 rounded-full p-1 transition-colors duration-300 {{ ($theme['video_enabled'] ?? true) ? 'bg-[#D4AF37]' : 'bg-[#333]' }}">
                <div class="w-4 h-4 bg-white rounded-full shadow-md transform transition-transform duration-300 {{ ($theme['video_enabled'] ?? true) ? 'translate-x-6' : '' }}"></div>
            </button>
        </div>
    </div>

    @if (!($theme['video_enabled'] ?? true))
        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-8 text-center opacity-50">
            <p class="text-sm text-[#A0A0A0]">Fitur Video dinonaktifkan. Aktifkan toggle di atas untuk mulai mengedit.</p>
        </div>
    @else
        <div class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-sm">
            <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Link YouTube</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#D4AF37]">
                    <i class="fa-brands fa-youtube"></i>
                </span>
                <input type="text" wire:model="theme.video_url" aria-label="Link YouTube untuk video undangan"
                    placeholder="https://www.youtube.com/watch?v=..."
                    class="w-full pl-10 py-3 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
            </div>
            @error('theme.video_url')
                <p class="text-[10px] text-red-500 mt-2">{{ $message }}</p>
            @enderror
            <p class="text-[10px] text-[#666] mt-2">Tempelkan tautan YouTube. Video ditampilkan secara responsif di undangan.</p>
        </div>

        @if (!empty($theme['video_url']))
            <div class="mt-6">
                <div class="aspect-video rounded-2xl overflow-hidden border border-[#333333] bg-[#000]">
                    <iframe
                        src="https://www.youtube.com/embed/{{ preg_replace('/.*[?&]v=([^&]+).*/', '$1', $theme['video_url']) }}"
                        title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen class="w-full h-full"></iframe>
                </div>
            </div>
        @endif
    @endif
</div>

