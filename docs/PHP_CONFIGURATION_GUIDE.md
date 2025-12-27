# 🔧 PHP Configuration & Extensions Guide

## 📍 Step 1: Find Your php.ini File

### If Using Laragon:
```
C:\laragon\bin\php\php-8.x.x\php.ini
```

### If Manual Installation:
```
C:\php\php.ini
```

### Find php.ini Location:
```bash
# Run this command to find php.ini location
php --ini

# Output will show:
# Configuration File (php.ini) Path: C:\php
# Loaded Configuration File: C:\php\php.ini
```

## 📝 Step 2: Create/Edit php.ini

### If php.ini doesn't exist:

**Option A: Copy from template**
```bash
# Navigate to PHP folder
cd C:\php

# Copy development template
copy php.ini-development php.ini
```

**Option B: In Laragon**
- Right-click Laragon icon
- Click "PHP" → "php.ini"
- It will open automatically

## ✅ Step 3: Enable Required Extensions for Laravel

Open `php.ini` in a text editor (Notepad, VS Code, etc.)

### Find and Uncomment These Lines:

**Search for each line and remove the `;` at the beginning:**

```ini
; Before (commented - disabled):
;extension=curl

; After (uncommented - enabled):
extension=curl
```

### Required Extensions for Laravel + Filament:

```ini
; Core Extensions (Required)
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=tokenizer
extension=xml
extension=ctype
extension=json

; Database Extensions (Choose what you need)
extension=pdo_mysql          ; For MySQL
extension=pdo_pgsql          ; For PostgreSQL
extension=pdo_sqlite         ; For SQLite
extension=mysqli             ; For MySQL (alternative)
extension=pgsql              ; For PostgreSQL (alternative)

; Image Processing (Required for Filament media)
extension=gd                 ; Image manipulation
extension=exif               ; Image metadata

; Additional Useful Extensions
extension=zip                ; For Composer and file handling
extension=intl               ; Internationalization
extension=sodium             ; Encryption (PHP 7.2+)
```

## 🎯 Quick Copy-Paste Configuration

**Add/Uncomment these lines in your php.ini:**

```ini
; ==========================================
; LARAVEL + FILAMENT REQUIRED EXTENSIONS
; ==========================================

; Core
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=tokenizer
extension=xml
extension=ctype
extension=json

; Database (uncomment what you need)
extension=pdo_mysql
extension=pdo_pgsql
extension=pdo_sqlite
extension=mysqli
extension=pgsql

; Images
extension=gd
extension=exif

; Utilities
extension=zip
extension=intl
extension=sodium
```

## ⚙️ Step 4: Additional PHP Settings

### Find and Update These Settings:

```ini
; Maximum execution time (seconds)
max_execution_time = 300

; Maximum input time (seconds)
max_input_time = 300

; Memory limit
memory_limit = 256M

; Maximum file upload size
upload_max_filesize = 64M

; Maximum POST data size
post_max_size = 64M

; Maximum number of files that can be uploaded
max_file_uploads = 20

; Timezone (set to your timezone)
date.timezone = Asia/Kuwait
; Or: date.timezone = UTC
```

## 🔍 Step 5: Verify Extensions Are Enabled

### Method 1: Command Line
```bash
# List all enabled extensions
php -m

# Check specific extension
php -m | findstr gd
php -m | findstr pdo
```

### Method 2: Create Test File
Create `test.php`:
```php
<?php
phpinfo();
?>
```

Run:
```bash
php test.php > phpinfo.txt
notepad phpinfo.txt
```

Search for your extensions in the output.

### Method 3: Laravel Check
```bash
# After creating Laravel project
php artisan about

# This will show PHP version and loaded extensions
```

## 🐛 Troubleshooting

### Extension Not Loading?

**1. Check DLL Files Exist**
```bash
# Navigate to PHP extensions folder
cd C:\php\ext

# List all DLL files
dir *.dll

# You should see files like:
# php_curl.dll
# php_gd.dll
# php_pdo_mysql.dll
# etc.
```

**2. Check extension_dir Setting**
In `php.ini`, find and set:
```ini
extension_dir = "C:\php\ext"
; Or for Laragon:
; extension_dir = "C:\laragon\bin\php\php-8.x.x\ext"
```

**3. Restart Terminal/Server**
```bash
# After changing php.ini, restart:
# - Close and reopen terminal/PowerShell
# - If running php artisan serve, stop and restart it
```

### "Unable to load dynamic library"

**Error:**
```
PHP Warning: PHP Startup: Unable to load dynamic library 'php_gd.dll'
```

**Solutions:**

1. **Check extension_dir path**
   ```ini
   ; Make sure this points to correct folder
   extension_dir = "C:\php\ext"
   ```

2. **Check DLL exists**
   ```bash
   dir C:\php\ext\php_gd.dll
   ```

3. **Install Visual C++ Redistributable**
   - Download from: https://aka.ms/vs/17/release/vc_redist.x64.exe
   - Install and restart

### "Extension not found"

If extension DLL is missing:
1. Download PHP again (make sure it's Thread Safe version)
2. Or download missing DLL from: https://windows.php.net/downloads/pecl/releases/

## 📋 Minimal Configuration for Laravel

**If you just want to get started quickly:**

```ini
; Minimum required extensions
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_sqlite
extension=zip
extension=gd

; Basic settings
memory_limit = 256M
upload_max_filesize = 32M
post_max_size = 32M
```

## ✅ Verification Checklist

After configuration, verify:

```bash
# 1. Check PHP version
php -v
# Should show: PHP 8.2+ or 8.3+

# 2. Check extensions
php -m
# Should list all enabled extensions

# 3. Check specific extensions Laravel needs
php -r "echo extension_loaded('pdo') ? 'PDO: OK' : 'PDO: MISSING'; echo PHP_EOL;"
php -r "echo extension_loaded('mbstring') ? 'mbstring: OK' : 'mbstring: MISSING'; echo PHP_EOL;"
php -r "echo extension_loaded('openssl') ? 'openssl: OK' : 'openssl: MISSING'; echo PHP_EOL;"
php -r "echo extension_loaded('curl') ? 'curl: OK' : 'curl: MISSING'; echo PHP_EOL;"
php -r "echo extension_loaded('gd') ? 'gd: OK' : 'gd: MISSING'; echo PHP_EOL;"

# 4. Test with Laravel
composer create-project laravel/laravel test-project
cd test-project
php artisan about
```

## 🎯 Quick Reference

### Common php.ini Locations:
- **Laragon**: `C:\laragon\bin\php\php-8.x.x\php.ini`
- **Manual**: `C:\php\php.ini`
- **XAMPP**: `C:\xampp\php\php.ini`
- **WAMP**: `C:\wamp64\bin\php\php8.x.x\php.ini`

### Edit php.ini:
```bash
# Find location
php --ini

# Open in notepad
notepad C:\php\php.ini

# Or in VS Code
code C:\php\php.ini
```

### Restart After Changes:
- Close and reopen terminal
- Stop and restart `php artisan serve`
- Restart Laragon (if using)

---

**Need help?** Let me know which step you're stuck on!
