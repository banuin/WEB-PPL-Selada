<nav class="w-full bg-white shadow-sm sticky top-0 z-50 relative">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <div class="flex gap-8">
            @if(auth()->check() && auth()->user()->role == 'admin')
                <a href="{{ route('admin.artikel.index') }}" class="nav-link font-medium text-gray-700 hover:text-green-700 transition">Artikel</a>
                <a href="{{ route('admin.katalog.index') }}" class="nav-link font-medium text-gray-700 hover:text-green-700 transition">Katalog</a>
            @else
                <a href="#artikel-section" class="nav-link font-medium text-gray-700 hover:text-green-700 transition">Artikel</a>
                <a href="#katalog-section" class="nav-link font-medium text-gray-700 hover:text-green-700 transition">Katalog</a>
            @endif
        </div>

        <div x-data="{ open: false }" class="relative flex items-center justify-end">
            
            <button @click="open = !open" @click.away="open = false" class="text-gray-700 focus:outline-none p-2 hover:bg-gray-100 rounded-md transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div x-show="open" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 class="absolute top-full mt-2 right-0 w-60 bg-white shadow-2xl rounded-xl py-3 border border-gray-100 z-[100]">
                
                @auth
                    <div class="px-4 py-2 text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                        Menu ({{ ucfirst(auth()->user()->role) }})
                    </div>

                    <a href="{{ route('profil.show') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil ({{ auth()->user()->name }})
                    </a>

                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center px-4 py-3 text-sm text-green-700 hover:bg-green-50 border-t border-gray-50 font-semibold transition">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                            Kelola Pelanggan
                        </a>
                    @endif

                    <hr class="my-1 border-gray-100">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                            <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                        Daftar
                    </a>
                @endguest

            </div>
        </div>
    </div>
</nav>