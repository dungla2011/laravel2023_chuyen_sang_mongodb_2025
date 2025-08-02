# MongoDB Replica Set Initializer - No Admin Required
# Chi khoi tao replica set cho MongoDB dang chay

$MONGO_PATH = "E:\Program Files\MongoDB\Server\7.0\bin"

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

function Initialize-ReplicaSet {
    Write-Info "Khoi tao Replica Set cho MongoDB dang chay..."
    
    # Check if MongoDB is running
    $service = Get-Service -Name "MongoDB" -ErrorAction SilentlyContinue
    if (-not $service -or $service.Status -ne "Running") {
        Write-Error "MongoDB service chua chay. Can khoi dong MongoDB truoc."
        exit 1
    }
    
    Write-Success "MongoDB service dang chay - bat dau khoi tao replica set..."
    
    $initCmd = @"
try {
    // Kiem tra xem replica set da duoc khoi tao chua
    try {
        var status = rs.status();
        print('[SUCCESS] Replica set da duoc khoi tao: ' + status.set);
        print('[SUCCESS] Trang thai: ' + status.myState);
        print('[SUCCESS] TRANSACTIONS DA DUOC HO TRO!');
        quit();
    } catch(statusError) {
        // Neu chua co replica set thi khoi tao
        if (statusError.message.includes('no replset config')) {
            print('[INFO] Chua co replica set - bat dau khoi tao...');
            
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
                print('[INFO] Doi 10 giay de replica set on dinh...');
                
                // Doi replica set on dinh
                sleep(10000);
                
                // Kiem tra lai trang thai
                try {
                    var finalStatus = rs.status();
                    print('[SUCCESS] Xac nhan replica set hoat dong: ' + finalStatus.set);
                    finalStatus.members.forEach(function(member) {
                        print('   - ' + member.name + ' (' + member.stateStr + ')');
                    });
                } catch(e) {
                    print('[WARNING] Replica set dang khoi tao - can them thoi gian');
                }
                
            } else {
                print('[ERROR] Loi khoi tao replica set: ' + JSON.stringify(result));
            }
        } else {
            print('[ERROR] Loi khac: ' + statusError.message);
        }
    }
} catch(e) {
    print('[ERROR] Loi tong quat: ' + e.message);
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $initCmd
    
    try {
        Write-Info "Ket noi den MongoDB va khoi tao replica set..."
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
        Write-Success "Hoan tat quy trinh khoi tao replica set"
    }
    catch {
        Write-Error "Loi khi ket noi MongoDB: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

function Check-TransactionSupport {
    Write-Info "Kiem tra ho tro transactions..."
    
    $testCmd = @"
try {
    // Test transaction
    var session = db.getMongo().startSession();
    session.startTransaction();
    
    // Thuc hien mot operation don gian trong transaction
    var testDb = session.getDatabase('test');
    testDb.transactionTest.insertOne({test: 'transaction_support', timestamp: new Date()});
    
    session.commitTransaction();
    session.endSession();
    
    print('[SUCCESS] TRANSACTIONS HOAT DONG BINH THUONG!');
    print('[SUCCESS] Laravel co the su dung MongoDB transactions');
    
} catch(e) {
    if (e.message.includes('Transaction numbers')) {
        print('[ERROR] Transactions chua duoc ho tro - replica set chua san sang');
        print('[INFO] Can khoi tao replica set truoc');
    } else {
        print('[ERROR] Loi test transaction: ' + e.message);
    }
}
"@
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".js"
    Set-Content -Path $tempFile -Value $testCmd
    
    try {
        & "$MONGO_PATH\mongo.exe" --quiet $tempFile
    }
    catch {
        Write-Error "Loi khi test transactions: $_"
    }
    finally {
        Remove-Item $tempFile -ErrorAction SilentlyContinue
    }
}

# Main execution
Write-Host @"
MONGODB REPLICA SET INITIALIZER
===============================
Chi khoi tao replica set cho MongoDB dang chay
KHONG CAN QUYEN ADMINISTRATOR
"@ -ForegroundColor Yellow

Write-Info "Kiem tra trang thai MongoDB service..."
$service = Get-Service -Name "MongoDB" -ErrorAction SilentlyContinue
if ($service) {
    Write-Host "[INFO] Service Status: $($service.Status)" -ForegroundColor Cyan
    Write-Host "[INFO] Service Start Type: $($service.StartType)" -ForegroundColor Cyan
}

if ($service -and $service.Status -eq "Running") {
    Initialize-ReplicaSet
    Write-Host ""
    Check-TransactionSupport
} else {
    Write-Error "MongoDB service khong chay. Can khoi dong MongoDB truoc khi chay script nay."
}

Write-Host "`n[SUCCESS] Script hoan tat!" -ForegroundColor Green
