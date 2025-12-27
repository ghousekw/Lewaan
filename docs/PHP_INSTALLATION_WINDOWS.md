# 🐘 PHP & Composer Installation Guide for Windows

## 📋 What You Need to Install

1. **PHP 8.2+** - The programming language
2. **Composer** - PHP package manager (like npm for Node.js)
3. **PostgreSQL** (optional for local dev) - Database

## 🚀 Quick Installation (Recommended)

### Option A: Using Laragon (Easiest - All-in-One) ⭐⭐⭐

**Laragon includes: PHP, Composer, MySQL, PostgreSQL, Node.js, and more!**

1. **Download Laragon**
   - Go to: https://laragon.org/download/
   - Download "Laragon Full" (includes everything)
   - File size: ~200MB

2. **Install Laragon**
   - Run the installer
   - Accept default settings
   - Install to: `C:\laragon`

3. **Start Laragon**
   - Open Laragon
   - Click "Start All"
   - PHP, Composer, and database are now ready!

4. **Verify Installation**
   ```bash
   # Open Laragon Terminal (right-click Laragon icon → Terminal)
   php -v
   composer -V
   ```

**✅ Done! Skip to "Create Laravel Project" section below**

---

### Option B: Manual Installation (More Control)

#### Step 1: Install PHP

1. **Download PHP**
   - Go to: https://windows.php.nest/download/
   - Download: **PHP 8.3 (x64 Thread Safe)** ZIP file
   - Example: `php-8.3.x-Win32-vs16-x64.zip`

2. **Extract PHP**
   - Extract to: `C:\php`
   - Your folder should look like: `C:\php\php.exe`

3. **Add PHP to PATH**
   - Press `Win + X` → System
   - Click "Advanced system settings"
   - Click "Environment Variables"
   - Under "System variables", find "Path"
   - Click "Edit" → "New"
   - Add: `C:\php`
   - Click "OK" on all dialogs

4. **Configure PHP**
   ```bash
   # Copy php.ini
   cd C:\php
   copy php.ini-development php.ini
   ```

5. **Enable Extensions**
   - Open `C:\php\php.ini` in a text editor
   - Find and uncomment (remove `;`) these lines:
   ```ini
   extension=curl
   extension=fileinfo
   extension=gd
   extension=mbstring
   extension=openssl
   extension=pdo_mysql
   extension=pdo_pgsql
   extension=pgsql
   extension=zip
   ```

6. **Verify PHP**
   ```bash
   # Open new PowerShell/CMD
   php -v
   # Should show: PHP 8.3.x
   ```

#### Step 2: Install Composer

1. **Download Composer**
   - Go to: https://getcomposer.org/download/
   - Download: **Composer-Setup.exe**

2. **Run Installer**
   - Run `Composer-Setup.exe`
   - It will auto-detect PHP at `C:\php\php.exe`
   - Click "Next" → "Install"

3. **Verify Composer**
   ```bash
   # Open new PowerShell/CMD
   composer -V
   # Should show: Composer version 2.x.x
   ```

#### Step 3: Install PostgreSQL (Optional)

**For Local Development:**

1. **Download PostgreSQL**
   - Go to: https://www.postgresql.org/download/windows/
   - Download installer (latest version)

2. **Install PostgreSQL**
   - Run installer
   - Set password for postgres user (remember this!)
   - Port: 5432 (default)
   - Install pgAdmin (included)

3. **Verify PostgreSQL**
   ```bash
   psql --version
   ```

**Alternative: Use SQLite (No installation needed)**
- Laravel supports SQLite out of the box
- Perfect for local development
- No separate database server needed

---

## 🎯 Create Laravel Project

Once PHP and Composer are installed:

```bash
# Navigate to where you want to create the project
cd C:\Users\areeb\Desktop

# Create Laravel project
composer create-project laravel/laravel lewan-cms

# Navigate into project
cd lewan-cms

# Install Filament
composer require filament/filament:"^3.2" -W

# Install Filament Panel
php artisan filament:install --panels

# Start development server
php artisan serve

# Visit: http://localhost:8000
```

## ✅ Verify Everything Works

```bash
# Check PHP version
php -v
# Should show: PHP 8.2+ or 8.3+

# Check Composer
composer -V
# Should show: Composer version 2.x

# Check Laravel
php artisan --version
# Should show: Laravel Framework 11.x
```

## 🐛 Troubleshooting

### "php is not recognized"
- Restart your terminal/PowerShell
- Check PATH environment variable
- Make sure `C:\php` is in PATH

### "composer is not recognized"
- Restart your terminal/PowerShell
- Reinstall Composer
- Check if `C:\ProgramData\ComposerSetup\bin` is in PATH

### "Extension not found"
- Open `php.ini`
- Uncomment the extension (remove `;`)
- Restart terminal

### "Port 8000 already in use"
```bash
# Use different port
php artisan serve --port=8001
```

## 💡 Recommended: Laragon

**Why Laragon is better for beginners:**
- ✅ One-click installation
- ✅ Includes everything (PHP, Composer, databases)
- ✅ Easy to switch PHP versions
- ✅ Built-in terminal
- ✅ Auto-creates virtual hosts
- ✅ Lightweight and fast

**Download:** https://laragon.org/download/

## 📚 Next Steps

After installation:
1. ✅ Verify PHP and Composer work
2. ✅ Create Laravel project
3. ✅ Follow `LARAVEL_FILAMENT_SETUP.md`
4. ✅ Copy the code files I created
5. ✅ Start building your admin panel!

## ⏱️ Installation Time

- **Laragon (recommended)**: 10-15 minutes
- **Manual installation**: 20-30 minutes

---

**Need help?** Let me know which installation method you choose and I'll guide you through it!
