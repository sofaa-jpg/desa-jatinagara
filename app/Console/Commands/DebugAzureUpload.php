<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DebugAzureUpload extends Command
{
    protected $signature = 'azure:debug-upload';
    protected $description = 'Debug Azure upload configuration and fix common issues';

    public function handle()
    {
        $this->info('🔍 Debugging Azure Upload Configuration...');

        // Check PHP configuration
        $this->checkPhpConfig();
        
        // Check directory permissions
        $this->checkPermissions();
        
        // Check Azure-specific settings
        $this->checkAzureSettings();
        
        // Fix known issues
        $this->fixCommonIssues();

        $this->info('✅ Azure upload debug completed!');
        
        return 0;
    }

    private function checkPhpConfig()
    {
        $this->info('📋 PHP Upload Configuration:');
        
        $configs = [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'file_uploads' => ini_get('file_uploads') ? 'On' : 'Off',
            'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: 'Default',
        ];

        foreach ($configs as $key => $value) {
            $this->line("  {$key}: {$value}");
        }
    }

    private function checkPermissions()
    {
        $this->info('🔐 Checking Directory Permissions:');
        
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/gallery_images'),
            storage_path('framework/views'),
            storage_path('logs'),
        ];

        foreach ($directories as $dir) {
            $exists = file_exists($dir);
            $writable = $exists ? is_writable($dir) : false;
            $perms = $exists ? substr(sprintf('%o', fileperms($dir)), -4) : 'N/A';
            
            $status = $exists && $writable ? '✅' : '❌';
            $this->line("  {$status} {$dir} (Perms: {$perms})");
            
            if (!$exists) {
                mkdir($dir, 0755, true);
                $this->line("    📁 Created directory");
            }
            
            if ($exists && !$writable) {
                chmod($dir, 0755);
                $this->line("    🔧 Fixed permissions");
            }
        }
    }

    private function checkAzureSettings()
    {
        $this->info('☁️ Azure-specific Checks:');
        
        // Check temp directory
        $tempDir = sys_get_temp_dir();
        $tempWritable = is_writable($tempDir);
        $this->line("  Temp Directory: {$tempDir} " . ($tempWritable ? '✅' : '❌'));
        
        // Check Azure environment variables
        $azureVars = [
            'WEBSITE_SITE_NAME',
            'WEBSITE_RESOURCE_GROUP', 
            'WEBSITE_OWNER_NAME',
            'RUNNING_IN_AZURE'
        ];
        
        foreach ($azureVars as $var) {
            $value = env($var, 'Not set');
            $this->line("  {$var}: {$value}");
        }
        
        // Check current PHP upload settings
        $this->line("");
        $this->line("  📋 Current PHP Upload Settings:");
        $uploadMax = ini_get('upload_max_filesize');
        $postMax = ini_get('post_max_size');
        
        $uploadStatus = $this->parseBytes($uploadMax) >= $this->parseBytes('10M') ? '✅' : '❌';
        $postStatus = $this->parseBytes($postMax) >= $this->parseBytes('15M') ? '✅' : '❌';
        
        $this->line("    upload_max_filesize: {$uploadMax} {$uploadStatus}");
        $this->line("    post_max_size: {$postMax} {$postStatus}");
        
        if ($uploadStatus === '❌' || $postStatus === '❌') {
            $this->warn("  ⚠️  PHP upload limits too small for file uploads!");
            $this->line("  💡 To fix in Azure App Service:");
            $this->line("     1. Go to Azure Portal > App Service > Configuration");
            $this->line("     2. Add Application Settings:");
            $this->line("        PHP_INI_UPLOAD_MAX_FILESIZE = 40M");
            $this->line("        PHP_INI_POST_MAX_SIZE = 50M");
            $this->line("        PHP_INI_MAX_FILE_UPLOADS = 20");
            $this->line("        PHP_INI_MEMORY_LIMIT = 256M");
            $this->line("     3. Restart the app service");
            $this->line("");
            $this->line("  🔧 Alternative: Deploy .user.ini and web.config files");
        }
        
        // Check disk space
        $freeSpace = disk_free_space(storage_path());
        $totalSpace = disk_total_space(storage_path());
        $freeGB = round($freeSpace / 1024 / 1024 / 1024, 2);
        $totalGB = round($totalSpace / 1024 / 1024 / 1024, 2);
        
        $this->line("  Disk Space: {$freeGB}GB free of {$totalGB}GB total");
    }
    
    private function parseBytes($val) {
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

    private function fixCommonIssues()
    {
        $this->info('🔧 Fixing Common Azure Issues:');
        
        // Clear view cache
        try {
            $this->call('view:clear');
            $this->line("  ✅ Cleared view cache");
        } catch (\Exception $e) {
            $this->line("  ❌ Failed to clear view cache: " . $e->getMessage());
        }
        
        // Clear config cache
        try {
            $this->call('config:clear');
            $this->line("  ✅ Cleared config cache");
        } catch (\Exception $e) {
            $this->line("  ❌ Failed to clear config cache: " . $e->getMessage());
        }
        
        // Fix storage link
        try {
            $linkPath = public_path('storage');
            $targetPath = storage_path('app/public');
            
            if (file_exists($linkPath) && !is_link($linkPath)) {
                // Remove if it's a directory instead of symlink
                if (is_dir($linkPath)) {
                    rmdir($linkPath);
                }
            }
            
            if (!file_exists($linkPath)) {
                $this->call('storage:link');
                $this->line("  ✅ Fixed storage symlink");
            } else {
                $this->line("  ✅ Storage symlink exists");
            }
        } catch (\Exception $e) {
            $this->line("  ❌ Failed to fix storage link: " . $e->getMessage());
        }
        
        // Test file write
        try {
            $testFile = storage_path('app/public/test_upload_' . time() . '.txt');
            file_put_contents($testFile, 'Test upload file');
            
            if (file_exists($testFile)) {
                unlink($testFile);
                $this->line("  ✅ File write test successful");
            } else {
                $this->line("  ❌ File write test failed");
            }
        } catch (\Exception $e) {
            $this->line("  ❌ File write test error: " . $e->getMessage());
        }
    }
}