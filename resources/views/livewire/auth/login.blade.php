<x-layouts.auth.login-page>
    <div class="w-full max-w-md">


        {{-- Form Container with Dark Golden Neomorphism --}}
        <div class="bg-arvaya-bg rounded-xl p-8 relative overflow-hidden border border-arvaya-400/10">

            <div class="relative z-10">
                <div class="flex items-center justify-center gap-x-2">
                    {{-- Logo --}}
                    <div class="flex justify-center mb-8">
                        <img src="/logo.png" alt="Arvaya Logo" class="h-10">
                    </div>
                    <h2
                        class="text-2xl font-serif text-center text-arvaya-400 mb-6 font-bold tracking-wider uppercase drop-shadow-md">
                        Welcome Back
                    </h2>
                </div>


                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

                <form method="POST" action="{{ route('login.store') }}" class="space-y-6" x-data="{ showPass: false }">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label
                            class="block text-xs font-bold text-arvaya-400 uppercase tracking-wider mb-2 ml-1">{{ __('Email address') }}</label>
                        <div class="relative group">
                            <input type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="email" class="w-full px-4 py-3 rounded-xl bg-arvaya-bg text-arvaya-400 placeholder-arvaya-400/50 
                                shadow-[inset_3px_3px_6px_#0a0a0a,inset_-3px_-3px_6px_#1e1e1e] 
                                focus:shadow-[inset_4px_4px_8px_#0a0a0a,inset_-4px_-4px_8px_#1e1e1e] 
                                border-none focus:ring-0 transition-all text-sm outline-none"
                                placeholder="email@example.com">
                        </div>
                        @error('email')
                            <span class="text-red-400 text-xs mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2 ml-1">
                            <label
                                class="block text-xs font-bold text-arvaya-400 uppercase tracking-wider">{{ __('Password') }}</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-[10px] font-bold text-arvaya-400/80 hover:text-arvaya-300 transition">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" class="w-full px-4 py-3 rounded-xl bg-arvaya-bg text-arvaya-400 placeholder-arvaya-400/50 
                                shadow-[inset_3px_3px_6px_#0a0a0a,inset_-3px_-3px_6px_#1e1e1e] 
                                focus:shadow-[inset_4px_4px_8px_#0a0a0a,inset_-4px_-4px_8px_#1e1e1e] 
                                border-none focus:ring-0 transition-all text-sm pr-10 outline-none"
                                placeholder="********">
                            <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-arvaya-400/70 hover:text-arvaya-300 transition cursor-pointer">
                                <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-400 text-xs mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center ml-1">
                        <label class="inline-flex items-center cursor-pointer group select-none">
                            <div class="relative">
                                <input type="checkbox" name="remember" class="sr-only peer">
                                <div
                                    class="w-5 h-5 bg-arvaya-bg rounded shadow-[inset_2px_2px_4px_#0a0a0a,inset_-2px_-2px_4px_#1e1e1e] 
                                peer-checked:shadow-[2px_2px_4px_#0a0a0a,-2px_-2px_4px_#1e1e1e] peer-checked:bg-arvaya-400 transition-all flex items-center justify-center">
                                    <i
                                        class="fa-solid fa-check text-arvaya-bg text-xs opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                            <span
                                class="ml-2 text-sm text-arvaya-400/80 group-hover:text-arvaya-300 transition">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 bg-arvaya-bg text-arvaya-400 rounded-xl font-bold uppercase tracking-wider 
                        shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] 
                        hover:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] 
                        active:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] 
                        transition-all transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer border border-arvaya-400/5">
                        <span>{{ __('Log in') }}</span>
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>

                    {{-- Separator --}}
                    <div class="flex items-center gap-4 my-6 opacity-60">
                        <div class="h-px bg-arvaya-400/30 flex-1 shadow-[0_1px_0_rgba(255,255,255,0.05)]"></div>
                        <span class="text-[10px] uppercase text-arvaya-400 font-bold tracking-widest">Or continue
                            with</span>
                        <div class="h-px bg-arvaya-400/30 flex-1 shadow-[0_1px_0_rgba(255,255,255,0.05)]"></div>
                    </div>

                    {{-- Google Button --}}
                    <a href="{{ route('auth.google') }}" class="w-full py-3 bg-arvaya-bg rounded-xl flex items-center justify-center gap-3 text-arvaya-400 font-bold text-sm 
                        shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] 
                        hover:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] 
                        active:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] 
                        transition-all border border-arvaya-400/5 group">
                        <svg class="h-5 w-5 filter grayscale group-hover:grayscale-0 transition duration-300"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4" />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853" />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z"
                                fill="#FBBC05" />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335" />
                        </svg>
                        <span class="group-hover:text-arvaya-300 transition">Google Account</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="mt-4 text-center text-sm bg-arvaya-bg p-3 rounded-lg border border-arvaya-400/5">
                <span class="text-arvaya-400/80 shadow-black drop-shadow-md">{{ __('Don\'t have an account?') }}</span>
                <a href="{{ route('register') }}"
                    class="font-bold text-arvaya-400 hover:text-white hover:underline transition ml-1 drop-shadow-md">
                    {{ __('Sign up') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.auth.login-page>