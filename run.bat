@echo off
REM =========================================================
REM run.bat - Starts the PHP server and opens the app.
REM Double-click this file to run everything at once.
REM =========================================================

REM Close anything already using port 8080 is NOT done; just start the server
REM in the background (start command opens a new window for the server).
start "PHP Server" cmd /k "cd /d C:\Users\Dell\OneDrive\Desktop\WAD_project && php -S localhost:8080 -t task_manager"

REM Wait 2 seconds so the server has time to start before the browser opens
timeout /t 2 /nobreak >nul

REM Open the app in the default browser
start http://localhost:8080/

REM Keep this window open a moment, then close it
timeout /t 1 /nobreak >nul
