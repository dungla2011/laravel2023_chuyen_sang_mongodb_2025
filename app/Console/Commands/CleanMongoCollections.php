<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanMongoCollections extends Command
{
    protected $signature = 'mongo:clean {--confirm}';
    protected $description = 'Clean all MongoDB collections before importing new data';

    public function handle()
    {
        if (!$this->option('confirm')) {
            $this->error('⚠️  This will DELETE ALL data in MongoDB collections!');
            $this->info('Use --confirm flag to proceed: php artisan mongo:clean --confirm');
            return 1;
        }
        
        $this->info('🧹 Cleaning MongoDB collections...');
        
        // Get all collection names
        $mongodb = DB::connection('mongodb')->getMongoDB();
        $collections = $mongodb->listCollections();
        
        $deletedCount = 0;
        $totalCollections = 0;
        
        foreach ($collections as $collection) {
            $collectionName = $collection->getName();
            
            // Skip system collections
            if (str_starts_with($collectionName, 'system.')) {
                continue;
            }
            
            $totalCollections++;
            $count = DB::connection('mongodb')->table($collectionName)->count();
            
            if ($count > 0) {
                DB::connection('mongodb')->table($collectionName)->delete();
                $this->line("🗑️  Deleted $count documents from '$collectionName'");
                $deletedCount += $count;
            } else {
                $this->line("✅ Collection '$collectionName' already empty");
            }
        }
        
        $this->info("\n📊 Summary:");
        $this->info("- Total collections processed: $totalCollections");
        $this->info("- Total documents deleted: " . number_format($deletedCount));
        $this->info("✅ MongoDB cleanup completed!");
        
        return 0;
    }
}
