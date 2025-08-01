# Notes for Laravel Development on Windows

## Artisan Tinker Commands

### Correct syntax for**Admin user đã được tạo:**
- Email: admin@abc.com
- Username: admin  
- Password: admin123456
- Created in both databases:
  - CLI database (`glx2023_for_testing`): ID 688c97c5de7386e5b7015e52
  - Web database (`test_2025`): ID 688c9b6b61ef86894f0b19f2
- Password hashing: Sử dụng bcrypt() tự động qua setPasswordAttribute()

**Scripts:**
- `php create_admin_user.php` - Tạo trong CLI database
- `php check_both_databases.php` - Kiểm tra và tạo trong cả 2 databaseting code in tinker on Windows:
```bash
php artisan tinker --execute="use App\Models\ModelName; echo 'Count: ' . ModelName::count() . PHP_EOL;"
```

### Important points:
1. **Windows command separator**: Use `;` instead of `&&` to separate multiple commands
2. **PHP_EOL**: Use `PHP_EOL` instead of `\n` for proper line endings
3. **Quotes**: Use double quotes for the execute parameter
4. **Multiple use statements**: Can be done on separate lines or separated by semicolons
5. **Dollar sign escape**: Variables with `$` need to be escaped with backtick `` ` `` in Windows PowerShell

### Examples:
```bash
# Single model count
php artisan tinker --execute="use App\Models\User; echo 'Users: ' . User::count() . PHP_EOL;"

# Multiple models
php artisan tinker --execute="use App\Models\BlockUi; use App\Models\MenuTree; echo 'BlockUi: ' . BlockUi::count() . PHP_EOL; echo 'MenuTree: ' . MenuTree::count() . PHP_EOL;"

# Get sample data
php artisan tinker --execute="use App\Models\BlockUi; `$items = BlockUi::take(3)->get(); foreach(`$items as `$item) { echo 'ID: ' . `$item->_id . ', Name: ' . `$item->name . PHP_EOL; }"

# List all users with escaped variables
php artisan tinker --execute="use App\Models\User; `$users = User::all(); foreach(`$users as `$user) { echo 'ID: ' . `$user->_id . ', Email: ' . `$user->email . ', Username: ' . `$user->username . PHP_EOL; }"

# Find specific user
php artisan tinker --execute="use App\Models\User; `$user = User::where('email', 'admin@abc.com')->first(); if(`$user) echo 'Found: ' . `$user->email; else echo 'Not found';"

# Create new user with escaped variables
php artisan tinker --execute="use App\Models\User; `$user = new User(); `$user->name = 'Test User'; `$user->email = 'test@example.com'; `$user->save(); echo 'Created user ID: ' . `$user->_id;"
```

## Database Seeding

### Run specific seeder:
```bash
php artisan db:seed --class=AllTablesSeeder
```

### Check seeded data:
```bash
php check_seeded_data.php
```

### Seeded Models (5 records each):
- BlockUi (content blocks)
- MenuTree (navigation menus)
- Menu (simple menus)
- DemoTbl (demo table)
- DemoFolderTbl (demo folders)
- DemoAndTagTbl (demo with tags)
- Category (product categories)
- Product (products)
- ProductFolder (product folders)
- ProductTag (product tags)
- ProductImage (product images)
- Cart (shopping carts)
- CartItem (cart items)

**Total: 65 records across 13 models**

## Common Windows vs Linux differences:
- Command separator: `;` (Windows) vs `&&` (Linux)
- Path separator: `\` (Windows) vs `/` (Linux)
- Line endings: `CRLF` (Windows) vs `LF` (Linux)
- **Variable escape in PowerShell**: Use backtick `` `$ `` to escape dollar signs in tinker commands

## MongoDB with Laravel specifics:
- Use `MongoDB\Laravel\Eloquent\Model` instead of `Illuminate\Database\Eloquent\Model`
- Set `protected $connection = 'mongodb';` in base model
- **Primary Key**: MongoDB uses `_id` field (not `id` like MySQL) - this is correct and expected
- Date fields are automatically converted to MongoDB UTCDateTime objects
- **BelongsToMany relationships**: Work correctly with pivot collections (e.g., `role_user`)
- **Collection access**: Use `DB::connection('mongodb')->table('collection_name')` (not `collection()` method)

## Model Structure Notes:
**Important**: Các bảng nằm trong `/app/Models/<ModelName>.php` trong đó `<ModelName>_Meta` không phải là bảng, mà là mô tả Meta cho bảng. Ví dụ:
- `User.php` - Model thực tế của bảng users  
- `User_Meta.php` - Metadata description, không phải bảng thực tế
- `Product.php` - Model thực tế của bảng products
- `Product_Meta.php` - Metadata description, không phải bảng thực tế

## Troubleshooting:

### Function Redeclaration Error:
**Problem**: "Cannot redeclare getDesOfField" error
**Cause**: Functions defined in Blade templates can be included multiple times
**Solution**: Wrap function definitions with `function_exists()` check:
```php
if (!function_exists('getDesOfField')) {
    function getDesOfField($field, $static) {
        // function code
    }
}
```

### Database Multi-Domain Configuration:
**QUAN TRỌNG**: Project sử dụng database khác nhau cho CLI và Web:
- **CLI/Tinker**: Database `glx2023_for_testing` (mặc định trong config)
- **Web Interface**: Database `test_2025` (theo domain mapping trong `$GLOBALS['mMapDomainDb']`)

**Domain Mapping:**
- `127.0.0.1` → database `test_2025`
- `abc.vn` → database `test_2025`  
- `a1.abc.vn` → database `test_2025`

**Lưu ý**: User/data tạo qua CLI sẽ không hiển thị trên web và ngược lại!

## Admin User Management:
**Admin user đã được tạo:**
- Email: admin@example.com
- Username: admin  
- Password: admin123456
- Created with script: `php create_admin_user.php`
- Password hashing: Sử dụng bcrypt() tự động qua setPasswordAttribute()

## Seeder Development Tips:
1. **Model mapping**: Update `SqlToMongoImporter` class for automatic SQL parsing
2. **Generic seeding**: Use `seedGenericTable()` method for simple models
3. **Error handling**: Models that don't exist will be skipped with warnings
4. **Data validation**: Always test with sample queries after seeding

## SQL to MongoDB Import:
**Import Results**: ✅ Successfully imported **15,515 records** from SQL dump
- **Collections Created**: 55 tables/collections
- **File Size**: 1.5MB (`database/glx_for_import_mongo.sql`)
- **Commands**:
  ```bash
  php artisan import:sql-to-mongo          # Import SQL file
  php artisan mongo:clean --confirm        # Clean collections
  php artisan import:sql-fresh            # Clean + Import
  ```

## MongoDB Relationships Testing:
**belongsToMany Test Results**:
- ✅ `User::_roles()` relationship **works correctly**
- ✅ Collections exist: `users` (137), `roles` (11), `role_user` (9,623)
- ⚠️ **Issue**: Pivot table `role_user` has wrong structure (imported as documents instead of user_id/role_id pairs)
- **Test Script**: `php test_user_roles_relationship.php`

**MongoDB `_id` Field**:
- ✅ **Completely normal** to use `_id` instead of `id`
- ✅ Laravel MongoDB package handles this automatically
- ✅ Relationships work fine with `_id` primary keys
- ✅ No need to change to `id` field
