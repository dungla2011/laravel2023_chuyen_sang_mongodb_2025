<?php
$storage = "/share";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $storage = "e:/1";
}

return [

    'backup' => [
        //'name' => env('APP_NAME', 'laravel-backup'),
        'name' => gethostname(),
        'source' => [
            'files' => [
                'include' => [
                    '/bin/glxStartSocketServer',
                    '/bin/glxNcbdMailSend',
                    base_path(),
                    '/etc',
                    '/var/glx/upload_file_glx',
                ],
                'exclude' => [
//                    base_path('vendor'),
                    base_path('storage'),
                    base_path('node_modules'),
                    base_path('.git'), // Exclude .git folder
                    // Add other folders to exclude here
                ],
                'follow_links' => false,
                'ignore_unreadable_directories' => false,
                'relative_path' => null,
                'direct_copy' => [ // New configuration for direct copy
//                    base_path('storage'),
//                    base_path('public/uploads'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],

        'database_dump_compressor' => null,
        'database_dump_file_timestamp_format' => null,
        'database_dump_filename_base' => 'database',
        'database_dump_file_extension' => '',

        'destination' => [
            'compression_method' => ZipArchive::CM_DEFAULT,
            'compression_level' => 9,
            'filename_prefix' => '',
            'disks' => [
                'ftp'
            ],
        ],

        'temporary_directory' => sys_get_temp_dir() . '/backup-temp',
        'password' => env('BACKUP_ARCHIVE_PASSWORD'),
        'encryption' => 'default',
        'tries' => 1,
        'retry_delay' => 0,
    ],

    'monitor_backups1' => [
        [
            'name' => env('APP_NAME', 'laravel-backup'),
            'disks' => ['local'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,
        'default_strategy' => [
            'keep_all_backups_for_days' => 7,
            'keep_daily_backups_for_days' => 16,
            'keep_weekly_backups_for_weeks' => 8,
            'keep_monthly_backups_for_months' => 4,
            'keep_yearly_backups_for_years' => 2,
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
        'tries' => 1,
        'retry_delay' => 0,
    ],

];
