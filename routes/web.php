<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController; // Import HomeController
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController; // Import ProfileController frontend dengan alias
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\DocumentController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\InstitutionController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\OnlineServiceController;
use App\Http\Controllers\Frontend\PotentialController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ServiceProcedureController;

// --- RUTE FRONTEND PUBLIK DESA Jatinagara ---

// Rute Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');



// --- Rute Layanan Online ---
Route::get('/layanan-online', [OnlineServiceController::class, 'index'])->name('online-services');
Route::get('/layanan-online/ajukan/{jenis?}', [OnlineServiceController::class, 'createSurat'])->name('online-services.create');
Route::post('/layanan-online/ajukan', [OnlineServiceController::class, 'storeSurat'])->name('online-services.store');
Route::get('/layanan-online/status/{id?}', [OnlineServiceController::class, 'checkStatus'])->name('online-services.status');
Route::post('/layanan-online/status', [OnlineServiceController::class, 'checkStatus'])->name('online-services.status');

Route::get('/kontak', function () {
    return view('frontend.contact');
})->name('contact');


// --- RUTE BAWAAN LARAVEL BREEZE (UNTUK PENGGUNA TERAUTENTIKASI) ---

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Rute Profil Pengguna bawaan Breeze
// Ini untuk mengelola profil pengguna yang login (bukan admin)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Rute Berita ---
Route::get('/berita', [NewsController::class, 'index'])->name('news');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');


// --- Rute Galeri ---
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// --- Rute Prosedur Layanan Warga ---
Route::get('/prosedur-layanan', [ServiceProcedureController::class, 'index'])->name('service-procedures');
Route::get('/prosedur-layanan/{slug}', [ServiceProcedureController::class, 'show'])->name('service-procedures.show');


// --- Rute Dokumen Publik ---
Route::get('/dokumen-publik', [DocumentController::class, 'index'])->name('documents');
Route::get('/dokumen-publik/{slug}/unduh', [DocumentController::class, 'download'])->name('documents.download');

// --- Rute Potensi Desa ---
Route::get('/potensi-desa', [PotentialController::class, 'index'])->name('potentials');


// --- Rute Produk Desa ---
Route::get('/produk-desa', [ProductController::class, 'index'])->name('products');
Route::get('/produk-desa/{slug}', [ProductController::class, 'show'])->name('products.show');

// --- Rute Profil Desa ---
Route::get('/profil/visi', [FrontendProfileController::class, 'visionMission'])->name('profil.visi');
Route::get('/profil/sejarah', [FrontendProfileController::class, 'history'])->name('profil.sejarah');
Route::get('/profil/struktur-pemerintahan', [FrontendProfileController::class, 'structure'])->name('profil.struktur');
Route::get('/profil/informasi-desa', function() {
    $villageName = App\Models\ProfileContent::where('key', 'village_name')->first();
    return view('frontend.profile.village_info', compact('villageName'));
})->name('profil.info');

// --- DEBUG ROUTES (Hapus di production!) ---
Route::get('/debug/upload-config', function() {
    // Allow in production for debugging
    // if (!app()->environment('local', 'staging')) {
    //     abort(404);
    // }
    
    $info = [
        'PHP Upload Limits' => [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
        ],
        'Storage Info' => [
            'storage_path' => storage_path(),
            'storage_writable' => is_writable(storage_path()),
            'public_storage_path' => storage_path('app/public'),
            'public_storage_exists' => file_exists(storage_path('app/public')),
            'public_storage_writable' => is_writable(storage_path('app/public')),
            'gallery_images_path' => storage_path('app/public/gallery_images'),
            'gallery_images_exists' => file_exists(storage_path('app/public/gallery_images')),
            'gallery_images_writable' => is_writable(storage_path('app/public/gallery_images')),
        ],
        'Symlink Info' => [
            'public_storage_link' => public_path('storage'),
            'public_storage_link_exists' => file_exists(public_path('storage')),
            'is_symlink' => is_link(public_path('storage')),
            'symlink_target' => is_link(public_path('storage')) ? readlink(public_path('storage')) : 'Not a symlink',
        ],
        'Disk Space' => [
            'free_space_gb' => round(disk_free_space(storage_path()) / 1024 / 1024 / 1024, 2),
            'total_space_gb' => round(disk_total_space(storage_path()) / 1024 / 1024 / 1024, 2),
        ],
        'Laravel Config' => [
            'filesystem_default' => config('filesystems.default'),
            'filesystem_public_driver' => config('filesystems.disks.public.driver'),
            'filesystem_public_root' => config('filesystems.disks.public.root'),
            'filesystem_public_url' => config('filesystems.disks.public.url'),
        ]
    ];
    
    return response()->json($info, 200, [], JSON_PRETTY_PRINT);
})->name('debug.upload-config');

