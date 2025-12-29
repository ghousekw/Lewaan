# PowerShell script to force a fresh Railway build without cache

Write-Host "🔄 Forcing fresh Railway build..." -ForegroundColor Cyan
Write-Host ""

# Update CACHE_BUST in Dockerfile
$dockerfileContent = Get-Content "Dockerfile" -Raw
$cacheBustMatch = [regex]::Match($dockerfileContent, 'ARG CACHE_BUST=(\d+)')
$currentValue = if ($cacheBustMatch.Success) { [int]$cacheBustMatch.Groups[1].Value } else { 1 }
$newValue = $currentValue + 1

Write-Host "📝 Updating CACHE_BUST from $currentValue to $newValue" -ForegroundColor Yellow

# Update CACHE_BUST
$dockerfileContent = $dockerfileContent -replace 'ARG CACHE_BUST=\d+', "ARG CACHE_BUST=$newValue"

# Update BUILD_DATE with timestamp
$timestamp = (Get-Date -Format "yyyy-MM-ddTHH:mm:ssZ")
$dockerfileContent = $dockerfileContent -replace 'ARG BUILD_DATE=[^\n]+', "ARG BUILD_DATE=$timestamp"

# Write back to file
Set-Content -Path "Dockerfile" -Value $dockerfileContent -NoNewline

Write-Host "✅ Dockerfile updated" -ForegroundColor Green
Write-Host ""

# Check if git is available and in a git repo
if (Get-Command git -ErrorAction SilentlyContinue) {
    $gitStatus = git status --porcelain 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "📤 Committing and pushing changes..." -ForegroundColor Yellow
        git add Dockerfile
        git commit -m "Force rebuild: cache-bust to $newValue ($timestamp)"
        git push
        
        Write-Host ""
        Write-Host "✅ Changes pushed! Railway will now build fresh without cache." -ForegroundColor Green
    } else {
        Write-Host "⚠️  Not in a git repository. Dockerfile updated but not committed." -ForegroundColor Yellow
    }
} else {
    Write-Host "⚠️  Git not found. Dockerfile updated but not committed." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "📊 Monitor the build:" -ForegroundColor Cyan
Write-Host "   railway logs --deployment"
Write-Host ""
Write-Host "🔍 Verify extensions after build:" -ForegroundColor Cyan
Write-Host "   railway run php -m | grep pgsql"

