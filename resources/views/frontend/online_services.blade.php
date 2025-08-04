<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Layanan Online') }}
        </h2>
    </x-slot>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary/10 to-secondary/10 pt-24 pb-16">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-primary mb-6">
                🌐 Layanan Online Desa Jatinagara
            </h1>
            <p class="text-xl text-secondary-dark mb-8 max-w-3xl mx-auto">
                Akses mudah dan cepat untuk berbagai layanan administrasi desa. 
                Ajukan surat keterangan dan dokumen resmi tanpa perlu datang ke kantor desa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#services" class="bg-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-primary-dark transition shadow-lg">
                    Mulai Pengajuan
                </a>
                <a href="#status-check" class="bg-white text-primary border-2 border-primary px-8 py-4 rounded-xl font-semibold hover:bg-primary/5 transition">
                    Cek Status Pengajuan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">
                Pilih Layanan yang Anda Butuhkan
            </h2>
            <p class="text-secondary-dark max-w-2xl mx-auto">
                Kami menyediakan berbagai layanan online untuk memudahkan urusan administrasi Anda
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($jenisServices as $key => $service)
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                <div class="text-center mb-6">
                    <div class="text-5xl mb-4">{{ $service['icon'] }}</div>
                    <h3 class="text-2xl font-bold text-primary mb-2">{{ $service['title'] }}</h3>
                    <p class="text-secondary-dark">{{ $service['description'] }}</p>
                </div>

                <div class="space-y-3">
                    @foreach($service['types'] as $typeKey => $typeName)
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg border hover:border-primary/20 transition">
                        <span class="text-gray-700">{{ $typeName }}</span>
                        @if($key === 'pengajuan_surat')
                        <a href="{{ route('online-services.create', $typeKey) }}" 
                           class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                            Ajukan
                        </a>
                        @else
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                            Segera Hadir
                        </span>
                        @endif
                    </div>
                    @endforeach
                </div>

                @if($key === 'pengajuan_surat')
                <div class="mt-6 text-center">
                    <a href="{{ route('online-services.create') }}" 
                       class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition block">
                        Ajukan Surat Lainnya
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Status Check Section -->
<section id="status-check" class="py-16 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-primary mb-4">📋 Cek Status Pengajuan</h2>
                <p class="text-secondary-dark">
                    Lacak status pengajuan surat Anda dengan memasukkan nomor pengajuan atau NIK
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="{{ route('online-services.status') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Jenis Pencarian</label>
                        <select name="search_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" required>
                            <option value="">-- Pilih Jenis Pencarian --</option>
                            <option value="id">Nomor Pengajuan (ID)</option>
                            <option value="nik">NIK (Nomor Induk Kependudukan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Nomor/NIK</label>
                        <input type="text" name="search_value" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                               placeholder="Contoh: 000123 atau 1234567890123456" required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                        🔍 Cari Status Pengajuan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-8">ℹ️ Informasi Penting</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 rounded-xl p-6">
                    <div class="text-3xl mb-4">⏰</div>
                    <h3 class="text-xl font-semibold mb-2">Waktu Proses</h3>
                    <p>Pengajuan akan diproses dalam 1-3 hari kerja setelah dokumen lengkap diterima</p>
                </div>
                
                <div class="bg-white/10 rounded-xl p-6">
                    <div class="text-3xl mb-4">📞</div>
                    <h3 class="text-xl font-semibold mb-2">Bantuan</h3>
                    <p>Hubungi kantor desa di (0123) 456-7890 untuk bantuan lebih lanjut</p>
                </div>
                
                <div class="bg-white/10 rounded-xl p-6">
                    <div class="text-3xl mb-4">🕒</div>
                    <h3 class="text-xl font-semibold mb-2">Jam Operasional</h3>
                    <p>Senin - Jumat: 08:00 - 16:00 WIB<br>Sabtu: 08:00 - 12:00 WIB</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <span class="mr-2">✅</span>
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <span class="mr-2">❌</span>
        {{ session('error') }}
    </div>
</div>
@endif

<script>
// Auto hide notifications after 5 seconds
setTimeout(function() {
    const notifications = document.querySelectorAll('.fixed.top-4.right-4');
    notifications.forEach(function(notification) {
        notification.style.transition = 'opacity 0.5s';
        notification.style.opacity = '0';
        setTimeout(function() {
            notification.remove();
        }, 500);
    });
}, 5000);

// Smooth scroll
document.querySelector('a[href="#services"]').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#services').scrollIntoView({
        behavior: 'smooth'
    });
});

document.querySelector('a[href="#status-check"]').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#status-check').scrollIntoView({
        behavior: 'smooth'
    });
});
</script>
</x-app-layout> 