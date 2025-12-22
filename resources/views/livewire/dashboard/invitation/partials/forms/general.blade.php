<div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-[#333333]">
        <div class="w-10 h-10 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <h4 class="font-serif font-bold text-xl text-[#E0E0E0]">Profil Utama</h4>
        </div>
    </div>
    <div class="space-y-5">
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama / Judul</label>
            <input type="text" wire:model="couple.name"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Deskripsi Singkat</label>
            <textarea wire:model="couple.description" rows="4"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all"></textarea>
        </div>
    </div>
</div>
