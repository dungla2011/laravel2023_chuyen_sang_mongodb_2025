<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AllTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting comprehensive seeding for all tables...');
        
        // Main content tables
        $this->seedBlockUis();
        $this->seedMenus();
        $this->seedMenuTrees();
        
        // Demo tables
        $this->seedDemoTbls();
        $this->seedDemoFolderTbls();
        $this->seedDemoAndTagTbls();
        
        // Category and product tables
        $this->seedCategories();
        $this->seedProducts();
        $this->seedProductFolders();
        $this->seedProductTags();
        $this->seedProductImages();
        
        // Cart and order tables
        $this->seedCarts();
        $this->seedCartItems();
        $this->seedOrderInfos();
        $this->seedOrderItems();
        
        // Event management tables
        $this->seedEventInfos();
        $this->seedEventUserInfos();
        $this->seedEventAndUsers();
        $this->seedEventRegisters();
        
        // CRM tables
        $this->seedCrmAppInfos();
        $this->seedCrmMessages();
        $this->seedCrmMessageGroups();
        
        // Conference tables
        $this->seedConferenceCats();
        $this->seedConferenceInfos();
        
        // Department tables
        $this->seedDepartments();
        $this->seedDepartmentEvents();
        $this->seedDepartmentUsers();
        
        // File management tables
        $this->seedFileClouds();
        $this->seedFileUploads();
        $this->seedFolderFiles();
        
        // News and content tables
        $this->seedNews();
        $this->seedNewsFolders();
        
        // User and permission tables
        $this->seedRoles();
        $this->seedPermissions();
        $this->seedRoleUser();
        
        // Other utility tables
        $this->seedCacheKeyValues();
        $this->seedChangeLogs();
        $this->seedCloudServers();
        $this->seedDonViHanhChinhs();
        $this->seedNotifications();
        $this->seedPayments();
        $this->seedTags();
        
        $this->command->info('All tables seeded successfully!');
    }
    
    private function seedBlockUis()
    {
        $this->command->info('Seeding BlockUis...');
        \App\Models\BlockUi::truncate();
        
        $data = [
            [
                '_id' => '1',
                'name' => 'Giới thiệu',
                'sname' => null,
                'summary' => 'Trang giới thiệu công ty',
                'summary2' => null,
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => Carbon::parse('2023-04-26 07:38:38'),
                'log' => null,
                'siteid' => 1,
                'extra_info' => 'Thông tin bổ sung',
                'image_list' => '1,2,3',
                'tags_list' => 'intro,company',
                'created_at' => Carbon::parse('2023-03-28 05:21:38'),
                'status' => 1,
                'content' => '<p>Nội dung giới thiệu công ty...</p>',
                'guide_admin' => 'Hướng dẫn admin',
                'extra_color_background' => '#ffffff',
                'extra_color_text' => '#000000',
                'group_name' => 'main'
            ],
            [
                '_id' => '2',
                'name' => 'Logo trang chủ',
                'sname' => 'logo-top-home-page',
                'summary' => null,
                'summary2' => null,
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => Carbon::now(),
                'log' => null,
                'siteid' => 1,
                'extra_info' => null,
                'image_list' => '1844',
                'tags_list' => 'logo,header',
                'created_at' => Carbon::now(),
                'status' => 1,
                'content' => null,
                'guide_admin' => null,
                'extra_color_background' => null,
                'extra_color_text' => null,
                'group_name' => 'header'
            ],
            [
                '_id' => '3',
                'name' => 'Slide ảnh trang chủ',
                'sname' => 'slide-img-home-page',
                'summary' => 'Slide show trang chủ',
                'summary2' => null,
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => Carbon::now(),
                'log' => null,
                'siteid' => 1,
                'extra_info' => 'Slideshow configuration',
                'image_list' => '1845,1846,1847',
                'tags_list' => 'slide,homepage',
                'created_at' => Carbon::now(),
                'status' => 1,
                'content' => '<div>Slide content</div>',
                'guide_admin' => 'Upload multiple images for slideshow',
                'extra_color_background' => null,
                'extra_color_text' => null,
                'group_name' => 'slideshow'
            ],
            [
                '_id' => '4',
                'name' => 'Tiêu đề trang chủ',
                'sname' => 'top-title-home-page',
                'summary' => '09.02.06.6768',
                'summary2' => 'Phiên bản mới',
                'module_table' => null,
                'idModule' => null,
                'deleted_at' => null,
                'updated_at' => Carbon::now(),
                'log' => 'Updated title configuration',
                'siteid' => 1,
                'extra_info' => '1',
                'image_list' => null,
                'tags_list' => 'title,header',
                'created_at' => Carbon::now(),
                'status' => 1,
                'content' => '<h1>Welcome to our website</h1>',
                'guide_admin' => 'Đưa vào summary',
                'extra_color_background' => '#f8f9fa',
                'extra_color_text' => '#212529',
                'group_name' => 'title'
            ],
            [
                '_id' => '5',
                'name' => 'Luyện toán Misu',
                'sname' => 'banner-bottom',
                'summary' => 'Khóa học toán nâng cao',
                'summary2' => 'Dành cho trẻ em từ 6-10 tuổi',
                'module_table' => 'courses',
                'idModule' => 'math_course_1',
                'deleted_at' => null,
                'updated_at' => Carbon::now(),
                'log' => 'Course banner updated',
                'siteid' => 1,
                'extra_info' => 'Math course information',
                'image_list' => '1825',
                'tags_list' => 'math,education,kids',
                'created_at' => Carbon::now(),
                'status' => 1,
                'content' => '* Toán lớp 1 nâng cao<br />* Toán lớp 2 nâng cao<br />* Toán singapore nâng cao từ 7-8 tuổi<br />* Toán singapore nâng cao từ 8-9 tuổi',
                'guide_admin' => '- Chọn 1 ảnh đại diện\n- Nội dung đưa vào Content bên dưới',
                'extra_color_background' => '#e3f2fd',
                'extra_color_text' => '#1976d2',
                'group_name' => 'courses'
            ]
        ];
        
        foreach ($data as $item) {
            \App\Models\BlockUi::create($item);
        }
        
        $this->command->info('BlockUis seeded: ' . count($data) . ' records');
    }
    
    private function seedMenus()
    {
        $this->command->info('Seeding Menus...');
        
        try {
            \App\Models\Menu::truncate();
            
            $data = [
                [
                    '_id' => '1',
                    'name' => 'M11',
                    'parent_id' => null,
                    'created_at' => Carbon::parse('2022-07-09 03:10:20'),
                    'updated_at' => Carbon::parse('2022-07-09 03:11:23'),
                    'deleted_at' => null,
                    'slug' => '',
                    'site_id' => 0
                ],
                [
                    '_id' => '2',
                    'name' => 'M2',
                    'parent_id' => null,
                    'created_at' => Carbon::parse('2022-07-09 05:25:04'),
                    'updated_at' => Carbon::parse('2022-07-09 05:25:04'),
                    'deleted_at' => null,
                    'slug' => '',
                    'site_id' => 0
                ],
                [
                    '_id' => '3',
                    'name' => 'm21',
                    'parent_id' => 2,
                    'created_at' => Carbon::parse('2022-07-09 05:26:33'),
                    'updated_at' => Carbon::parse('2022-07-09 05:26:33'),
                    'deleted_at' => null,
                    'slug' => '',
                    'site_id' => 0
                ],
                [
                    '_id' => '4',
                    'name' => 'm23',
                    'parent_id' => 2,
                    'created_at' => Carbon::parse('2022-07-09 05:27:46'),
                    'updated_at' => Carbon::parse('2022-07-09 05:27:46'),
                    'deleted_at' => null,
                    'slug' => 'm23',
                    'site_id' => 0
                ],
                [
                    '_id' => '5',
                    'name' => '12222',
                    'parent_id' => 1,
                    'created_at' => Carbon::parse('2022-07-10 05:49:26'),
                    'updated_at' => Carbon::parse('2022-07-10 05:50:35'),
                    'deleted_at' => null,
                    'slug' => '12222',
                    'site_id' => 0
                ]
            ];
            
            foreach ($data as $item) {
                \App\Models\Menu::create($item);
            }
            
            $this->command->info('Menus seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed Menus: ' . $e->getMessage());
        }
    }
    
    private function seedMenuTrees()
    {
        $this->command->info('Seeding MenuTrees...');
        \App\Models\MenuTree::truncate();
        
        $data = [
            [
                '_id' => '1',
                'name' => 'Trang chủ',
                'parent_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'orders' => 0,
                'link' => '#',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => null,
                'id_news' => null
            ],
            [
                '_id' => '4',
                'name' => 'Sản phẩm',
                'parent_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'orders' => 3,
                'link' => '/san-pham',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => 'fas fa-box',
                'id_news' => null
            ],
            [
                '_id' => '5',
                'name' => 'Liên hệ',
                'parent_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'orders' => 4,
                'link' => '/lien-he',
                'gid_allow' => '0,1',
                'open_new_window' => 0,
                'icon' => 'fas fa-envelope',
                'id_news' => null
            ]
        ];
        
        foreach ($data as $item) {
            \App\Models\MenuTree::create($item);
        }
        
        $this->command->info('MenuTrees seeded: ' . count($data) . ' records');
    }
    
    private function seedDemoTbls()
    {
        $this->command->info('Seeding DemoTbls...');
        
        try {
            \App\Models\DemoTbl::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Demo Item $i",
                    'deleted_at' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\DemoTbl::create($item);
            }
            
            $this->command->info('DemoTbls seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed DemoTbls: ' . $e->getMessage());
        }
    }
    
    private function seedDemoFolderTbls()
    {
        $this->command->info('Seeding DemoFolderTbls...');
        
        try {
            \App\Models\DemoFolderTbl::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Demo Folder $i",
                    'orders' => $i,
                    'parent_id' => $i > 2 ? 1 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\DemoFolderTbl::create($item);
            }
            
            $this->command->info('DemoFolderTbls seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed DemoFolderTbls: ' . $e->getMessage());
        }
    }
    
    private function seedDemoAndTagTbls()
    {
        $this->command->info('Seeding DemoAndTagTbls...');
        
        try {
            \App\Models\DemoAndTagTbl::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Demo Tag Item $i",
                    'tag_id' => $i,
                    'demo_id' => $i,
                    'deleted_at' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\DemoAndTagTbl::create($item);
            }
            
            $this->command->info('DemoAndTagTbls seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed DemoAndTagTbls: ' . $e->getMessage());
        }
    }
    
    private function seedCategories()
    {
        $this->command->info('Seeding Categories...');
        
        try {
            \App\Models\Category::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Category $i",
                    'slug' => "category-$i",
                    'description' => "Description for category $i",
                    'site_id' => 1,
                    'parent_id' => $i > 2 ? 1 : 0,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\Category::create($item);
            }
            
            $this->command->info('Categories seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed Categories: ' . $e->getMessage());
        }
    }
    
    private function seedProducts()
    {
        $this->command->info('Seeding Products...');
        
        try {
            \App\Models\Product::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Product $i",
                    'type' => $i % 2 == 0 ? 'digital' : 'physical',
                    'price' => rand(10000, 500000),
                    'description' => "Description for product $i",
                    'sku' => "SKU-$i",
                    'status' => 1,
                    'category_id' => rand(1, 5),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\Product::create($item);
            }
            
            $this->command->info('Products seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed Products: ' . $e->getMessage());
        }
    }
    
    private function seedProductFolders()
    {
        $this->command->info('Seeding ProductFolders...');
        
        try {
            \App\Models\ProductFolder::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Product Folder $i",
                    'front' => $i % 2,
                    'parent_id' => $i > 2 ? 1 : 0,
                    'orders' => $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\ProductFolder::create($item);
            }
            
            $this->command->info('ProductFolders seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed ProductFolders: ' . $e->getMessage());
        }
    }
    
    private function seedProductTags()
    {
        $this->command->info('Seeding ProductTags...');
        
        try {
            \App\Models\ProductTag::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Product Tag $i",
                    'slug' => "product-tag-$i",
                    'site_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\ProductTag::create($item);
            }
            
            $this->command->info('ProductTags seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed ProductTags: ' . $e->getMessage());
        }
    }
    
    private function seedProductImages()
    {
        $this->command->info('Seeding ProductImages...');
        
        try {
            \App\Models\ProductImage::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'product_id' => rand(1, 5),
                    'image_url' => "https://example.com/image-$i.jpg",
                    'alt_text' => "Product image $i",
                    'site_id' => 1,
                    'is_primary' => $i == 1 ? 1 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\ProductImage::create($item);
            }
            
            $this->command->info('ProductImages seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed ProductImages: ' . $e->getMessage());
        }
    }
    
    private function seedCarts()
    {
        $this->command->info('Seeding Carts...');
        
        try {
            \App\Models\Cart::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'name' => "Cart $i",
                    'user_id' => $i,
                    'status' => rand(0, 1),
                    'log' => "Cart created for user $i",
                    'session_id' => "session_$i",
                    'total_amount' => rand(50000, 1000000),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\Cart::create($item);
            }
            
            $this->command->info('Carts seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed Carts: ' . $e->getMessage());
        }
    }
    
    private function seedCartItems()
    {
        $this->command->info('Seeding CartItems...');
        
        try {
            \App\Models\CartItem::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $data[] = [
                    '_id' => (string)$i,
                    'cart_id' => rand(1, 5),
                    'product_id' => rand(1, 5),
                    'quantity' => rand(1, 10),
                    'price' => rand(10000, 100000),
                    'log' => "Item added to cart",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            
            foreach ($data as $item) {
                \App\Models\CartItem::create($item);
            }
            
            $this->command->info('CartItems seeded: ' . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn('Could not seed CartItems: ' . $e->getMessage());
        }
    }
    
    // Continue with remaining methods...
    private function seedOrderInfos()
    {
        $this->seedGenericTable('OrderInfo', 'Order', ['usage_status' => 'available']);
    }
    
    private function seedOrderItems()
    {
        $this->seedGenericTable('OrderItem', 'Order Item', ['note' => 'Order item note']);
    }
    
    private function seedEventInfos()
    {
        $this->seedGenericTable('EventInfo', 'Event', ['limit_max_member' => 100]);
    }
    
    private function seedEventUserInfos()
    {
        $this->seedGenericTable('EventUserInfo', 'Event User', ['gender' => rand(0, 1)]);
    }
    
    private function seedEventAndUsers()
    {
        $this->seedGenericTable('EventAndUser', 'Event User Relation', ['signature' => rand(1000, 9999)]);
    }
    
    private function seedEventRegisters()
    {
        $this->seedGenericTable('EventRegister', 'Event Register', ['sub_event_list' => 'event1,event2']);
    }
    
    private function seedCrmAppInfos()
    {
        $this->seedGenericTable('CrmAppInfo', 'CRM App', ['log' => 'CRM app info']);
    }
    
    private function seedCrmMessages()
    {
        $this->seedGenericTable('CrmMessage', 'CRM Message', ['channel_name' => 'email']);
    }
    
    private function seedCrmMessageGroups()
    {
        $this->seedGenericTable('CrmMessageGroup', 'CRM Message Group', ['full_info' => 'Group information']);
    }
    
    private function seedConferenceCats()
    {
        $this->seedGenericTable('ConferenceCat', 'Conference Category', ['log' => 'Conference category']);
    }
    
    private function seedConferenceInfos()
    {
        $this->seedGenericTable('ConferenceInfo', 'Conference', ['orders' => rand(1, 10)]);
    }
    
    private function seedDepartments()
    {
        $this->seedGenericTable('Department', 'Department', ['log' => 'Department info']);
    }
    
    private function seedDepartmentEvents()
    {
        $this->seedGenericTable('DepartmentEvent', 'Department Event', ['department_id' => rand(1, 5)]);
    }
    
    private function seedDepartmentUsers()
    {
        $this->seedGenericTable('DepartmentUser', 'Department User', ['log' => 'Department user']);
    }
    
    private function seedFileClouds()
    {
        $this->seedGenericTable('FileCloud', 'File Cloud', ['last_save_doc' => Carbon::now()]);
    }
    
    private function seedFileUploads()
    {
        $this->seedGenericTable('FileUpload', 'File Upload', ['ip_upload' => '192.168.1.1']);
    }
    
    private function seedFolderFiles()
    {
        $this->seedGenericTable('FolderFile', 'Folder File', ['link1' => 'link123']);
    }
    
    private function seedNews()
    {
        $this->seedGenericTable('News', 'News Article', ['count_view' => rand(1, 1000)]);
    }
    
    private function seedNewsFolders()
    {
        $this->seedGenericTable('NewsFolder', 'News Folder', ['front' => rand(0, 1)]);
    }
    
    private function seedRoles()
    {
        $this->seedGenericTable('Role', 'Role', ['site_id' => 1]);
    }
    
    private function seedPermissions()
    {
        $this->seedGenericTable('Permission', 'Permission', ['site_id' => 1]);
    }
    
    private function seedRoleUser()
    {
        $this->seedGenericTable('RoleUser', 'Role User', ['deleted_at' => null]);
    }
    
    private function seedCacheKeyValues()
    {
        $this->seedGenericTable('CacheKeyValue', 'Cache', ['value' => 'cached_value']);
    }
    
    private function seedChangeLogs()
    {
        $this->seedGenericTable('ChangeLog', 'Change Log', ['tag_log' => 'System change']);
    }
    
    private function seedCloudServers()
    {
        $this->seedGenericTable('CloudServer', 'Cloud Server', ['deleted_at' => null]);
    }
    
    private function seedDonViHanhChinhs()
    {
        $this->seedGenericTable('DonViHanhChinh', 'Administrative Unit', ['orders' => rand(1, 10)]);
    }
    
    private function seedNotifications()
    {
        $this->seedGenericTable('Notification', 'Notification', ['log' => 'Notification log']);
    }
    
    private function seedPayments()
    {
        $this->seedGenericTable('Payment', 'Payment', ['transaction_id' => 'TXN_' . time()]);
    }
    
    private function seedTags()
    {
        $this->seedGenericTable('Tag', 'Tag', ['site_id' => 1]);
    }
    
    /**
     * Generic seeder for tables with minimal structure
     */
    private function seedGenericTable($modelName, $displayName, $extraFields = [])
    {
        $this->command->info("Seeding {$displayName}s...");
        
        try {
            $modelClass = "\\App\\Models\\{$modelName}";
            
            if (!class_exists($modelClass)) {
                $this->command->warn("Model {$modelClass} does not exist, skipping...");
                return;
            }
            
            $modelClass::truncate();
            
            $data = [];
            for ($i = 1; $i <= 5; $i++) {
                $item = [
                    '_id' => (string)$i,
                    'name' => "{$displayName} $i",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                
                $item = array_merge($item, $extraFields);
                $data[] = $item;
            }
            
            foreach ($data as $item) {
                $modelClass::create($item);
            }
            
            $this->command->info("{$displayName}s seeded: " . count($data) . ' records');
        } catch (\Exception $e) {
            $this->command->warn("Could not seed {$displayName}s: " . $e->getMessage());
        }
    }
}
