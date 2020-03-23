@echo off

:loop

php D:\xampp\htdocs\website-health-checker\artisan schedule:run

timeout /T 60 /NOBREAK

goto loop