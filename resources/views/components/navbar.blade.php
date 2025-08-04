<nav
    x-data="{ open: false, profileDropdownOpen: false }"class="sticky top-0 z-50  shadow-lg bg-[linear-gradient(135deg,var(--color-primary)_0%,var(--color-secondary)_50%,var(--color-accent)_100%)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center"> {{-- Tambahkan items-center di sini --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse py-2">
                    @php
                        $logoContent = $siteLogo->content ?? 'images/logo.png';
                    @endphp

                    @if (Str::contains($logoContent, 'images'))
                        <img src="{{ asset($logoContent) }}" alt="{{ $villageName->content ?? 'Nama Desa' }} Logo"
                            class="h-8 w-auto">
                    @else
                        <img src="{{ asset('storage/' . $logoContent) }}"
                            alt="{{ $villageName->content ?? 'Nama Desa' }} Logo" class="h-8 w-auto">
                    @endif

                    <span class="ml-2 text-2xl font-semibold whitespace-nowrap text-white">
                        {{ $villageName->content ?? 'Nama Desa' }}
                    </span>
                </a>

            </div>
            <div class="hidden sm:flex space-x-6 items-center">
                {{-- NAV-LINK UTAMA (BERANDA) --}}
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                    class="text-white text-base font-semibold hover:text-yellow-200">
                    Beranda
                </x-nav-link>
                <div class="relative" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true"
                    @mouseleave="dropdownOpen = false">
                    <button
                        class="flex items-center gap-1 text-sm font-semibold text-white hover:text-yellow-200 transition   mt-1
                        {{ request()->routeIs('profil.*') ? 'border-b-2 border-desa-skyblue' : '' }}">
                        <span class="leading-tight text-sm">Profil Desa</span>
                        <svg class="w-4 h-4 mt-0.5 fill-current" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 0 1 1.06 0L10 10.92l3.71-3.71a.75.75 0 0 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.23 8.27a.75.75 0 0 1 0-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition
                        class="absolute top-10 left-0 mt-2 w-max bg-white shadow-lg rounded-md py-4 z-50">
                        <a href="{{ route('profil.info') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('profil.info') ? 'bg-gray-100 font-semibold' : '' }}">📊 Informasi Desa</a>
                        <a href="{{ route('profil.visi') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('profil.visi') ? 'bg-gray-100 font-semibold' : '' }}">🎯 Visi & Misi</a>
                        <a href="{{ route('profil.sejarah') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('profil.sejarah') ? 'bg-gray-100 font-semibold' : '' }}">📚 Sejarah Desa</a>
                        <a href="{{ route('profil.struktur') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('profil.struktur') ? 'bg-gray-100 font-semibold' : '' }}">🏛️ Struktur Pemerintahan</a>
                    </div>
                </div>
                <div class="relative" x-data="{ dropdownOpenLayanan: false }" @mouseenter="dropdownOpenLayanan = true"
                    @mouseleave="dropdownOpenLayanan = false">
                    <button
                        class="flex items-center gap-1 text-sm font-semibold text-white hover:text-yellow-200 transition   mt-1
                        {{ request()->routeIs('service-procedures') || request()->routeIs('documents') ? 'border-b-2 border-desa-skyblue' : '' }}">
                        <span class="leading-tight text-sm">Layanan</span>
                        <svg class="w-4 h-4 mt-0.5 fill-current" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 0 1 1.06 0L10 10.92l3.71-3.71a.75.75 0 0 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.23 8.27a.75.75 0 0 1 0-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpenLayanan" x-transition
                        class="absolute top-10 right-0 mt-2 w-max bg-white shadow-lg rounded-md py-4 z-50">
                        <a href="{{ route('service-procedures') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prosedur Layanan</a>
                        <a href="{{ route('documents') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dokumen Desa</a>
                    </div>
                </div>

                {{-- NAV-LINK UTAMA LAINNYA --}}
                <x-nav-link :href="route('potentials')" :active="request()->routeIs('potentials')"
                    class="text-white text-base font-semibold hover:text-yellow-200">Potensi</x-nav-link>
                <x-nav-link :href="route('news')" :active="request()->routeIs('news')"
                    class="text-white text-base font-semibold hover:text-yellow-200">Berita</x-nav-link>
                <x-nav-link :href="route('gallery')" :active="request()->routeIs('gallery')"
                    class="text-white text-base font-semibold hover:text-yellow-200">Galeri</x-nav-link>
                <x-nav-link :href="route('institutions.index')" :active="request()->routeIs('institutions.index')"
                    class="text-white text-base font-semibold hover:text-yellow-200">Lembaga Desa</x-nav-link>
                <x-nav-link :href="route('products')" :active="request()->routeIs('products')"
                    class="text-white text-base font-semibold hover:text-yellow-200">Produk Desa</x-nav-link>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="text-white text-base font-semibold hover:text-yellow-200 flex items-center space-x-1">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 fill-current" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 0 1 1.06 0L10 10.92l3.71-3.71a.75.75 0 0 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.23 8.27a.75.75 0 0 1 0-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('admin.dashboard')"
                                class="text-gray-700 hover:bg-gray-100">Dashboard</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')"
                                class="text-gray-700 hover:bg-gray-100">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-gray-700 hover:bg-gray-100">Keluar</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- <a href="{{ route('login') }}"
                        class="text-white text-base font-semibold hover:text-yellow-200">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-white text-base font-semibold hover:text-yellow-200 ml-4">Daftar</a>
                    @endif --}}
                @endauth

                <button @click="open = !open" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white"
                    style="color: var(--color-secondary-light);"> {{-- Warna ikon hamburger --}}
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-desa-green-800">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <x-responsive-nav-link :href="route('home')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Beranda</x-responsive-nav-link>

            {{-- Mobile Dropdown Profil Desa --}}
            <div x-data="{ mobileProfileOpen: false }">
                <button @click="mobileProfileOpen = !mobileProfileOpen"
                    class=" w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:bg-desa-green-700 focus:outline-none flex justify-between items-center">
                    <span>Profil Desa</span>
                    <svg class="h-5 w-5 fill-current transform transition-transform duration-200"
                        :class="{ 'rotate-180': mobileProfileOpen }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 0 1 1.06 0L10 10.92l3.71-3.71a.75.75 0 0 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.23 8.27a.75.75 0 0 1 0-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="mobileProfileOpen" class="space-y-1 pl-4 pt-2">
                    <x-responsive-nav-link :href="route('profil.info')"
                        class="block text-white hover:bg-desa-green-600 px-3 py-2 rounded-md {{ request()->routeIs('profil.info') ? 'bg-desa-green-600' : '' }}">📊 Informasi
                        Desa</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profil.visi')"
                        class="block text-white hover:bg-desa-green-600 px-3 py-2 rounded-md {{ request()->routeIs('profil.visi') ? 'bg-desa-green-600' : '' }}">🎯 Visi &
                        Misi</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profil.sejarah')"
                        class="block text-white hover:bg-desa-green-600 px-3 py-2 rounded-md {{ request()->routeIs('profil.sejarah') ? 'bg-desa-green-600' : '' }}">📚 Sejarah
                        Desa</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profil.struktur')"
                        class="block text-white hover:bg-desa-green-600 px-3 py-2 rounded-md {{ request()->routeIs('profil.struktur') ? 'bg-desa-green-600' : '' }}">🏛️ Struktur
                        Pemerintahan</x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('potentials')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Potensi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('news')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Berita</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gallery')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Galeri</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('online-services')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Layanan</x-responsive-nav-link>
            {{-- <x-responsive-nav-link :href="route('contact')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Kontak</x-responsive-nav-link> --}}
            {{-- di dalam div mobile menu --}}
            <x-responsive-nav-link :href="route('service-procedures')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Prosedur
                Layanan</x-responsive-nav-link>
            {{-- di dalam div mobile menu --}}
            <x-responsive-nav-link :href="route('products')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Produk
                Desa</x-responsive-nav-link>
            {{-- di dalam div mobile menu --}}
            <x-responsive-nav-link :href="route('institutions.index')"
                class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Lembaga
                Desa</x-responsive-nav-link>
            {{-- @auth
                <div class="mt-4 border-t border-gray-700 pt-4">
                    <x-responsive-nav-link :href="route('admin.dashboard')"
                        class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Dashboard
                        Admin</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')"
                        class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Profil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Keluar</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-4 border-t border-gray-700 pt-4">
                    <x-responsive-nav-link :href="route('login')"
                        class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Masuk</x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')"
                            class="block text-white hover:bg-desa-green-700 px-3 py-2 rounded-md">Daftar</x-responsive-nav-link>
                    @endif
                </div>
            @endauth --}}
        </div>
    </div>
</nav>
