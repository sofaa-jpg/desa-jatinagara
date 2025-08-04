<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Surat Online') }}
        </h2>
    </x-slot>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary/10 to-secondary/10 pt-24 pb-8">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-3xl lg:text-4xl font-bold text-primary mb-4">
                📝 Form Pengajuan Surat Online
            </h1>
            <p class="text-lg text-secondary-dark mb-6">
                Lengkapi form di bawah ini dengan data yang benar dan akurat
            </p>
            <nav class="text-sm">
                <a href="{{ route('online-services') }}" class="text-primary hover:underline">Layanan Online</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600">Form Pengajuan</span>
            </nav>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            
            @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <div class="text-red-400 mr-3">❌</div>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan pada form:</h3>
                        <ul class="text-red-700 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <form method="POST" action="{{ route('online-services.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Jenis Surat -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="jenis_surat" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Surat yang Diajukan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_surat" id="jenis_surat" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                    required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($jenisOptions as $key => $option)
                                <option value="{{ $option }}" {{ old('jenis_surat', $jenis ? $jenisOptions[$jenis] ?? '' : '') === $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-semibold text-primary mb-4">👤 Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                       placeholder="Masukkan nama lengkap sesuai KTP" required>
                            </div>
                            
                            <div>
                                <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                       placeholder="16 digit NIK sesuai KTP" maxlength="16" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-semibold text-primary mb-4">📞 Informasi Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon/HP <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email (Opsional)
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                       placeholder="contoh@email.com">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                      placeholder="Alamat lengkap sesuai KTP" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-semibold text-primary mb-4">📄 Detail Keperluan</h3>
                        <div>
                            <label for="keperluan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Keperluan/Tujuan Penggunaan Surat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="keperluan" id="keperluan" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                      placeholder="Jelaskan dengan detail untuk apa surat ini akan digunakan..." required>{{ old('keperluan') }}</textarea>
                            <p class="text-sm text-gray-500 mt-2">
                                <span class="font-medium">Contoh:</span> Untuk keperluan pendaftaran sekolah anak, melengkapi berkas pekerjaan, mengurus KK, dll.
                            </p>
                        </div>
                    </div>

                    <!-- Persetujuan -->
                    <div class="border-t pt-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h4 class="font-semibold text-blue-800 mb-3">ℹ️ Informasi Penting:</h4>
                            <ul class="text-blue-700 space-y-2 text-sm">
                                <li>✓ Pastikan semua data yang dimasukkan benar dan sesuai dokumen resmi</li>
                                <li>✓ Pengajuan akan diproses dalam 1-3 hari kerja</li>
                                <li>✓ Anda akan dihubungi melalui nomor telepon yang terdaftar</li>
                                <li>✓ Simpan nomor pengajuan untuk tracking status</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            <label class="flex items-start space-x-3">
                                <input type="checkbox" name="agree" value="1" 
                                       class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary" required>
                                <span class="text-sm text-gray-700">
                                    Saya menyatakan bahwa data yang saya masukkan adalah benar dan dapat dipertanggungjawabkan secara hukum. 
                                    Saya memahami bahwa penyalahgunaan data dapat dikenakan sanksi sesuai peraturan yang berlaku.
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="border-t pt-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('online-services') }}" 
                               class="sm:w-auto flex-1 text-center bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition">
                                ← Kembali
                            </a>
                            <button type="submit" 
                                    class="sm:w-auto flex-1 bg-primary text-white py-3 px-8 rounded-lg font-semibold hover:bg-primary-dark transition">
                                📤 Kirim Pengajuan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// NIK input formatting
document.getElementById('nik').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 16) {
        value = value.slice(0, 16);
    }
    e.target.value = value;
});

// Phone number formatting
document.getElementById('no_telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 15) {
        value = value.slice(0, 15);
    }
    e.target.value = value;
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const nik = document.getElementById('nik').value;
    const phone = document.getElementById('no_telepon').value;
    const agree = document.querySelector('input[name="agree"]').checked;
    
    if (nik.length !== 16) {
        e.preventDefault();
        alert('NIK harus terdiri dari 16 digit');
        return;
    }
    
    if (phone.length < 10) {
        e.preventDefault();
        alert('Nomor telepon tidak valid');
        return;
    }
    
    if (!agree) {
        e.preventDefault();
        alert('Anda harus menyetujui pernyataan yang tersedia');
        return;
    }
});
</script>
</x-app-layout> 