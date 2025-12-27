# Fix PHP 8.5 Extensions in php.ini
# This script removes built-in extensions that shouldn't be loaded

$phpIniPath = "C:\php\php.ini"

Write-Host "Fixing PHP extensions in: $phpIniPath" -ForegroundColor Yellow

# Read the file
$content = Get-Content $phpIniPath -Raw

# Remove built-in extensions that cause errors in PHP 8.x
$content = $content -replace "extension=tokenizer", ";extension=tokenizer  ; Built-in in PHP 8.x"
$content = $content -replace "extension=xml", ";extension=xml  ; Built-in in PHP 8.x"
$content = $content -replace "extension=ctype", ";extension=ctype  ; Built-in in PHP 8.x"
$content = $content -replace "extension=json", ";extension=json  ; Built-in in PHP 8.x"

# Save the file
$content | Set-Content $phpIniPath -Encoding UTF8

Write-Host "✅ Fixed! Testing PHP..." -ForegroundColor Green

# Test PHP
& C:\php\php.exe -v

Write-Host "`n✅ Done! Close and reopen your terminal." -ForegroundColor Green
