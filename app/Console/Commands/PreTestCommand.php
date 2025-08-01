<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PreTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:pre-test-command';
    protected $signature = 'testglx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a command before executing php artisan test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Run the required command
//        $this->call('your:required-command');

        function deleteFilesWithSubstring($folderPath, $substring) {
            if (!is_dir($folderPath)) {
                return false;
            }

            $files = new \DirectoryIterator($folderPath);

            foreach ($files as $fileinfo) {
                if ($fileinfo->isFile() && str_contains($fileinfo->getFilename(), $substring) !== false) {
                    unlink($fileinfo->getRealPath());
                }
            }

            return true;
        }

// Usage
        $folderPath = sys_get_temp_dir()."/glx_web";
        $substring = 'glx_cache_meta_api';
        getch("...xtest ..., remove: $folderPath");
        deleteFilesWithSubstring($folderPath, $substring);




        // Run the test command
        $this->call('test');
    }
}
