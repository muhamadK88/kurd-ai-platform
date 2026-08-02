@echo off
cd /d %~dp0
echo ============================================
echo  Kurd AI - Ferga lesson uploader
echo ============================================
php get_firebase_token.php
if errorlevel 1 goto :fail
php add_javascript_lessons.php
php add_java_lessons.php
php add_php_lessons.php
php add_rust_lessons.php
php add_csharp_lessons.php
echo.
echo Done! Hard-refresh /ferga (Ctrl+F5) to see the lessons.
pause
exit /b 0
:fail
echo.
echo ERROR: could not get Firebase token. Check php/curl and firebase_credentials.json
pause
exit /b 1