// Test upload route for debugging
Route::match(['GET', 'POST'], '/debug/test-upload', function(\Illuminate\Http\Request $request) {
    // Allow in production for debugging
    // if (!app()->environment('local', 'staging')) {
    //     abort(404);
    // }
    
    if ($request->isMethod('POST')) {
        \Log::info('Debug Upload Test: POST received', [
            'has_file' => $request->hasFile('test_image'),
            'all_files' => $request->allFiles(),
            'all_input' => $request->all(),
            'content_length' => $request->server('CONTENT_LENGTH'),
        ]);
        
        if ($request->hasFile('test_image')) {
            $file = $request->file('test_image');
            \Log::info('Debug Upload Test: File details', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError(),
                'temp_path' => $file->getRealPath(),
            ]);
            
            try {
                $path = $file->store('debug_uploads', 'public');
                return response()->json(['success' => true, 'path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Debug Upload Test: Exception', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
        }
        
        return response()->json(['success' => false, 'error' => 'No file uploaded']);
    }
    
    return '<form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="' . csrf_token() . '">
        <input type="file" name="test_image" required>
        <button type="submit">Test Upload</button>
    </form>';
})->name('debug.test-upload');

// Clear logs for debugging
Route::get('/debug/clear-logs', function() {
    // Allow in production for debugging
    // if (!app()->environment('local', 'staging')) {
    //     abort(404);
    // }
    
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        file_put_contents($logFile, '');
        return response()->json(['success' => true, 'message' => 'Logs cleared']);
    }
    
    return response()->json(['success' => false, 'message' => 'Log file not found']);
})->name('debug.clear-logs');

// Test PHP upload limits
Route::get('/debug/php-upload-limits', function() {
    return response()->json([
        'php_upload_limits' => [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'upload_max_filesize_bytes' => return_bytes(ini_get('upload_max_filesize')),
            'post_max_size' => ini_get('post_max_size'),
            'post_max_size_bytes' => return_bytes(ini_get('post_max_size')),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'file_uploads' => ini_get('file_uploads'),
            'upload_tmp_dir' => ini_get('upload_tmp_dir'),
        ],
        'server_info' => [
            'temp_dir' => sys_get_temp_dir(),
            'temp_dir_writable' => is_writable(sys_get_temp_dir()),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'php_version' => PHP_VERSION,
            'running_in_azure' => !empty($_SERVER['WEBSITE_SITE_NAME']),
        ]
    ], 200, [], JSON_PRETTY_PRINT);
})->name('debug.php-upload-limits');

if (!function_exists('return_bytes')) {
    function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = substr($val, 0, -1);
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
}

// --- Rute Komentar (Pengiriman) ---
Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('comments.store');



// --- Rute Lembaga Desa ---
Route::get('/lembaga-desa', [InstitutionController::class, 'index'])->name('institutions.index');
Route::get('/lembaga-desa/{slug}', [InstitutionController::class, 'show'])->name('institutions.show');


// Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('profil.visi');
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
