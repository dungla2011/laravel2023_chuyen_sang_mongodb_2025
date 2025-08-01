# SQL to MongoDB Import Scripts

## Overview
Các script để import file SQL dump vào MongoDB cho Laravel project.

## Available Commands

### 1. Import SQL to MongoDB
```bash
php artisan import:sql-to-mongo [file]
```
- Import file SQL vào MongoDB
- Mặc định: `database/glx_for_import_mongo.sql`
- Hỗ trợ multi-row INSERT statements
- Tự động convert data types (dates, numbers, strings)
- Có progress bar và verification

### 2. Clean MongoDB Collections
```bash
php artisan mongo:clean --confirm
```
- Xóa tất cả data trong MongoDB collections
- Cần flag `--confirm` để đảm bảo an toàn
- Bỏ qua system collections

### 3. Fresh Import (Clean + Import)
```bash
php artisan import:sql-fresh [file]
```
- Xóa data cũ và import fresh
- Chạy clean + import tuần tự
- Báo cáo tổng hợp

## File Structure
```
database/
├── glx_for_import_mongo.sql    # File SQL chính
├── glx2023.sql                 # File backup
app/Console/Commands/
├── ImportSqlToMongo.php        # Import command
├── CleanMongoCollections.php   # Clean command
└── ImportSqlFresh.php          # Fresh import command
```

## Example Usage

### Import lần đầu
```bash
php artisan import:sql-to-mongo
```

### Re-import (clean data cũ)
```bash
php artisan import:sql-fresh
```

### Chỉ xóa data
```bash
php artisan mongo:clean --confirm
```

### Import file khác
```bash
php artisan import:sql-to-mongo database/other_file.sql
```

## Data Conversion

### Supported SQL Types
- `INT`, `BIGINT`, `TINYINT` → `int`
- `DECIMAL`, `FLOAT`, `DOUBLE` → `float`
- `DATETIME`, `TIMESTAMP` → ISO string
- `DATE` → Date string (Y-m-d)
- `VARCHAR`, `TEXT` → string
- `NULL` → null

### Auto-added Fields
- `created_at`: Current timestamp (if not exists)
- `updated_at`: Current timestamp (if not exists)

## Last Import Results
- **Total Records**: 15,515
- **Collections**: 55 tables
- **File Size**: 1.5MB
- **Status**: ✅ Success

### Top Collections by Size
- `role_user`: 9,618 records
- `permissions`: 2,704 records
- `demo_tbls`: 552 records
- `migrations`: 337 records
- `menu_trees`: 285 records

## Troubleshooting

### Duplicate Key Errors
- Xảy ra khi import data đã tồn tại
- Solution: Dùng `import:sql-fresh` để clean trước

### Memory Issues
- File SQL quá lớn
- Solution: Chia nhỏ file hoặc tăng memory_limit

### Connection Errors
- MongoDB connection failed
- Solution: Kiểm tra config database.php

## Configuration

### MongoDB Connection
```php
// config/database.php
'mongodb' => [
    'driver' => 'mongodb',
    'host' => env('DB_MONGO_HOST', '127.0.0.1'),
    'port' => env('DB_MONGO_PORT', 27017),
    'database' => env('DB_MONGO_DATABASE'),
    // ...
]
```

### Environment Variables
```env
DB_MONGO_HOST=127.0.0.1
DB_MONGO_PORT=27017
DB_MONGO_DATABASE=glx2023_for_testing
DB_MONGO_USERNAME=
DB_MONGO_PASSWORD=
```
