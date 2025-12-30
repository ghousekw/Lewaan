# Load environment variables from .env file for Prisma commands
Get-Content .env | ForEach-Object {
    if ($_ -match '^([^=]+)=(.*)$') {
        $name = $matches[1].Trim()
        $value = $matches[2].Trim().Trim('"')
        [Environment]::SetEnvironmentVariable($name, $value, 'Process')
    }
}

Write-Host "Environment variables loaded from .env" -ForegroundColor Green
