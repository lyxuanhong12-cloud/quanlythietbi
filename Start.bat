@echo off
setlocal

set "ROOT=C:\xampp\htdocs\qlthietbi"
set "PORT=3000"
set "HOST=0.0.0.0"

cd /d "%ROOT%"

start "" "http://localhost:%PORT%/"
start "" "C:\xampp\php\php.exe" -S %HOST%:%PORT% -t "%ROOT%"

exit