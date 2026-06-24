<nav class="w-full bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <!-- ================= 1. BAGIAN KIRI: LOGO ================= -->
        <div class="flex items-center">
            @php
                $homeUrl = url('/');
                if (auth()->check()) {
                    if (auth()->user()->role == 'admin') {
                        $homeUrl = route('admin.dashboard');
                    } else {
                        $homeUrl = route('pelanggan.home');
                    }
                }
            @endphp
            <a href="{{ $homeUrl }}" class="flex items-center gap-3">
                <img src="{{ asset('images/Logo Seladaku1.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                <span class="text-2xl font-bold text-[#337C3E] tracking-wide group-hover:text-green-800 transition-colors">
                    Seladaku
                </span>
                
                <!-- <span class="text-xl font-extrabold text-black tracking-wide">Logo Aplikasi</span> -->
            </a>
        </div>

        <!-- ================= 2. BAGIAN KANAN: MENU & DROPDOWN ================= -->
        <div class="flex items-center gap-8">
            
            <!-- Link Navigasi (Hanya Muncul di Layar Sedang/Besar) -->
            <div class="hidden md:flex items-center gap-8">
                @if(auth()->check() && auth()->user()->role == 'admin')
                    <a href="{{ route('admin.artikel.index') }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Artikel</a>
                    <a href="{{ route('admin.katalog.index') }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Katalog</a>
                    <a href="{{ route('admin.pemesanan.index') }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Pemesanan</a>
                    <a href="{{ route('admin.laporan.index') }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Laporan</a>
                @else
                    @php
                        $artikelUrl = auth()->check() ? route('pelanggan.home') . '#artikel-section' : url('/#artikel-section');
                        $katalogUrl = auth()->check() ? route('pelanggan.home') . '#katalog-section' : url('/#katalog-section');
                    @endphp
                    <a href="{{ $artikelUrl }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Artikel</a>
                    <a href="{{ $katalogUrl }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Katalog</a>
                    <a href="{{ route('pelanggan.pemesanan.index') }}" class="font-semibold text-[15px] text-gray-800 hover:text-[#2F8540] transition">Pemesanan</a>
                @endif
            </div>

            <!-- WhatsApp -->
            <a href="https://wa.me/6285168617195" target="_blank" rel="noopener noreferrer"
               class="flex items-center justify-center w-9 h-9 bg-[#25D366] hover:bg-[#1ebe5d] rounded-full transition shadow-sm"
               title="Hubungi kami via WhatsApp">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.558 4.121 1.533 5.845L.057 23.428a.75.75 0 00.916.916l5.583-1.476A11.953 11.953 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.714 9.714 0 01-4.97-1.367l-.357-.212-3.714.981.981-3.714-.212-.357A9.714 9.714 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
                </svg>
            </a>

            <!-- Hamburger Dropdown Menu (Alpine.js) -->
            <div x-data="{ open: false }" class="relative flex items-center justify-end">
                
                <button @click="open = !open" @click.away="open = false" class="text-gray-800 focus:outline-none hover:text-black transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute top-full mt-4 right-0 w-60 bg-white shadow-2xl rounded-xl py-3 border border-gray-100 z-[100]">
                    
                    @auth
                        <div class="px-4 py-2 text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                            Menu ({{ ucfirst(auth()->user()->role) }})
                        </div>

                        <!-- Nav links untuk mobile (auth) -->
                        @if(auth()->user()->role != 'admin')
                        <div class="md:hidden">
                            @php
                                $artikelUrlM2 = route('pelanggan.home') . '#artikel-section';
                                $katalogUrlM2 = route('pelanggan.home') . '#katalog-section';
                            @endphp
                            <a href="{{ $artikelUrlM2 }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Artikel</a>
                            <a href="{{ $katalogUrlM2 }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Katalog</a>
                            <a href="{{ route('pelanggan.pemesanan.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Pemesanan</a>
                            <hr class="my-1 border-gray-100">
                        </div>
                        @endif
                        <a href="{{ route('profil.show') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil ({{ auth()->user()->name }})
                        </a>

                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center px-4 py-3 text-sm text-[#2F8540] hover:bg-green-50 border-t border-gray-50 font-semibold transition">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                                Kelola Pelanggan
                            </a>
                        @endif

                        <hr class="my-1 border-gray-100">
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                                <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    @endauth

                    @guest
                        <!-- Nav links untuk mobile (guest) -->
                        <div class="md:hidden">
                            @php
                                $artikelUrlM = url('/#artikel-section');
                                $katalogUrlM = url('/#katalog-section');
                            @endphp
                            <a href="{{ $artikelUrlM }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Artikel</a>
                            <a href="{{ $katalogUrlM }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Katalog</a>
                            <a href="{{ route('pelanggan.pemesanan.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Pemesanan</a>
                            <hr class="my-1 border-gray-100">
                        </div>
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Daftar
                        </a>
                    @endguest

                </div>
            </div>
            
        </div>
    </div>
</nav>