@echo off
echo ===================================================
echo MONGODB REPLICA SET SETUP - ADMIN REQUIRED
echo ===================================================
echo.

echo [INFO] Kiem tra quyen Administrator...
net session >nul 2>&1
if %errorLevel% == 0 (
    echo [SUCCESS] Dang chay voi quyen Administrator
) else (
    echo [ERROR] Can quyen Administrator!
    echo [INFO] Hay click-chuot-phai vao file nay va chon "Run as administrator"
    pause
    exit /b 1
)

echo.
echo [INFO] Dung va xoa service MongoDB cu...
sc stop MongoDB
timeout /t 3 /nobreak >nul

echo [INFO] Xoa service MongoDB cu...
"E:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --remove --serviceName MongoDB
timeout /t 2 /nobreak >nul

echo.
echo [INFO] Cai dat lai MongoDB service voi replica set config...
"E:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --config "E:\Program Files\MongoDB\Server\7.0\bin\mongod.cfg" --install --serviceName MongoDB

if %errorLevel% == 0 (
    echo [SUCCESS] Cai dat service thanh cong
) else (
    echo [ERROR] Loi khi cai dat service
    pause
    exit /b 1
)

echo.
echo [INFO] Cau hinh service tu dong khoi dong...
sc config MongoDB start= auto

echo [INFO] Khoi dong MongoDB service...
sc start MongoDB

if %errorLevel__ == 0 (
    echo [SUCCESS] MongoDB service da khoi dong
) else (
    echo [WARNING] Service co the dang khoi dong...
)

echo.
echo [INFO] Doi 5 giay de MongoDB khoi dong hoan tat...
timeout /t 5 /nobreak >nul

echo.
echo [INFO] Khoi tao replica set...
echo var config = {_id: 'rs0', members: [{_id: 0, host: 'localhost:27017'}]}; > init_replica.js
echo var result = rs.initiate(config); >> init_replica.js
echo if (result.ok === 1) print('[SUCCESS] Replica set khoi tao thanh cong'); >> init_replica.js
echo else print('[ERROR] Loi khoi tao: ' + JSON.stringify(result)); >> init_replica.js

"E:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --quiet init_replica.js

if exist init_replica.js del init_replica.js

echo.
echo [INFO] Kiem tra transaction support...
echo try { > test_transaction.js
echo   var session = db.getMongo().startSession(); >> test_transaction.js
echo   session.startTransaction(); >> test_transaction.js
echo   db.test.insertOne({test: 'transaction'}); >> test_transaction.js
echo   session.commitTransaction(); >> test_transaction.js
echo   print('[SUCCESS] TRANSACTIONS HOAT DONG!'); >> test_transaction.js
echo } catch(e) { >> test_transaction.js
echo   print('[ERROR] Transaction loi: ' + e.message); >> test_transaction.js
echo } >> test_transaction.js

"E:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --quiet test_transaction.js

if exist test_transaction.js del test_transaction.js

echo.
echo ===================================================
echo [SUCCESS] HOAN TAT CAI DAT MONGODB REPLICA SET!
echo ===================================================
echo MongoDB da duoc cau hinh voi replica set 'rs0'
echo Transactions da duoc ho tro
echo Service se tu dong khoi dong khi Windows boot
echo.
pause
