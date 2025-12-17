<div class="max-w-3xl mx-auto relative z-10 font-display">

    {{-- FORM KIRIM UCAPAN --}}
    <div class="p-8 shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border mb-12 relative overflow-hidden group">


        <h3 class=" text-2xl font-bold mb-2 text-center theme-text">Kirim Doa & Ucapan</h3>
        <p class="text-center text-sm mb-6">"Doa restu Anda adalah kado terindah bagi kami"</p>

        <form wire:submit="sendMessage" class="space-y-5 relative z-10">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5 ml-1 theme-text">Nama Anda</label>
                <div class="relative">
                    <input type="text" wire:model="sender_name"
                        class="w-full pl-4 pr-4 py-3 rounded-xl border bg-white placeholder-[#C6AC80] focus:ring-1 transition-all text-sm font-medium"
                        placeholder="Tulis nama lengkap..." {{ $guest ? 'readonly' : '' }}>
                    @if ($guest)
                        <div class="absolute right-3 top-3 text-[#B89760]" title="Terisi Otomatis dari Undangan">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5 ml-1 theme-text">Ucapan &
                    Doa</label>
                <textarea wire:model="content" rows="3"
                    class="w-full p-4 rounded-xl bg-white border text-[#12110E] placeholder-[#C6AC80] focus:ring-1 transition-all text-sm resize-none"
                    placeholder="Tuliskan harapan dan doa restu untuk kedua mempelai..."></textarea>
                @error('content')
                    <span class="text-xs text-red-500 mt-1 block ml-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-right">
                <button type="submit"
                    class="px-8 py-3 theme-bg text-white rounded-full font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-sm flex items-center gap-2 ml-auto">
                    <span wire:loading.remove>Kirim Ucapan <i class="fa-solid fa-paper-plane ml-1"></i></span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Mengirim...</span>
                </button>
            </div>

            @if (session('msg_status'))
                <div
                    class="mt-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl text-center flex items-center justify-center gap-2 animate-pulse">
                    <i class="fa-solid fa-circle-check"></i> {{ session('msg_status') }}
                </div>
            @endif
        </form>
    </div>

    {{-- LIST UCAPAN --}}
    <div class="space-y-6">
        <h4 class=" font-bold text-xl theme-text mb-4 text-center border-b pb-4 mx-auto w-1/2">
            {{ $messages->total() }} Doa Terkumpul
        </h4>

        @foreach ($messages as $msg)
            <div class="bg-white p-6 rounded-2xl shadow-sm border relative transition hover:shadow-md">

                {{-- Quote Icon Dekorasi --}}
                <i class="fa-solid fa-quote-right absolute top-6 right-6 text-[#F2ECDC] text-4xl -z-0"></i>

                <div class="flex gap-4 relative z-10">
                    {{-- Avatar Inisial --}}
                    <div
                        class="w-10 h-10 rounded-full bg-white border flex items-center justify-center theme-text  font-bold text-lg shrink-0">
                        {{ substr($msg->sender_name, 0, 1) }}
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold theme-text text-lg">{{ $msg->sender_name }}</h4>
                            <span
                                class="text-[10px] uppercase tracking-wider text-[#7C6339] bg-white px-2 py-1 rounded-full border">
                                {{ $msg->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-[#7C6339] text-sm leading-relaxed mb-4 font-medium">
                            {{ $msg->content }}
                        </p>

                        {{-- Balasan Mempelai (Reply) --}}
                        @foreach ($msg->replies as $reply)
                            <div class="mt-4 bg-white p-4 rounded-xl border relative">
                                {{-- Icon Crown --}}
                                <div
                                    class="absolute -top-3 -left-2 theme-bg text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-crown"></i> Mempelai
                                </div>

                                <p class="text-xs text-[#12110E] mt-1 leading-relaxed italic">
                                    "{{ $reply->content }}"
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="pt-6 flex justify-center">
            {{ $messages->links() }}
        </div>
    </div>
</div>
