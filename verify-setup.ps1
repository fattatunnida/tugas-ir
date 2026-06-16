# IR Search Engine - Setup Verification Script (Windows PowerShell)
# Verifikasi bahwa semua komponen sudah terhubung dengan baik

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "IR Search Engine - Setup Verification" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Counter
$PASSED = 0
$FAILED = 0

Write-Host "========== PHP & COMPOSER CHECK ==========" -ForegroundColor Yellow
Write-Host ""

# Check PHP version
$phpCheck = php -v 2>&1
if ($phpCheck -ne $null) {
    Write-Host "PASS: PHP installed" -ForegroundColor Green
    $PASSED++
} else {
    Write-Host "FAIL: PHP installed" -ForegroundColor Red
    $FAILED++
}

# Check Composer
$composerCheck = composer --version 2>&1
if ($composerCheck -ne $null) {
    Write-Host "PASS: Composer installed" -ForegroundColor Green
    $PASSED++
} else {
    Write-Host "FAIL: Composer installed" -ForegroundColor Red
    $FAILED++
}

# Check if vendor directory exists
if (Test-Path "vendor") {
    Write-Host "PASS: Composer dependencies installed" -ForegroundColor Green
    $PASSED++
} else {
    Write-Host "WARNING: vendor directory not found" -ForegroundColor Yellow
    $FAILED++
}

Write-Host ""
Write-Host "========== ENVIRONMENT CHECK ==========" -ForegroundColor Yellow
Write-Host ""

# Check .env file
if (Test-Path ".env") {
    Write-Host "PASS: .env file exists" -ForegroundColor Green
    $PASSED++
} else {
    Write-Host "FAIL: .env file exists" -ForegroundColor Red
    $FAILED++
}

Write-Host ""
Write-Host "========== FILE STRUCTURE CHECK ==========" -ForegroundColor Yellow
Write-Host ""

# Array of files to check
$filesToCheck = @(
    @{Path="database/migrations/2025_01_01_000003_create_documents_table.php"; Name="Documents migration"},
    @{Path="app/Models/Document.php"; Name="Document model"},
    @{Path="database/seeders/DocumentSeeder.php"; Name="DocumentSeeder"},
    @{Path="app/Http/Controllers/SearchController.php"; Name="SearchController"},
    @{Path="resources/views/search.blade.php"; Name="search.blade.php view"},
    @{Path="vercel.json"; Name="vercel.json"},
    @{Path="api/index.php"; Name="api/index.php"}
)

foreach ($file in $filesToCheck) {
    if (Test-Path $file.Path) {
        Write-Host "PASS: $($file.Name) exists" -ForegroundColor Green
        $PASSED++
    } else {
        Write-Host "FAIL: $($file.Name) exists" -ForegroundColor Red
        $FAILED++
    }
}

# Check routes
$routesContent = Get-Content "routes/web.php" -Raw
if ($routesContent -match "SearchController") {
    Write-Host "PASS: SearchController registered in routes" -ForegroundColor Green
    $PASSED++
} else {
    Write-Host "FAIL: SearchController registered in routes" -ForegroundColor Red
    $FAILED++
}

Write-Host ""
Write-Host "========== DOCUMENTATION CHECK ==========" -ForegroundColor Yellow
Write-Host ""

$docsToCheck = @(
    @{Path="SETUP.md"; Name="SETUP.md"},
    @{Path="QUICKSTART.md"; Name="QUICKSTART.md"},
    @{Path="DATABASE_SETUP.md"; Name="DATABASE_SETUP.md"},
    @{Path="VERCEL_DEPLOYMENT.md"; Name="VERCEL_DEPLOYMENT.md"}
)

foreach ($doc in $docsToCheck) {
    if (Test-Path $doc.Path) {
        Write-Host "PASS: $($doc.Name) documentation exists" -ForegroundColor Green
        $PASSED++
    } else {
        Write-Host "WARNING: $($doc.Name) not found" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "========== RESULTS ==========" -ForegroundColor Yellow
Write-Host ""
Write-Host "Total Passed: $PASSED" -ForegroundColor Green
Write-Host "Total Failed: $FAILED" -ForegroundColor Red
Write-Host ""

if ($FAILED -eq 0) {
    Write-Host "SUCCESS: All critical checks passed!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Cyan
    Write-Host "1. Update .env with your database credentials"
    Write-Host "2. Run: php artisan migrate"
    Write-Host "3. Run: php artisan db:seed --class=DocumentSeeder"
    Write-Host "4. Run: php artisan serve"
} else {
    Write-Host "ERROR: Some checks failed" -ForegroundColor Red
}

