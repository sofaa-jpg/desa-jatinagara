<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStoragePermissions extends Command
{
    protected $signature = 'storage:fix-permissions';
    protected $description = 'Fix storage permissions and create missing directories';

    public function handle()
    {
        $this->info('Fixing storage permissions and creating directories...');

        $directories = [
            storage_path('app'),
            storage_path('app/public'),
            storage_path('app/public/gallery_images'),
            storage_path('app/public/gallery_covers'),
            storage_path('logs'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Created directory: {$directory}");
            } else {
                $this->info("Directory exists: {$directory}");
            }

            // Set permissions
            if (File::exists($directory)) {
                chmod($directory, 0755);
                $this->info("Set permissions 755 for: {$directory}");
            }
        }

        // Buat symlink jika belum ada
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        if (!file_exists($linkPath)) {
            if (PHP_OS_FAMILY === 'Windows') {
                $this->warn('On Windows, you may need to run as Administrator or use: php artisan storage:link');
            } else {
                symlink($targetPath, $linkPath);
                $this->info("Created symlink: {$linkPath} -> {$targetPath}");
            }
        } else {
            $this->info("Symlink already exists: {$linkPath}");
        }

        // Test write permissions
        $testFile = storage_path('app/public/test_write.txt');
        try {
            file_put_contents($testFile, 'test');
            unlink($testFile);
            $this->info('✓ Storage is writable');
        } catch (\Exception $e) {
            $this->error('✗ Storage is NOT writable: ' . $e->getMessage());
        }

        $this->info('Storage permissions fix completed!');
        
        return 0;
    }
}