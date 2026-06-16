# 🚀 Vercel Deployment Guide

Panduan lengkap untuk deploy IR Search Engine ke Vercel dengan Supabase PostgreSQL.

## 📋 Prerequisites

- ✅ GitHub account (untuk host repository)
- ✅ Vercel account (free: https://vercel.com)
- ✅ Supabase account (free: https://supabase.com)
- ✅ Project sudah siap di GitHub

---

## 🌐 Step 1: Setup Supabase Database

### 1.1 Buat Project Supabase

1. Kunjungi https://supabase.com
2. Login dengan GitHub
3. Klik "New Project"
4. Pilih organization & input project name: `ir-search`
5. Setup database password (ingat dengan baik!)
6. Pilih region terdekat
7. Klik "Create new project" & tunggu 1-2 menit

### 1.2 Dapatkan Connection String

1. Masuk ke Project Dashboard
2. Navigasi ke **Settings → Database**
3. Copy connection details:
   - **Host**: `xxx.supabase.co`
   - **Port**: `5432`
   - **Database**: `postgres`
   - **User**: `postgres`
   - **Password**: `[your-password]`

### 1.3 Verify Connection

```bash
# Test koneksi dari lokal (optional)
psql -h xxx.supabase.co -U postgres -d postgres

# Password: [your-password]
```

---

## 🔧 Step 2: Persiapkan Project untuk Vercel

### 2.1 Update Environment Files

**File `.env.production`** sudah ada, verifikasi:

```env
APP_NAME="IR Search Engine"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app

DB_CONNECTION=pgsql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=cookie
CACHE_STORE=array
QUEUE_CONNECTION=sync
```

### 2.2 Verifikasi vercel.json

File sudah ada dengan konfigurasi:
```json
{
  "version": 2,
  "framework": "laravel",
  "functions": {
    "api/index.php": {
      "runtime": "php:8.2",
      "memory": 3008,
      "maxDuration": 30
    }
  }
}
```

### 2.3 Verifikasi api/index.php

Entry point untuk Vercel serverless sudah ada.

### 2.4 Update .gitignore

Pastikan `.env` files tidak di-commit (sudah ada di .gitignore):
```
.env
.env.backup
.env.production
```

---

## 📤 Step 3: Push ke GitHub

### 3.1 Initialize Git (jika belum)

```bash
# Masuk folder project
cd tugas-ir-search

# Initialize git
git init

# Add semua files
git add .

# Commit
git commit -m "Initial commit: IR Search Engine ready for Vercel"
```

### 3.2 Push ke GitHub

```bash
# Add remote repository
git remote add origin https://github.com/YOUR_USERNAME/tugas-ir-search.git

# Push ke main branch
git branch -M main
git push -u origin main
```

---

## 🚀 Step 4: Deploy ke Vercel

### 4.1 Connect ke Vercel

1. Kunjungi https://vercel.com/dashboard
2. Klik "Add New..." → "Project"
3. Klik "Import Git Repository"
4. Search & select `tugas-ir-search` repository
5. Klik "Import"

### 4.2 Configure Project

**Framework**: Sudah terdeteksi sebagai Laravel ✅

**Environment Variables**: Set di sini:

| Variable | Value |
|----------|-------|
| `APP_KEY` | `base64:xxxxx` (dari `php artisan key:generate`) |
| `APP_NAME` | `IR Search Engine` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://your-domain.vercel.app` (update saat setelah deploy) |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `xxx.supabase.co` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `postgres` |
| `DB_USERNAME` | `postgres` |
| `DB_PASSWORD` | `[your-supabase-password]` |
| `DB_SSLMODE` | `require` |
| `CACHE_STORE` | `array` |
| `SESSION_DRIVER` | `cookie` |
| `QUEUE_CONNECTION` | `sync` |

### 4.3 Konfigurasi Advanced (Optional)

**Build Command**: Sudah set otomatis
```
composer install --prefer-dist --optimize-autoloader && php artisan config:cache
```

**Output Directory**: `/public`

**Install Command**: 
```
composer install --prefer-dist --optimize-autoloader --no-interaction --no-dev
```

### 4.4 Deploy!

1. Klik "Deploy"
2. Tunggu proses build (3-5 menit)
3. Lihat deployment logs jika ada error
4. Selesai! ✅

---

## 🔄 Step 5: Post-Deployment Setup

### 5.1 Jalankan Migrations

**Option A: Via CLI (Recommended)**

```bash
# Install Vercel CLI
npm install -g vercel

# Link project
vercel link

# Run migration di production
vercel env pull
php artisan migrate --force
php artisan db:seed --class=DocumentSeeder --force
```

**Option B: Via SSH (Jika Available)**

```bash
# SSH ke Vercel environment
# Jalankan commands
php artisan migrate --force
php artisan db:seed --class=DocumentSeeder --force
```

**Option C: Manual via Supabase**

```bash
# Connect langsung ke Supabase
psql -h xxx.supabase.co -U postgres -d postgres

# Buat schema & data (import dari local backup)
# Atau jalankan migration SQL manual
```

### 5.2 Verifikasi Deployment

1. Buka https://your-project.vercel.app
2. Test search dengan keyword: `Python`, `Laravel`, dll
3. Pastikan:
   - ✅ Search form berfungsi
   - ✅ Database connected
   - ✅ Results ditampilkan
   - ✅ Highlight berfungsi
   - ✅ Retrieval time visible

### 5.3 Update APP_URL

1. Kembali ke Vercel Settings
2. Navigasi ke Environment Variables
3. Update `APP_URL` dengan domain Vercel yang sudah jadi:
   ```
   https://tugas-ir-search.vercel.app
   ```

---

## 🔗 Domain Custom (Optional)

### 5.1 Beli Domain

Pilih registrar favorit:
- Namecheap
- GoDaddy
- Domain.com
- Etc.

### 5.2 Connect ke Vercel

1. Di Vercel Project Settings → Domains
2. Klik "Add Domain"
3. Input custom domain: `yourdomain.com`
4. Ikuti instruksi untuk update DNS records
5. Tunggu propagasi (5-30 menit)

---

## 🔐 Security Checklist

- ✅ `APP_DEBUG=false` di production
- ✅ Strong database password
- ✅ Semua env vars sudah set di Vercel
- ✅ HTTPS enabled (Vercel default)
- ✅ No sensitive data di GitHub
- ✅ Regular database backups

---

## 🆘 Troubleshooting Deployment

### Error: "Class not found"

**Solusi:**
```bash
# Re-run composer install
php artisan clear-compiled
composer install --no-dev --optimize-autoloader
```

### Error: "SQLSTATE[08006] could not connect"

**Solusi:**
1. Verify DB_HOST, DB_PORT di Vercel env vars
2. Check Supabase database sudah berjalan
3. Verify database credentials benar
4. Check firewall rules di Supabase

### Error: "No tables found"

**Solusi:**
```bash
# Run migration di Vercel
vercel env pull
php artisan migrate --force
php artisan db:seed --force
```

### Build Timeout

**Solusi:**
1. Optimasi composer: `composer install --no-dev`
2. Remove unused dependencies
3. Check file size di project
4. Increase timeout di vercel.json

### Memory Exceeded

**Solusi:**
Di `vercel.json`, increase memory:
```json
"functions": {
  "api/index.php": {
    "memory": 3008  // Increase to 3008 atau lebih
  }
}
```

---

## 📊 Monitoring di Production

### 1. Vercel Analytics

- Dashboard → Analytics
- Monitor requests, performance, errors

### 2. Vercel Logs

```bash
# Real-time logs
vercel logs --tail

# Specific deployment
vercel logs [deployment-url]
```

### 3. Application Logging

```php
// Di SearchController
\Log::info('Search query', ['query' => $query, 'results' => count($documents)]);
```

View logs di Vercel dashboard → Deployments → Function logs

---

## 🔄 Continuous Deployment

Setup sudah otomatis! Setiap push ke `main` branch:
1. Vercel detect perubahan
2. Build & test otomatis
3. Deploy ke production
4. Preview deployment tersedia

---

## 📈 Performance Optimization

### 1. Database Connection Pooling

```env
# Optional: Jika menggunakan PgBouncer di Supabase
DB_URL=postgresql://user:pass@host:port/db?connection_limit=5
```

### 2. Caching Strategy

```php
// Cache search results (optional)
$documents = Cache::remember("search:{$query}", 3600, function () use ($query) {
    return Document::whereFullText(['title', 'content'], $query)->get();
});
```

### 3. API Rate Limiting

```php
// Di SearchController
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', [SearchController::class, 'index']);
});
```

---

## 🚨 Backup & Recovery

### Supabase Backups

1. Vercel Dashboard → Project Settings → Backups
2. Atau di Supabase: Settings → Backups
3. Automatic daily backups (14 hari retention)

### Manual Backup

```bash
# Export database
pg_dump -h xxx.supabase.co -U postgres postgres > backup.sql

# Import dari backup
psql -h xxx.supabase.co -U postgres postgres < backup.sql
```

---

## 📚 Useful Commands

```bash
# Check deployment status
vercel status

# Rollback to previous deployment
vercel rollback

# View environment variables
vercel env list

# Pull env vars
vercel env pull

# View deployments
vercel ls

# Delete deployment
vercel rm [deployment-url]
```

---

## 📖 Additional Resources

- [Vercel Laravel Documentation](https://vercel.com/docs/frameworks/laravel)
- [Supabase PostgreSQL Docs](https://supabase.com/docs/guides/database/overview)
- [Vercel Environment Variables](https://vercel.com/docs/concepts/projects/environment-variables)
- [Laravel Deployment](https://laravel.com/docs/deployment)

---

## ✅ Deployment Checklist

- [ ] Supabase project created
- [ ] Database connection verified
- [ ] Project pushed to GitHub
- [ ] Vercel project created
- [ ] Environment variables set
- [ ] Deployment successful
- [ ] Migrations run
- [ ] Seeders executed
- [ ] Search functionality tested
- [ ] Analytics & monitoring setup
- [ ] Custom domain configured (optional)
- [ ] Backups configured

---

**Version:** 1.0.0  
**Last Updated:** 2025-01-16  
**Status:** Ready for Production ✅
