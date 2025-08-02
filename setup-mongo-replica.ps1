# MongoDB Replica Set Setup Script for Windows
# Tự động cấu hình MongoDB replica set để hỗ trợ transactions

param(
    [switch]$Install,
    [switch]$Start,
    [switch]$Stop,
    [switch]$Status,
    [switch]$InitReplica,
    [switch]$Help
)

$MONGO_PATH = "E:\Program Files\MongoDB\Server\7.0\bin"
$MONGO_CONFIG = "E:\Program Files\MongoDB\Server\7.0\bin\mongod.cfg"
$MONGO_DATA = "E:\Program Files\MongoDB\Server\7.0\data"
$SERVICE_NAME = "MongoDB"

function Write-Info {
    param($Message)
    Write-Host "🔧 $Message" -ForegroundColor Cyan
}

function Write-Success {
    param($Message)
    Write-Host "✅ $Message" -ForegroundColor Green
}

function Write-Error {
    param($Message)
    Write-Host "❌ $Message" -ForegroundColor Red
}

function Write-Warning {
    param($Message)
    Write-Host "⚠️  $Message" -ForegroundColor Yellow
}

function Test-AdminPrivileges {
    $currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

function Show-Help {
    Write-Host @"
🔧 MongoDB Replica Set Setup Script

USAGE:
    .\setup-mongo-replica.ps1 [OPTIONS]

OPTIONS:
    -Install      Cài đặt và cấu hình MongoDB service với replica set
    -Start        Khởi động MongoDB service
    -Stop         Dừng MongoDB service  
    -Status       Kiểm tra trạng thái MongoDB service và replica set
    -InitReplica  Khởi tạo replica set (chỉ chạy sau khi service đã start)
    -Help         Hiển thị help này

EXAMPLES:
    # Cài đặt hoàn chỉnh
    .\setup-mongo-replica.ps1 -Install

    # Khởi động service
    .\setup-mongo-replica.ps1 -Start
    
    # Kiểm tra trạng thái
    .\setup-mongo-replica.ps1 -Status

"@ -ForegroundColor Yellow
}

function Install-MongoService {
    Write-Info "Cài đặt MongoDB Service với Replica Set..."
    
    # Check if running as admin
    if (-not (Test-AdminPrivileges)) {
        Write-Error "Script cần chạy với quyền Administrator!"
        Write-Info "Hãy mở PowerShell as Administrator và chạy lại script"
        exit 1
    }
    
    # Stop existing service if running
    $existingService = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($existingService) {
        Write-Info "Dừng MongoDB service hiện tại..."
        Stop-Service -Name $SERVICE_NAME -Force -ErrorAction SilentlyContinue
        
        Write-Info "Xóa MongoDB service cũ..."
        & "$MONGO_PATH\mongod.exe" --remove --serviceName $SERVICE_NAME
        Start-Sleep -Seconds 3
    }
    
    # Verify config file exists and has replica set config
    if (-not (Test-Path $MONGO_CONFIG)) {
        Write-Error "Không tìm thấy file config: $MONGO_CONFIG"
        exit 1
    }
    
    $configContent = Get-Content $MONGO_CONFIG -Raw
    if ($configContent -notmatch "replSetName") {
        Write-Warning "File config chưa có cấu hình replica set"
        Write-Info "Cần thêm vào mongod.cfg:"
        Write-Host @"
replication:
  replSetName: "rs0"
"@ -ForegroundColor Yellow
        exit 1
    }
    
    Write-Success "File config đã có cấu hình replica set"
    
    # Create data directory if not exists
    if (-not (Test-Path $MONGO_DATA)) {
        Write-Info "Tạo thư mục data: $MONGO_DATA"
        New-Item -ItemType Directory -Path $MONGO_DATA -Force | Out-Null
    }
    
    # Install MongoDB as Windows Service
    Write-Info "Cài đặt MongoDB service với config replica set..."
    $installCmd = "& `"$MONGO_PATH\mongod.exe`" --config `"$MONGO_CONFIG`" --install --serviceName `"$SERVICE_NAME`""
    
    try {
        Invoke-Expression $installCmd
        Write-Success "Đã cài đặt MongoDB service thành công"
    }
    catch {
        Write-Error "Lỗi khi cài đặt service: $_"
        exit 1
    }
    
    # Set service to start automatically
    Write-Info "Cấu hình service tự động khởi động..."
    Set-Service -Name $SERVICE_NAME -StartupType Automatic
    
    # Start the service
    Write-Info "Khởi động MongoDB service..."
    Start-Service -Name $SERVICE_NAME
    
    Write-Success "MongoDB service đã được cài đặt và khởi động"
    Write-Info "Đợi 5 giây để MongoDB khởi động hoàn tất..."
    Start-Sleep -Seconds 5
    
    # Initialize replica set
    Initialize-ReplicaSet
}

function Start-MongoService {
    Write-Info "Khởi động MongoDB service..."
    
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if (-not $service) {
        Write-Error "MongoDB service chưa được cài đặt. Chạy với -Install trước"
        exit 1
    }
    
    if ($service.Status -eq "Running") {
        Write-Success "MongoDB service đã đang chạy"
    }
    else {
        Start-Service -Name $SERVICE_NAME
        Write-Success "Đã khởi động MongoDB service"
    }
}

function Stop-MongoService {
    Write-Info "Dừng MongoDB service..."
    
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($service -and $service.Status -eq "Running") {
        Stop-Service -Name $SERVICE_NAME -Force
        Write-Success "Đã dừng MongoDB service"
    }
    else {
        Write-Info "MongoDB service không đang chạy"
    }
}

function Get-MongoStatus {
    Write-Info "Kiểm tra trạng thái MongoDB..."
    
    # Check Windows Service
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($service) {
        Write-Host "🔧 Service Status: $($service.Status)" -ForegroundColor Cyan
        Write-Host "🔧 Service Start Type: $($service.StartType)" -ForegroundColor Cyan
    }
    else {
        Write-Warning "MongoDB service chưa được cài đặt"
        return
    }
    
    if ($service.Status -ne "Running") {
        Write-Warning "MongoDB service không đang chạy"
        return
    }
    
    # Check MongoDB connection and replica set status
    Write-Info "Kiểm tra kết nối MongoDB và replica set..."
    
    $mongoCmd = @"
try {
    var status = rs.status();
    print('✅ Replica Set Name: ' + status.set);
    print('✅ Replica Set State: ' + status.myState);
    print('✅ Members: ' + status.members.length);
    status.members.forEach(function(member) {
        print('   - ' + member.name + ' (' + member.stateStr + ')');
    });
    print('🎉 TRANSACTIONS SUPPORTED!');
} catch(e) {
    if (e.message.includes('no replset config')) {
        print('⚠️  Replica set chưa được khởi tạo');
        print('💡 Chạy: .\setup-mongo-replica.ps1 -InitReplica');
    } else {
        print('❌ Error: ' + e.message);
    }
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $mongoCmd
    
    try {
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
    }
    catch {
        Write-Error "Không thể kết nối đến MongoDB: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

function Initialize-ReplicaSet {
    Write-Info "Khởi tạo Replica Set..."
    
    # Check if service is running
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if (-not $service -or $service.Status -ne "Running") {
        Write-Error "MongoDB service chưa chạy. Khởi động service trước."
        exit 1
    }
    
    $initCmd = @"
try {
    var config = {
        _id: 'rs0',
        members: [
            { _id: 0, host: 'localhost:27017' }
        ]
    };
    var result = rs.initiate(config);
    if (result.ok === 1) {
        print('✅ Replica set đã được khởi tạo thành công!');
        print('🎉 MongoDB hiện đã hỗ trợ transactions!');
    } else {
        print('❌ Lỗi khởi tạo replica set: ' + JSON.stringify(result));
    }
} catch(e) {
    if (e.message.includes('already initialized')) {
        print('✅ Replica set đã được khởi tạo trước đó');
        print('🎉 MongoDB đã hỗ trợ transactions!');
    } else {
        print('❌ Error: ' + e.message);
    }
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $initCmd
    
    Write-Info "Đợi MongoDB sẵn sàng..."
    Start-Sleep -Seconds 3
    
    try {
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
        Write-Success "Hoàn tất khởi tạo replica set"
    }
    catch {
        Write-Error "Lỗi khi khởi tạo replica set: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

# Main execution
Write-Host @"
🔥 MONGODB REPLICA SET SETUP FOR WINDOWS
========================================
"@ -ForegroundColor Yellow

if ($Help) {
    Show-Help
    exit 0
}

if ($Install) {
    Install-MongoService
}
elseif ($Start) {
    Start-MongoService
}
elseif ($Stop) {
    Stop-MongoService
}
elseif ($Status) {
    Get-MongoStatus
}
elseif ($InitReplica) {
    Initialize-ReplicaSet
}
else {
    Write-Warning "Không có tham số nào được chỉ định"
    Show-Help
}

Write-Host "`n🎯 Script hoàn tất!" -ForegroundColor Green
