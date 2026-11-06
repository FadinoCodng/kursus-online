@echo off
title Menjalankan Website Kursus Online (EduTech)
echo ========================================================
echo   MENJALANKAN WEBSITE KURSUS ONLINE (LARAVEL + TUNNEL)
echo ========================================================
echo.

set PATH=C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64;C:\laragon\bin\composer;C:\laragon\bin\nodejs\node-v22;C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin;%PATH%

cd /d "E:\FadinoLengkap\kursus-online"

echo [1/2] Menjalankan server Laravel lokal...
start /b php artisan serve --host 0.0.0.0 --port 8000

echo [2/2] Menghubungkan Cloudflare Tunnel agar website online...
echo.
echo ========================================================
echo Tautan URL online website Anda akan muncul di bawah ini:
echo ========================================================
echo.

"C:\Program Files (x86)\cloudflared\cloudflared.exe" tunnel --url http://127.0.0.1:8000 --no-autoupdate
pause
