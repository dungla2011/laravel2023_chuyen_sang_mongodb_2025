# MongoDB Replica Set Setup Script for Windows
# Tu dong cau hinh MongoDB replica set de ho tro transactions

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
    Write-Host "[INFO] $Message" -ForegroundColor Cyan
}

function Write-Success {
    param($Message)
    Write-Host "[SUCCESS] $Message" -ForegroundColor Green
}

function Write-Error {
    param($Message)
    Write-Host "[ERROR] $Message" -ForegroundColor Red
}

function Write-Warning {
    param($Message)
    Write-Host "[WARNING] $Message" -ForegroundColor Yellow
}

function Test-AdminPrivileges {
    $currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

function Show-Help {
    Write-Host @"
MongoDB Replica Set Setup Script

USAGE:
    .\setup-mongo-replica-simple.ps1 [OPTIONS]

OPTIONS:
    -Install      Cai dat va cau hinh MongoDB service voi replica set
    -Start        Khoi dong MongoDB service
    -Stop         Dung MongoDB service  
    -Status       Kiem tra trang thai MongoDB service va replica set
    -InitReplica  Khoi tao replica set (chi chay sau khi service da start)
    -Help         Hien thi help nay

EXAMPLES:
    # Cai dat hoan chinh
    .\setup-mongo-replica-simple.ps1 -Install

    # Khoi dong service
    .\setup-mongo-replica-simple.ps1 -Start
    
    # Kiem tra trang thai
    .\setup-mongo-replica-simple.ps1 -Status

"@ -ForegroundColor Yellow
}

function Install-MongoService {
    Write-Info "Cai dat MongoDB Service voi Replica Set..."
    
    # Check if running as admin
    if (-not (Test-AdminPrivileges)) {
        Write-Error "Script can chay voi quyen Administrator!"
        Write-Info "Hay mo PowerShell as Administrator va chay lai script"
        exit 1
    }
    
    # Stop existing service if running
    $existingService = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($existingService) {
        Write-Info "Dung MongoDB service hien tai..."
        Stop-Service -Name $SERVICE_NAME -Force -ErrorAction SilentlyContinue
        
        Write-Info "Xoa MongoDB service cu..."
        & "$MONGO_PATH\mongod.exe" --remove --serviceName $SERVICE_NAME
        Start-Sleep -Seconds 3
    }
    
    # Verify config file exists and has replica set config
    if (-not (Test-Path $MONGO_CONFIG)) {
        Write-Error "Khong tim thay file config: $MONGO_CONFIG"
        exit 1
    }
    
    $configContent = Get-Content $MONGO_CONFIG -Raw
    if ($configContent -notmatch "replSetName") {
        Write-Warning "File config chua co cau hinh replica set"
        Write-Info "Can them vao mongod.cfg:"
        Write-Host @"
replication:
  replSetName: "rs0"
"@ -ForegroundColor Yellow
        exit 1
    }
    
    Write-Success "File config da co cau hinh replica set"
    
    # Create data directory if not exists
    if (-not (Test-Path $MONGO_DATA)) {
        Write-Info "Tao thu muc data: $MONGO_DATA"
        New-Item -ItemType Directory -Path $MONGO_DATA -Force | Out-Null
    }
    
    # Install MongoDB as Windows Service
    Write-Info "Cai dat MongoDB service voi config replica set..."
    $installCmd = "& `"$MONGO_PATH\mongod.exe`" --config `"$MONGO_CONFIG`" --install --serviceName `"$SERVICE_NAME`""
    
    try {
        Invoke-Expression $installCmd
        Write-Success "Da cai dat MongoDB service thanh cong"
    }
    catch {
        Write-Error "Loi khi cai dat service: $_"
        exit 1
    }
    
    # Set service to start automatically
    Write-Info "Cau hinh service tu dong khoi dong..."
    Set-Service -Name $SERVICE_NAME -StartupType Automatic
    
    # Start the service
    Write-Info "Khoi dong MongoDB service..."
    Start-Service -Name $SERVICE_NAME
    
    Write-Success "MongoDB service da duoc cai dat va khoi dong"
    Write-Info "Doi 5 giay de MongoDB khoi dong hoan tat..."
    Start-Sleep -Seconds 5
    
    # Initialize replica set
    Initialize-ReplicaSet
}

function Start-MongoService {
    Write-Info "Khoi dong MongoDB service..."
    
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if (-not $service) {
        Write-Error "MongoDB service chua duoc cai dat. Chay voi -Install truoc"
        exit 1
    }
    
    if ($service.Status -eq "Running") {
        Write-Success "MongoDB service da dang chay"
    }
    else {
        Start-Service -Name $SERVICE_NAME
        Write-Success "Da khoi dong MongoDB service"
    }
}

function Stop-MongoService {
    Write-Info "Dung MongoDB service..."
    
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($service -and $service.Status -eq "Running") {
        Stop-Service -Name $SERVICE_NAME -Force
        Write-Success "Da dung MongoDB service"
    }
    else {
        Write-Info "MongoDB service khong dang chay"
    }
}

function Get-MongoStatus {
    Write-Info "Kiem tra trang thai MongoDB..."
    
    # Check Windows Service
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if ($service) {
        Write-Host "[INFO] Service Status: $($service.Status)" -ForegroundColor Cyan
        Write-Host "[INFO] Service Start Type: $($service.StartType)" -ForegroundColor Cyan
    }
    else {
        Write-Warning "MongoDB service chua duoc cai dat"
        return
    }
    
    if ($service.Status -ne "Running") {
        Write-Warning "MongoDB service khong dang chay"
        return
    }
    
    # Check MongoDB connection and replica set status
    Write-Info "Kiem tra ket noi MongoDB va replica set..."
    
    $mongoCmd = @"
try {
    var status = rs.status();
    print('[SUCCESS] Replica Set Name: ' + status.set);
    print('[SUCCESS] Replica Set State: ' + status.myState);
    print('[SUCCESS] Members: ' + status.members.length);
    status.members.forEach(function(member) {
        print('   - ' + member.name + ' (' + member.stateStr + ')');
    });
    print('[SUCCESS] TRANSACTIONS SUPPORTED!');
} catch(e) {
    if (e.message.includes('no replset config')) {
        print('[WARNING] Replica set chua duoc khoi tao');
        print('[INFO] Chay: .\setup-mongo-replica-simple.ps1 -InitReplica');
    } else {
        print('[ERROR] Error: ' + e.message);
    }
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $mongoCmd
    
    try {
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
    }
    catch {
        Write-Error "Khong the ket noi den MongoDB: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

function Initialize-ReplicaSet {
    Write-Info "Khoi tao Replica Set..."
    
    # Check if service is running
    $service = Get-Service -Name $SERVICE_NAME -ErrorAction SilentlyContinue
    if (-not $service -or $service.Status -ne "Running") {
        Write-Error "MongoDB service chua chay. Khoi dong service truoc."
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
        print('[SUCCESS] Replica set da duoc khoi tao thanh cong!');
        print('[SUCCESS] MongoDB hien da ho tro transactions!');
    } else {
        print('[ERROR] Loi khoi tao replica set: ' + JSON.stringify(result));
    }
} catch(e) {
    if (e.message.includes('already initialized')) {
        print('[SUCCESS] Replica set da duoc khoi tao truoc do');
        print('[SUCCESS] MongoDB da ho tro transactions!');
    } else {
        print('[ERROR] Error: ' + e.message);
    }
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $initCmd
    
    Write-Info "Doi MongoDB san sang..."
    Start-Sleep -Seconds 3
    
    try {
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
        Write-Success "Hoan tat khoi tao replica set"
    }
    catch {
        Write-Error "Loi khi khoi tao replica set: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

# Main execution
Write-Host @"
MONGODB REPLICA SET SETUP FOR WINDOWS
======================================
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
    Write-Warning "Khong co tham so nao duoc chi dinh"
    Show-Help
}

Write-Host "`n[SUCCESS] Script hoan tat!" -ForegroundColor Green
