<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HeroSlider;

class CleanHeroSliderDescriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hero-slider:clean-descriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membersihkan HTML tags dari deskripsi hero slider';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Membersihkan HTML tags dari deskripsi hero slider...');
        
        $sliders = HeroSlider::all();
        $cleaned = 0;
        
        foreach ($sliders as $slider) {
            $originalDescription = $slider->description;
            $cleanDescription = strip_tags($slider->description);
            
            if ($originalDescription !== $cleanDescription) {
                $slider->description = $cleanDescription;
                $slider->save();
                $cleaned++;
                
                $this->line("✓ Dibersihkan: {$slider->title}");
                $this->line("  Sebelum: {$originalDescription}");
                $this->line("  Sesudah: {$cleanDescription}");
                $this->newLine();
            }
        }
        
        if ($cleaned > 0) {
            $this->info("✅ Berhasil membersihkan HTML tags dari {$cleaned} hero slider!");
        } else {
            $this->info("✅ Semua deskripsi hero slider sudah bersih dari HTML tags.");
        }
        
        return 0;
    }
}
