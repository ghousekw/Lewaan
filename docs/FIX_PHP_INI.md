# 🔧 Fix PHP Extensions Error

## Problem
You're getting these errors:
```
Unable to load dynamic library 'tokenizer'
Unable to load dynamic library 'xml'
Unable to load dynamic library 'ctype'
Unable to load dynamic library 'json'
```

## Why This Happens
In PHP 8.x, these extensions are **built-in** and don't need to be loaded separately. They're always available.

## Solution

### Step 1: Open php.ini
```bash
notepad C:\php\php.ini
```

### Step 2: Find and Remove These Lines
Search for and **DELETE or COMMENT OUT** these lines:
```ini
extension=tokenizer    ← DELETE THIS
extension=xml          ← DELETE THIS
extension=ctype        ← DELETE THIS
extension=json         ← DELETE THIS
```

### Step 3: Keep These Extensions (They're Correct)
```ini
; Core Extensions
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl

; Database
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
extension=sockets
```

### Step 4: Save and Test
```bash
# Save php.ini
# Close and reopen terminal
# Test:
php -v
```

You should see NO warnings now!

### Step 5: Verify Extensions
```bash
php -m
```

Should show all enabled extensions without errors.

## Quick Fix Script

Or copy the corrected extensions from `php.ini.fixed` file I created!

---

**After fixing, you should see:**
```
PHP 8.5.1 (cli) (built: Dec 17 2025 10:55:54) (ZTS Visual C++ 2022 x64)
```
With NO warnings!
