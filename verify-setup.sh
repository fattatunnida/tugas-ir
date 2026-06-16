#!/bin/bash

# IR Search Engine - Setup Verification Script
# Verifikasi bahwa semua komponen sudah terhubung dengan baik

echo "=========================================="
echo "IR Search Engine - Setup Verification"
echo "=========================================="
echo ""

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counter
PASSED=0
FAILED=0

# Function to check status
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ PASS${NC}: $1"
        ((PASSED++))
    else
        echo -e "${RED}✗ FAIL${NC}: $1"
        ((FAILED++))
    fi
}

echo "========== PHP & COMPOSER CHECK =========="
echo ""

# Check PHP version
php -v | head -n1 > /dev/null 2>&1
check_status "PHP installed"

# Check Composer
composer --version > /dev/null 2>&1
check_status "Composer installed"

# Check if vendor directory exists
if [ -d "vendor" ]; then
    check_status "Composer dependencies installed"
else
    echo -e "${YELLOW}⚠ WARN${NC}: vendor directory not found. Run 'composer install'"
    ((FAILED++))
fi

echo ""
echo "========== ENVIRONMENT CHECK =========="
echo ""

# Check .env file
if [ -f ".env" ]; then
    check_status ".env file exists"
    
    # Check APP_KEY
    grep -q "^APP_KEY=" .env
    check_status "APP_KEY set in .env"
    
    # Check DB_CONNECTION
    grep -q "^DB_CONNECTION=" .env
    check_status "DB_CONNECTION set in .env"
else
    echo -e "${RED}✗ FAIL${NC}: .env file not found"
    ((FAILED++))
fi

echo ""
echo "========== FILE STRUCTURE CHECK =========="
echo ""

# Check migrations
if [ -f "database/migrations/2025_01_01_000003_create_documents_table.php" ]; then
    check_status "Documents migration exists"
else
    echo -e "${RED}✗ FAIL${NC}: Documents migration not found"
    ((FAILED++))
fi

# Check model
if [ -f "app/Models/Document.php" ]; then
    check_status "Document model exists"
else
    echo -e "${RED}✗ FAIL${NC}: Document model not found"
    ((FAILED++))
fi

# Check seeder
if [ -f "database/seeders/DocumentSeeder.php" ]; then
    check_status "DocumentSeeder exists"
else
    echo -e "${RED}✗ FAIL${NC}: DocumentSeeder not found"
    ((FAILED++))
fi

# Check controller
if [ -f "app/Http/Controllers/SearchController.php" ]; then
    check_status "SearchController exists"
else
    echo -e "${RED}✗ FAIL${NC}: SearchController not found"
    ((FAILED++))
fi

# Check routes
if grep -q "SearchController" routes/web.php; then
    check_status "SearchController registered in routes"
else
    echo -e "${RED}✗ FAIL${NC}: SearchController not registered in routes"
    ((FAILED++))
fi

# Check view
if [ -f "resources/views/search.blade.php" ]; then
    check_status "search.blade.php view exists"
else
    echo -e "${RED}✗ FAIL${NC}: search.blade.php view not found"
    ((FAILED++))
fi

# Check Vercel config
if [ -f "vercel.json" ]; then
    check_status "vercel.json exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: vercel.json not found (needed for Vercel deployment)"
    ((FAILED++))
fi

# Check API index
if [ -f "api/index.php" ]; then
    check_status "api/index.php exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: api/index.php not found (needed for Vercel deployment)"
    ((FAILED++))
fi

echo ""
echo "========== LARAVEL COMMAND CHECK =========="
echo ""

# Check if Laravel can generate commands
php artisan --version > /dev/null 2>&1
check_status "Laravel artisan commands available"

# Try to list routes (doesn't require DB connection)
php artisan route:list > /dev/null 2>&1
check_status "Laravel routes can be listed"

echo ""
echo "========== DOCUMENTATION CHECK =========="
echo ""

# Check documentation files
if [ -f "SETUP.md" ]; then
    check_status "SETUP.md documentation exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: SETUP.md not found"
fi

if [ -f "QUICKSTART.md" ]; then
    check_status "QUICKSTART.md documentation exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: QUICKSTART.md not found"
fi

if [ -f "DATABASE_SETUP.md" ]; then
    check_status "DATABASE_SETUP.md documentation exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: DATABASE_SETUP.md not found"
fi

if [ -f "VERCEL_DEPLOYMENT.md" ]; then
    check_status "VERCEL_DEPLOYMENT.md documentation exists"
else
    echo -e "${YELLOW}⚠ WARN${NC}: VERCEL_DEPLOYMENT.md not found"
fi

echo ""
echo "========== RESULTS =========="
echo ""
echo -e "Total Checks: $((PASSED + FAILED))"
echo -e "${GREEN}Passed: $PASSED${NC}"

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}Failed: $FAILED${NC}"
    echo ""
    echo -e "${GREEN}✓ All checks passed! Your project is ready.${NC}"
    echo ""
    echo "Next steps:"
    echo "1. Update .env with your database credentials"
    echo "2. Run: php artisan migrate"
    echo "3. Run: php artisan db:seed --class=DocumentSeeder"
    echo "4. Run: php artisan serve"
    exit 0
else
    echo -e "${RED}Failed: $FAILED${NC}"
    echo ""
    echo -e "${RED}✗ Some checks failed. Please fix the issues above.${NC}"
    exit 1
fi
