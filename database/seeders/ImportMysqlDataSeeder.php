<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\SqlToMongoImporter;

class ImportMysqlDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting import MySQL data to MongoDB...');
        
        try {
            // Method 1: Use automatic SQL parser
            $this->importUsingSqlParser();
            
            // Method 2: Manual import (fallback)
            // $this->importManually();
            
            $this->command->info('Import completed successfully!');
        } catch (\Exception $e) {
            $this->command->error('Import failed: ' . $e->getMessage());
            
            // Fallback to manual import
            $this->command->info('Falling back to manual import...');
            $this->importManually();
        }
    }
    
    private function importUsingSqlParser()
    {
        $sqlFile = database_path('glx2023.sql');
        
        if (!file_exists($sqlFile)) {
            throw new \Exception("SQL file not found: {$sqlFile}");
        }
        
        $importer = new SqlToMongoImporter($sqlFile);
        $importer->import();
    }
    
    private function importManually()
    {
        $this->command->info('Using manual import method...');
        
        // Import BlockUi data
        $this->importBlockUiData();
        
        // Import Menu data
        $this->importMenuTreeData();
    }
    
    private function importBlockUiData()
    {
        $this->command->info('Importing BlockUi data...');
        
        // Clear existing data
        \App\Models\BlockUi::truncate();
        
        $blockUiData = [
            [
                '_id' => '1',
                'name' => 'Giới thiệu',
                'sname' => null,
                'summary' => null,
                'summary2' => null,
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => \Carbon\Carbon::parse('2023-04-26 07:38:38'),
                'log' => null,
                'siteid' => null,
                'extra_info' => null,
                'image_list' => null,
                'tags_list' => null,
                'created_at' => \Carbon\Carbon::parse('2023-03-28 05:21:38'),
                'status' => 1,
                'content' => '<p><strong>Sample content for Giới thiệu...</strong></p>',
                'guide_admin' => null,
                'extra_color_background' => null,
                'extra_color_text' => null,
                'group_name' => null
            ],
            [
                '_id' => '2',
                'name' => null,
                'sname' => 'logo-top-home-page',
                'summary' => null,
                'summary2' => null,
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => \Carbon\Carbon::parse('2023-07-31 14:26:15'),
                'log' => null,
                'siteid' => null,
                'extra_info' => null,
                'image_list' => '1844',
                'tags_list' => null,
                'created_at' => \Carbon\Carbon::parse('2023-07-31 14:21:04'),
                'status' => null,
                'content' => null,
                'guide_admin' => null,
                'extra_color_background' => null,
                'extra_color_text' => null,
                'group_name' => null
            ]
        ];
        
        foreach ($blockUiData as $data) {
            \App\Models\BlockUi::create($data);
        }
        
        $this->command->info('BlockUi data imported: ' . count($blockUiData) . ' records');
    }
    
    private function importMenuTreeData()
    {
        $this->command->info('Importing MenuTree data...');
        
        // Clear existing data
        \App\Models\MenuTree::truncate();
        
        // Sample menu tree data
        $menuTreeData = [
            [
                '_id' => '1',
                'name' => 'Trang chủ',
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'deleted_at' => null,
                'orders' => 1,
                'link' => '/',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => 'fas fa-home',
                'id_news' => null
            ],
            [
                '_id' => '2',
                'name' => 'Giới thiệu',
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'deleted_at' => null,
                'orders' => 2,
                'link' => '/gioi-thieu',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => 'fas fa-info-circle',
                'id_news' => 1
            ],
            [
                '_id' => '3',
                'name' => 'Menu Root',
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'deleted_at' => null,
                'orders' => 0,
                'link' => '#',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => null,
                'id_news' => null
            ]
        ];
        
        foreach ($menuTreeData as $data) {
            \App\Models\MenuTree::create($data);
        }
        
        $this->command->info('MenuTree data imported: ' . count($menuTreeData) . ' records');
    }
}
