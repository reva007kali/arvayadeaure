<div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-[#333333]">
        <div class="w-10 h-10 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
            <i class="fa-solid fa-cake-candles"></i>
        </div>
        <div>
            <h4 class="font-serif font-bold text-xl text-[#E0E0E0]">Profil Yang Ulang Tahun</h4>
            <p class="text-xs text-[#A0A0A0]">Isi detail lengkap yang berulang tahun</p>
        </div>
    </div>
    <div class="space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Panggilan</label>
                <input type="text" wire:model="couple.name"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Ulang Tahun Ke-</label>
                <input type="text" wire:model="couple.age" placeholder="Contoh: 17th"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Lengkap</label>
            <input type="text" wire:model="couple.fullname"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Tanggal Lahir</label>
            <input type="date" wire:model="couple.birth_date"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ayah (Opsional)</label>
                <input type="text" wire:model="couple.father"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ibu (Opsional)</label>
                <input type="text" wire:model="couple.mother"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Instagram (Tanpa @)</label>
            <div class="relative flex items-center gap-x-2">
                <span class=" text-[#D4AF37]"><i class="fa-brands fa-instagram"></i></span>
                <input type="text" wire:model="couple.instagram"
                    class="w-full pl-10 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
        </div>
    </div>
</div>
