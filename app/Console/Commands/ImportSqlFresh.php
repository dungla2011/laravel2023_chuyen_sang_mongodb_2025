<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportSqlFresh extends Command
{
    protected $signature = 'import:sql-fresh {file?}';
    protected $description = 'Clean MongoDB collections and import SQL file fresh';

    public function handle()
    {
        $this->info('🚀 Starting fresh SQL import to MongoDB...');
        
        // Step 1: Clean MongoDB
        $this->info("\n📋 Step 1: Cleaning MongoDB collections...");
        $cleanResult = $this->call('mongo:clean', ['--confirm' => true]);
        
        if ($cleanResult !== 0) {
            $this->error('❌ Failed to clean MongoDB collections');
            return 1;
        }
        
        // Step 2: Import SQL
        $this->info("\n📋 Step 2: Importing SQL data...");
        $file = $this->argument('file');
        $importArgs = $file ? ['file' => $file] : [];
        
        $importResult = $this->call('import:sql-to-mongo', $importArgs);
        
        if ($importResult === 0) {
            $this->info("\n🎉 Fresh import completed successfully!");
        } else {
            $this->error("\n❌ Import failed");
        }
        
        return $importResult;
    }
}
