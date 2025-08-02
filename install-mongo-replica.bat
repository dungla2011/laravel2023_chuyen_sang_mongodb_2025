@echo off
echo 🔥 MONGODB REPLICA SET INSTALLER
echo =================================
echo.
echo Chuan bi cai dat MongoDB Replica Set...
echo Data se duoc giu nguyen tai: E:\Program Files\MongoDB\Server\7.0\data\
echo.
pause

powershell.exe -ExecutionPolicy Bypass -File "%~dp0quick-mongo-setup.ps1"

echo.
echo 🎯 Setup hoan tat!
pause
