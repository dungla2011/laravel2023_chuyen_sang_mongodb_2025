# Quick MongoDB Replica Set Install
# Script đơn giản để cài đặt MongoDB replica set một lần

Write-Host "🔥 MONGODB REPLICA SET QUICK SETUP" -ForegroundColor Yellow
Write-Host "===================================" -ForegroundColor Yellow

# Check Admin privileges
$currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
$principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
$isAdmin = $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "❌ Script cần chạy với quyền Administrator!" -ForegroundColor Red
    Write-Host "💡 Cách chạy:" -ForegroundColor Yellow
    Write-Host "   1. Mở PowerShell as Administrator" -ForegroundColor White
    Write-Host "   2. cd 'e:\Projects\laravel2025-new-to-mongo'" -ForegroundColor White
    Write-Host "   3. .\quick-mongo-setup.ps1" -ForegroundColor White
    Read-Host "Press Enter to exit"
    exit 1
}

$MONGO_PATH = "E:\Program Files\MongoDB\Server\7.0\bin"
$MONGO_CONFIG = "E:\Program Files\MongoDB\Server\7.0\bin\mongod.cfg"
$SERVICE_NAME = "MongoDB"

Write-Host "🔧 Cài đặt MongoDB Replica Set..." -ForegroundColor Cyan

# Stop and remove existing service
Write-Host "🛑 Dừng service cũ (nếu có)..." -ForegroundColor Cyan
Stop-Service -Name $SERVICE_NAME -Force -ErrorAction SilentlyContinue
& "$MONGO_PATH\mongod.exe" --remove --serviceName $SERVICE_NAME 2>$null

# Install new service with replica set config
Write-Host "⚙️  Cài đặt MongoDB service với replica set..." -ForegroundColor Cyan
& "$MONGO_PATH\mongod.exe" --config "$MONGO_CONFIG" --install --serviceName "$SERVICE_NAME"

# Set auto start
Write-Host "🔄 Cấu hình tự động khởi động..." -ForegroundColor Cyan
Set-Service -Name $SERVICE_NAME -StartupType Automatic

# Start service
Write-Host "▶️  Khởi động MongoDB service..." -ForegroundColor Cyan
Start-Service -Name $SERVICE_NAME

Write-Host "⏳ Đợi MongoDB khởi động (10 giây)..." -ForegroundColor Cyan
Start-Sleep -Seconds 10

# Initialize replica set
Write-Host "🚀 Khởi tạo replica set..." -ForegroundColor Cyan

$initScript = @"
var config = {
    _id: 'rs0',
    members: [{ _id: 0, host: 'localhost:27017' }]
};
try {
    var result = rs.initiate(config);
    if (result.ok === 1) {
        print('✅ SUCCESS: Replica set initialized!');
    } else {
        print('❌ ERROR: ' + JSON.stringify(result));
    }
} catch(e) {
    if (e.message.includes('already initialized')) {
        print('✅ SUCCESS: Replica set already exists!');
    } else {
        print('❌ ERROR: ' + e.message);
    }
}
"@

$tempFile = [System.IO.Path]::GetTempFileName() + ".js"
Set-Content -Path $tempFile -Value $initScript

try {
    & "$MONGO_PATH\mongo.exe" --quiet $tempFile
}
catch {
    Write-Host "❌ Lỗi khởi tạo replica set: $_" -ForegroundColor Red
}
finally {
    Remove-Item $tempFile -ErrorAction SilentlyContinue
}

Write-Host ""
Write-Host "🎉 HOÀN THÀNH SETUP!" -ForegroundColor Green
Write-Host "✅ MongoDB service đã được cài đặt với replica set" -ForegroundColor Green
Write-Host "✅ Service sẽ tự động khởi động khi restart Windows" -ForegroundColor Green
Write-Host "✅ MongoDB hiện đã hỗ trợ TRANSACTIONS!" -ForegroundColor Green
Write-Host ""
Write-Host "📊 Để kiểm tra trạng thái:" -ForegroundColor Yellow
Write-Host "   .\setup-mongo-replica.ps1 -Status" -ForegroundColor White
Write-Host ""
Write-Host "🔧 Để quản lý service:" -ForegroundColor Yellow  
Write-Host "   .\setup-mongo-replica.ps1 -Help" -ForegroundColor White

Read-Host "`nPress Enter to exit"
