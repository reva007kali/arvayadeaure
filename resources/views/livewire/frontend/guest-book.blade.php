<div class="max-w-3xl mx-auto relative z-10 font-display">

    {{-- FORM KIRIM UCAPAN --}}
    <div class="p-2 mb-12 relative overflow-hidden group">

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

            <div class="text-center">
                <button type="submit"
                    class="px-8 py-3 theme-bg text-white rounded-lg font-bold hover:shadow-xl transition transform hover:-translate-y-0.5 text-sm flex items-center gap-2 mx-auto">
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
    <div class="space-y-4 p-2">
        <h4 class="font-bold text-xl theme-text mb-4 text-center border-b pb-4 mx-auto">
            {{ $messages->total() }} Doa Terkumpul
        </h4>

        @foreach ($messages as $msg)
            <div class="relative transition">

                <div class="flex gap-2 items-center relative z-10">
                    {{-- Avatar Inisial --}}
                    <div
                        class="w-8 h-8 p-2 rounded-full theme-bg text-white  flex items-center justify-center font-bold text-lg shrink-0">
                        {{ substr($msg->sender_name, 0, 1) }}
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h4 class="font-bold theme-text text-sm">{{ $msg->sender_name }}</h4>
                            <span class="text-[10px]">
                                {{ $msg->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-xs w-fit bg-white p-2 rounded-md leading-relaxed font-medium">
                            {{ $msg->content }}
                        </p>
                    </div>
                </div>
                {{-- Balasan Mempelai (Reply) --}}
                @foreach ($msg->replies as $reply)
                    <div class="flex gap-2 items-center relative z-10">
                        <div class="flex-1">
                            <div class="flex justify-end items-center text-sm mt-2 ml-4">
                                <h4 class="font-bold">{{ $reply->sender_name }}</h4>
                            </div>
                            <div class="relative ml-auto w-fit text-right bg-white p-2 rounded-md border shadow-sm">
                                <p class="text-xs  leading-relaxed font-medium">
                                    {{ $reply->content }}
                                </p>
                                <div
                                    class="absolute -right-2 top-1 w-0 h-0 rotate-180 border-t-8 border-t-transparent border-r-8 border-r-white border-b-8 border-b-transparent">
                                </div>
                            </div>

                        </div>
                        {{-- Avatar Inisial --}}
                        <div
                            class="w-8 h-8 p-2 rounded-full theme-bg text-white flex items-center justify-center  font-bold text-lg shrink-0">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="pt-6 flex justify-center">
            {{ $messages->links() }}
        </div>
    </div>
</div>