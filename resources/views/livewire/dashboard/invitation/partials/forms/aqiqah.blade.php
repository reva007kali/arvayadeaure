<div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-[#333333]">
        <div class="w-10 h-10 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
            <i class="fa-solid fa-baby"></i>
        </div>
        <div>
            <h4 class="font-serif font-bold text-xl text-[#E0E0E0]">Data Anak</h4>
            <p class="text-xs text-[#A0A0A0]">Isi detail lengkap anak untuk {{ $category }}</p>
        </div>
    </div>
    <div class="space-y-5">
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Panggilan Anak</label>
            <input type="text" wire:model="couple.child_name"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Lengkap Anak</label>
            <input type="text" wire:model="couple.child_fullname"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div>
            <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Tanggal Lahir</label>
            <input type="date" wire:model="couple.birth_date"
                class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ayah</label>
                <input type="text" wire:model="couple.father"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
            <div>
                <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ibu</label>
                <input type="text" wire:model="couple.mother"
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
            </div>
        </div>
    </div>
</div>
