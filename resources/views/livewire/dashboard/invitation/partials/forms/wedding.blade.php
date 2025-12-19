@php
    $labels = $category === 'Engagement' 
        ? ['groom' => 'Pria', 'bride' => 'Wanita']
        : ['groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'];
@endphp
<div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
    @foreach ($labels as $type => $label)
        <div class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.5)]">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-[#333333]">
                <div class="w-8 h-8 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
                    <i class="fa-solid {{ $type == 'groom' ? 'fa-mars' : 'fa-venus' }}"></i>
                </div>
                <h4 class="font-serif font-bold text-xl text-[#E0E0E0]">{{ $label }}</h4>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Panggilan</label>
                    <input type="text" wire:model="couple.{{ $type }}.nickname"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                </div>
                <div>
                    <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Lengkap</label>
                    <input type="text" wire:model="couple.{{ $type }}.fullname"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                </div>
                <div>
                    <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ayah</label>
                    <input type="text" wire:model="couple.{{ $type }}.father"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                </div>
                <div>
                    <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama Ibu</label>
                    <input type="text" wire:model="couple.{{ $type }}.mother"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                </div>
                <div>
                    <label class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Instagram (Tanpa @)</label>
                    <div class="relative flex items-center gap-x-2">
                        <span class=" text-[#D4AF37]"><i class="fa-brands fa-instagram"></i></span>
                        <input type="text" wire:model="couple.{{ $type }}.instagram"
                            class="w-full pl-10 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
