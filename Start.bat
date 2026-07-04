@echo off
setlocal

set "ROOT=%~dp0"
for %%I in ("%ROOT%..") do set "PARENT1=%%~fI"
for %%I in ("%PARENT1%..") do set "XAMPP_ROOT=%%~fI"

set "PORT=3000"
set "HOST=0.0.0.0"
set "SERVER_IP=localhost"
set "PHP_EXE=%XAMPP_ROOT%\php\php.exe"
set "MYSQL_EXE=%XAMPP_ROOT%\mysql\bin\mysqld.exe"
set "MYSQL_CLIENT=%XAMPP_ROOT%\mysql\bin\mysql.exe"
set "MYSQL_INI=%XAMPP_ROOT%\mysql\bin\my.ini"

if exist "%ROOT%server_ip.txt" (
    set /p SERVER_IP=<"%ROOT%server_ip.txt"
)

if not defined SERVER_IP set "SERVER_IP=localhost"

if not exist "%PHP_EXE%" (
    echo Khong tim thay PHP trong XAMPP.
    exit /b 1
)

if not exist "%MYSQL_EXE%" (
    echo Khong tim thay MySQL trong XAMPP.
    exit /b 1
)

cd /d "%ROOT%"

start "" "http://%SERVER_IP%:%PORT%/"

start "" "%MYSQL_EXE%" --defaults-file="%MYSQL_INI%" --standalone --console

timeout /t 5 /nobreak >nul

"%MYSQL_CLIENT%" --user=root --password="" -e "CREATE DATABASE IF NOT EXISTS ql_thietbi;" 2>nul
"%PHP_EXE%" "%ROOT%init_auth.php" 2>nul

start "" "%PHP_EXE%" -S %HOST%:%PORT% -t "%ROOT%"

exit