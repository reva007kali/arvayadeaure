<div class="py-6 animate-fade-in-up dashboard-ui max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('dashboard.index') }}" wire:navigate
                class="text-[#A0A0A0] hover:text-[#D4AF37] transition flex items-center gap-2 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Notifikasi</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Update terbaru dari undangan Anda.</p>
        </div>

        @if($notifications->count() > 0 && auth()->user()->unreadNotifications->count() > 0)
            <button wire:click="markAllAsRead"
                class="text-[10px] text-[#D4AF37] border border-[#D4AF37] px-3 py-1.5 rounded-full hover:bg-[#D4AF37] hover:text-[#121212] transition font-bold uppercase tracking-wide">
                Tandai Semua Dibaca
            </button>
        @endif
    </div>

    {{-- NOTIFICATION LIST --}}
    <div class="space-y-4">
        @forelse ($notifications as $notification)
            @php
                $data = $notification->data;
                $isRead = $notification->read_at !== null;
                $icon = match ($data['type'] ?? 'info') {
                    'rsvp' => 'fa-clipboard-check',
                    'message' => 'fa-envelope-open-text',
                    default => 'fa-bell'
                };
                $iconColor = match ($data['type'] ?? 'info') {
                    'rsvp' => 'text-green-500',
                    'message' => 'text-blue-500',
                    default => 'text-[#D4AF37]'
                };
                $bgColor = $isRead ? 'bg-[#1a1a1a]' : 'bg-[#252525] border-l-4 border-[#D4AF37]';
            @endphp

            <div wire:click="markAsRead('{{ $notification->id }}')"
                class="{{ $bgColor }} p-4 rounded-xl border border-[#333333] hover:border-[#D4AF37]/50 transition-all cursor-pointer group relative overflow-hidden shadow-sm hover:shadow-md">

                <div class="flex gap-4">
                    {{-- Icon --}}
                    <div
                        class="w-10 h-10 rounded-full bg-[#121212] flex items-center justify-center shrink-0 border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                        <i class="fa-solid {{ $icon }} {{ $iconColor }}"></i>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-[#E0E0E0] text-sm {{ !$isRead ? 'text-[#D4AF37]' : '' }}">
                                {{ $data['title'] ?? 'Notifikasi' }}
                            </h4>
                            <span class="text-[10px] text-[#666] whitespace-nowrap ml-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-[#A0A0A0] leading-relaxed line-clamp-2">
                            {{ $data['message'] ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Unread Indicator Dot --}}
                @if(!$isRead)
                    <div class="absolute top-4 right-4 w-2 h-2 bg-[#D4AF37] rounded-full animate-pulse"></div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-[#1a1a1a] rounded-[2rem] border border-[#333333] border-dashed">
                <div class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center mx-auto mb-4 text-[#666]">
                    <i class="fa-regular fa-bell-slash text-2xl"></i>
                </div>
                <h3 class="text-[#E0E0E0] font-bold text-lg mb-1">Belum Ada Notifikasi</h3>
                <p class="text-[#888] text-xs">Aktivitas terbaru akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>

</div>