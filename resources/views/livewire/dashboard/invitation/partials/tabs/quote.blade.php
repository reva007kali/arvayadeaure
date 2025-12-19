<div class="max-w-4xl mx-auto py-8 relative" x-data="{ 
    scrollToResult() {
        setTimeout(() => {
            const el = document.getElementById('result-section');
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
}"
x-on:scroll-to-result.window="scrollToResult()">
    
    {{-- TOP: CHAT INTERFACE --}}
    <div class="bg-[#1a1a1a] rounded-3xl border border-[#333333] overflow-hidden shadow-xl mb-12 flex flex-col h-[600px]">
        <!-- Chat Header -->
        <div class="p-4 border-b border-[#333333] flex items-center gap-3 bg-[#252525] shrink-0">
            <div class="relative">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] shadow-lg">
                    <i class="fa-solid fa-robot text-lg"></i>
                </div>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#252525] rounded-full"></span>
            </div>
            <div>
                <h5 class="font-bold text-[#E0E0E0] text-sm">Arvaya Assistant</h5>
                <p class="text-[10px] text-[#A0A0A0]">Online • Siap membantu menulis</p>
            </div>
        </div>
        
        <!-- Chat Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-[#121212]" id="chat-container">
            @foreach($chatMessages as $index => $msg)
                <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }} animate-fade-in-up">
                    <div class="max-w-[85%] rounded-2xl p-4 shadow-md relative group
                        {{ $msg['role'] === 'user' 
                            ? 'bg-gradient-to-br from-[#D4AF37] to-[#B4912F] text-[#121212] rounded-tr-none' 
                            : 'bg-[#252525] text-[#E0E0E0] rounded-tl-none border border-[#333333]' }}">
                        
                       <div class="prose prose-invert prose-sm leading-snug whitespace-pre-wrap font-sans text-sm">
                           {!! nl2br(e(preg_replace('/\|\|\|.*?\|\|\|/s', '', $msg['content']))) !!}
                       </div>

                       @if($msg['role'] === 'assistant' && $index > 0)
                           <div class="mt-3 pt-2 border-t border-[#333333] flex justify-end">
                                <button wire:click="applyQuoteFromChat({{ $index }})" 
                                    class="text-xs font-bold px-4 py-2 rounded-xl border transition flex items-center gap-2 bg-[#1a1a1a] text-[#D4AF37] border-[#333333] hover:bg-[#333] hover:border-[#D4AF37] shadow-sm">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> Gunakan Ini
                                </button>
                           </div>
                       @endif
                    </div>
                </div>
            @endforeach

            @if($isChatting)
                 <div class="flex justify-start animate-pulse">
                    <div class="bg-[#252525] text-[#A0A0A0] rounded-2xl rounded-tl-none px-4 py-3 border border-[#333333] flex items-center gap-2 text-xs font-bold">
                        <i class="fa-solid fa-circle-notch fa-spin text-[#D4AF37]"></i> Arvaya sedang mengetik...
                    </div>
                </div>
            @endif
            
            <div id="scroll-anchor"></div>
            <script>
                document.addEventListener('livewire:updated', () => {
                    const container = document.getElementById('chat-container');
                    if(container) container.scrollTop = container.scrollHeight;
                });
            </script>
        </div>
        
        <!-- Chat Input -->
        <div class="p-4 bg-[#252525] border-t border-[#333333] shrink-0">
            <form wire:submit.prevent="sendChatMessage" class="relative">
                <input type="text" wire:model="chatInput" 
                    placeholder="Ketik pesan... (Contoh: 'Buatkan pantun lucu', 'Ayat tentang jodoh')" 
                    class="w-full pl-6 pr-16 py-4 rounded-2xl bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] placeholder-[#555] shadow-inner transition-all">
                
                <button type="submit" 
                    class="absolute right-2 top-2 bottom-2 w-12 bg-[#D4AF37] text-[#121212] rounded-xl hover:bg-[#B4912F] transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed shadow-md" 
                    wire:loading.attr="disabled"
                    wire:target="sendChatMessage">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
            <div class="mt-3 flex gap-2 overflow-x-auto pb-1 hide-scrollbar">
                @foreach(['Buatkan Islami', 'Ayat Al-Quran', 'Kristen', 'Pantun', 'Modern', 'Gen Z'] as $prompt)
                    <button wire:click="$set('chatInput', '{{ $prompt }}')" 
                        class="shrink-0 px-4 py-1.5 rounded-full bg-[#1a1a1a] border border-[#333333] text-xs text-[#A0A0A0] hover:text-[#D4AF37] hover:border-[#D4AF37] transition font-bold">
                        {{ $prompt }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- BOTTOM: RESULT PREVIEW & MANUAL EDIT --}}
    <div id="result-section" class="scroll-mt-8 transition-all duration-700 ease-in-out">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h4 class="font-serif font-bold text-2xl text-[#E0E0E0]">Hasil & Editor</h4>
                <p class="text-sm text-[#A0A0A0]">Review hasil generate atau edit manual di sini</p>
            </div>
            <button wire:click="$toggle('useAiQuote')" 
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 border shadow-sm
                {{ $useAiQuote ? 'bg-[#D4AF37] border-[#D4AF37] text-[#121212]' : 'bg-[#1a1a1a] border-[#333333] text-[#D4AF37] hover:bg-[#252525]' }}">
                <i class="fa-solid fa-pen-to-square"></i> {{ $useAiQuote ? 'Mode Preview' : 'Mode Edit' }}
            </button>
        </div>

        @php $qs = $couple['quote_structured'] ?? null; @endphp

        {{-- PREVIEW CARD --}}
        @if (!$useAiQuote)
            <div class="bg-[#1a1a1a] p-12 rounded-[2.5rem] border border-[#333333] shadow-2xl text-center relative overflow-hidden group hover:border-[#D4AF37]/30 transition-all duration-500">
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-3xl opacity-5 -mr-16 -mt-16"></div>
                
                @if($qs)
                    <div class="absolute top-8 left-8 text-[#D4AF37]/10 text-9xl font-serif leading-none">“</div>
                    
                    <div class="relative z-10 max-w-3xl mx-auto">
                        @if (($qs['type'] ?? '') === 'quran')
                            <div class="mb-8">
                                <p class="text-[#E0E0E0] font-serif text-3xl md:text-4xl leading-loose" dir="rtl">
                                    {{ $qs['arabic'] ?? '' }}
                                </p>
                            </div>
                            <div class="mb-6">
                                <p class="text-[#A0A0A0] italic text-lg leading-relaxed">"{{ $qs['translation'] ?? '' }}"</p>
                            </div>
                            <div>
                                <span class="inline-block px-6 py-2.5 rounded-full bg-[#252525] text-[#D4AF37] text-sm font-bold border border-[#333333] uppercase tracking-wider shadow-md">
                                    {{ $qs['source'] ?? '' }}
                                </span>
                            </div>
                        
                        @elseif (($qs['type'] ?? '') === 'bible')
                            <div class="mb-6">
                                <p class="text-[#E0E0E0] font-serif text-2xl leading-relaxed">
                                    "{{ $qs['verse_text'] ?? '' }}"
                                </p>
                            </div>
                            @if(!empty($qs['translation']))
                                <div class="mb-6">
                                    <p class="text-[#A0A0A0] text-base">{{ $qs['translation'] }}</p>
                                </div>
                            @endif
                            <div>
                                <span class="inline-block px-6 py-2.5 rounded-full bg-[#252525] text-[#D4AF37] text-sm font-bold border border-[#333333] uppercase tracking-wider shadow-md">
                                    {{ $qs['source'] ?? '' }}
                                </span>
                            </div>

                        @else
                            <div class="mb-8">
                                <p class="text-[#E0E0E0] font-serif text-3xl italic leading-relaxed">
                                    {{ $qs['quote_text'] ?? ($couple['quote'] ?? 'Belum ada kata sambutan. Silakan chat dengan Arvaya untuk membuatnya!') }}
                                </p>
                            </div>
                            <div>
                                <span class="inline-block px-6 py-2.5 rounded-full bg-[#252525] text-[#D4AF37] text-sm font-bold border border-[#333333] uppercase tracking-wider shadow-md">
                                    {{ $qs['source'] ?? 'Mempelai' }}
                                </span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-[#888] flex flex-col items-center py-12">
                        <div class="w-20 h-20 bg-[#252525] rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-comment-dots text-4xl text-[#D4AF37]/50"></i>
                        </div>
                        <h5 class="font-bold text-lg text-[#E0E0E0]">Belum ada kata sambutan</h5>
                        <p class="text-sm mt-1">Chat dengan AI di atas untuk membuat inspirasi!</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- MANUAL EDIT FORM --}}
        @if ($useAiQuote)
            <div class="bg-[#1a1a1a] p-8 rounded-[2.5rem] border-2 border-dashed border-[#D4AF37]/30">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    <div class="md:col-span-4">
                        <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Tipe Konten</label>
                        <div class="space-y-2">
                            @foreach(['quote' => 'Quotes Biasa', 'quran' => 'Ayat Al-Quran', 'bible' => 'Ayat Alkitab'] as $val => $label)
                                <button wire:click="$set('couple.quote_structured.type', '{{ $val }}')"
                                    class="w-full text-left px-4 py-3 rounded-xl border transition-all text-sm font-bold flex items-center justify-between
                                    {{ ($couple['quote_structured']['type'] ?? 'quote') === $val 
                                        ? 'bg-[#D4AF37] border-[#D4AF37] text-[#121212]' 
                                        : 'bg-[#252525] border-[#333333] text-[#888] hover:border-[#888]' }}">
                                    <span>{{ $label }}</span>
                                    @if(($couple['quote_structured']['type'] ?? 'quote') === $val)
                                        <i class="fa-solid fa-check"></i>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="md:col-span-8 space-y-6">
                        @if (($couple['quote_structured']['type'] ?? 'quote') === 'quran')
                            <div>
                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Teks Arab</label>
                                <textarea rows="4" wire:model="couple.quote_structured.arabic"
                                    class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-right font-serif text-2xl text-[#E0E0E0] leading-loose p-4"></textarea>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Terjemahan</label>
                                <textarea rows="3" wire:model="couple.quote_structured.translation"
                                    class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] text-sm p-4"></textarea>
                            </div>
                        @elseif (($couple['quote_structured']['type'] ?? 'quote') === 'bible')
                            <div>
                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Isi Ayat</label>
                                <textarea rows="4" wire:model="couple.quote_structured.verse_text"
                                    class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] text-base p-4"></textarea>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Terjemahan / Konteks</label>
                                <textarea rows="3" wire:model="couple.quote_structured.translation"
                                    class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] text-sm p-4"></textarea>
                            </div>
                        @else
                            <div>
                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Isi Kata Sambutan</label>
                                <textarea rows="5" wire:model="couple.quote_structured.quote_text"
                                    class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-serif text-xl p-4"></textarea>
                            </div>
                        @endif

                        <div>
                            <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Sumber / Penulis</label>
                            <input type="text" wire:model="couple.quote_structured.source"
                                class="w-full rounded-2xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] p-4">
                        </div>
                        
                        <div class="pt-2 flex justify-end">
                            <button wire:click="composeManualQuote"
                                class="px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-xl font-bold hover:bg-[#B4912F] transition flex items-center gap-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
                                <i class="fa-solid fa-check"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
