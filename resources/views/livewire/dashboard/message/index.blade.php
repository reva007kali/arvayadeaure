<div class="py-2 animate-fade-in-up max-w-4xl mx-auto dashboard-ui">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Messages</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Doa & Ucapan</h2>
            <p class="text-[#7C6339] text-sm mt-1">Undangan: <span
                    class="font-semibold italic">{{ $invitation->title }}</span></p>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($messages as $msg)
            <div
                class="group bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.2)] border border-[#E6D9B8]/60 transition-all hover:shadow-[0_8px_30px_rgb(184,151,96,0.15)]">

                {{-- Header Pesan --}}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <div
                            class="w-12 h-12 rounded-full bg-[#F2ECDC] border border-[#E6D9B8] flex items-center justify-center text-[#9A7D4C] font-serif font-bold text-lg shadow-sm">
                            {{ substr($msg->sender_name, 0, 1) }}
                        </div>

                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#5E4926] leading-tight">
                                {{ $msg->sender_name }}</h4>
                            <div class="flex items-center gap-2 text-xs text-[#9A7D4C] mt-0.5">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $msg->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Button --}}
                    <button wire:click="delete({{ $msg->id }})" wire:confirm="Hapus pesan ini?"
                        class="text-[#C6AC80] hover:text-red-500 transition p-2 rounded-full hover:bg-red-50"
                        title="Hapus Pesan">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>

                {{-- Isi Pesan --}}
                <div class="pl-16">
                    <div
                        class="text-[#5E4926] text-sm leading-relaxed mb-6 bg-[#F9F7F2]/50 p-4 rounded-xl border border-[#F2ECDC] italic relative">
                        <i class="fa-solid fa-quote-left absolute -top-2 -left-2 text-[#E6D9B8] text-xl"></i>
                        {{ $msg->content }}
                    </div>

                    {{-- List Balasan --}}
                    <div
                        class="space-y-4 relative before:absolute before:left-0 before:top-0 before:bottom-0 before:w-0.5 before:bg-[#E6D9B8]/50 before:rounded-full pl-6">
                        @foreach ($msg->replies as $reply)
                            <div class="bg-[#F9F7F2] p-4 rounded-xl border border-[#E6D9B8] relative">
                                {{-- Connector Line --}}
                                <div class="absolute top-6 -left-6 w-6 h-0.5 bg-[#E6D9B8]/50"></div>

                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-[10px] font-bold bg-[#B89760] text-white px-2 py-0.5 rounded-full border border-[#9A7D4C] shadow-sm flex items-center gap-1">
                                            <i class="fa-solid fa-crown text-[8px]"></i> Mempelai
                                        </span>
                                        <span
                                            class="text-[10px] text-[#9A7D4C]">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <button wire:click="delete({{ $reply->id }})"
                                        class="text-[#C6AC80] hover:text-red-500 text-xs transition">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-[#7C6339] leading-relaxed">{{ $reply->content }}</p>
                            </div>
                        @endforeach

                        {{-- Form Reply --}}
                        <div class="mt-4">
                            @if ($replyingToId === $msg->id)
                                <div
                                    class="animate-fade-in-down bg-white p-4 rounded-xl border border-[#B89760] shadow-md relative z-10">
                                    <textarea wire:model="replyContent"
                                        class="w-full text-sm rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] mb-3 transition-all resize-none"
                                        rows="3" placeholder="Tulis balasan ucapan terima kasih..."></textarea>

                                    <div class="flex gap-2 justify-end">
                                        <button wire:click="cancelReply"
                                            class="text-xs font-bold text-[#7C6339] hover:text-[#5E4926] px-3 py-2 rounded transition">Batal</button>
                                        <button wire:click="sendReply({{ $msg->id }})"
                                            class="bg-[#B89760] hover:bg-[#9A7D4C] text-white text-xs font-bold px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2">
                                            <span>Kirim</span> <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button wire:click="setReply({{ $msg->id }})"
                                    class="text-xs text-[#B89760] font-bold hover:text-[#9A7D4C] transition flex items-center gap-2 group/btn">
                                    <div
                                        class="w-6 h-6 rounded-full bg-[#F2ECDC] flex items-center justify-center group-hover/btn:bg-[#E6D9B8] transition">
                                        <i class="fa-solid fa-reply"></i>
                                    </div>
                                    Balas Pesan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- EMPTY STATE --}}
            <div class="py-16 text-center bg-white rounded-2xl border-2 border-dashed border-[#E6D9B8]">
                <div
                    class="w-16 h-16 bg-[#F9F7F2] rounded-full flex items-center justify-center mx-auto mb-4 text-[#B89760]">
                    <i class="fa-solid fa-envelope-open text-2xl opacity-50"></i>
                </div>
                <h3 class="font-serif font-bold text-lg text-[#5E4926] mb-1">Belum ada ucapan masuk</h3>
                <p class="text-[#9A7D4C] text-xs max-w-xs mx-auto">
                    Ucapan dan doa dari tamu undangan akan muncul di sini setelah undangan disebar.
                </p>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>
