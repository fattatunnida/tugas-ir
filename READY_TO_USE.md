# 🎯 READY TO USE - Copy & Paste Commands

Semua file sudah tersedia dan siap digunakan. Berikut adalah instruksi copy-paste yang siap langsung dijalankan.

---

## ⚡ Setup Instan (5 Menit)

### Step 1: Update .env File

Edit file `.env` dan ubah database credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ir_search
DB_USERNAME=postgres
DB_PASSWORD=password
```

Atau untuk Supabase:

```env
DB_CONNECTION=pgsql
DB_HOST=xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

### Step 2: Run Migration

Copy-paste command ini di terminal:

```bash
php artisan migrate
```

### Step 3: Seed Database

```bash
php artisan db:seed --class=DocumentSeeder
```

### Step 4: Start Server

```bash
php artisan serve
```

### Step 5: Open Browser

```
http://localhost:8000
```

---

## 🔍 Test Pencarian

Coba keyword berikut:

1. **Python**
   - Should find: 1 document (Panduan Lengkap Python)

2. **Laravel**
   - Should find: 1 document (Framework Laravel)

3. **Docker**
   - Should find: 1 document (Docker Containerization)

4. **Information**
   - Should find: 1 document (Information Retrieval)

5. **Jaringan**
   - Should find: 1 document (Keamanan Jaringan)

6. **search**
   - Should find: Multiple documents (appears in multiple texts)

---

## 📊 Verify Installation

Run verification script:

**Windows:**
```powershell
powershell -File verify-setup.ps1
```

**Linux/Mac:**
```bash
bash verify-setup.sh
```

Expected output:
```
========== RESULTS ==========
Total Passed: 16
Total Failed: 0
SUCCESS: All critical checks passed!
```

---

## 🌐 Deploy ke Vercel

### Prerequisites
- GitHub account
- Vercel account (free)
- Supabase account (free)

### 1. Push ke GitHub

```bash
git add .
git commit -m "IR Search Engine - Ready for Vercel"
git push origin main
```

### 2. Buat Project di Vercel

1. Go to https://vercel.com/new
2. Import from GitHub
3. Select `tugas-ir-search` repository
4. Click Import

### 3. Set Environment Variables

Tambahkan ini di Vercel Environment Variables:

```
APP_KEY=base64:xxxxx (dari php artisan key:generate)
APP_ENV=production
APP_DEBUG=false
APP_NAME=IR Search Engine
DB_CONNECTION=pgsql
DB_HOST=xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
DB_SSLMODE=require
CACHE_STORE=array
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
```

### 4. Deploy

Click "Deploy" button dan tunggu selesai!

### 5. Run Migrations (Post-Deploy)

```bash
# Install Vercel CLI
npm install -g vercel

# Pull env vars
vercel env pull

# Run migrations
php artisan migrate --force
php artisan db:seed --class=DocumentSeeder --force
```

---

## 🗄️ PostgreSQL Local Setup

### Windows

```powershell
# Download & install dari: https://www.postgresql.org/download/windows/
# Jalankan installer dan ingat password

# Verifikasi installation
psql --version

# Connect ke postgres
psql -U postgres

# Buat database
CREATE DATABASE ir_search;

# Keluar
\q
```

### Mac

```bash
# Install via Homebrew
brew install postgresql@15

# Start service
brew services start postgresql@15

# Connect
psql postgres

# Buat database
CREATE DATABASE ir_search;

# Keluar
\q
```

### Linux (Ubuntu/Debian)

```bash
# Install
sudo apt update
sudo apt install postgresql postgresql-contrib

# Start service
sudo systemctl start postgresql

# Connect
sudo -u postgres psql

# Buat database
CREATE DATABASE ir_search;

# Keluar
\q
```

---

## 🆘 Troubleshooting

### Error: "SQLSTATE[08006] could not connect to server"

**Solution:**
1. Pastikan PostgreSQL sudah running
2. Check credentials di .env
3. Verify database sudah dibuat

```bash
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
# Should show PDO object
```

### Error: "Base table or view not found"

**Solution:**
```bash
# Run migrations
php artisan migrate

# Check status
php artisan migrate:status
```

### Error: "No application key has been generated"

**Solution:**
```bash
php artisan key:generate
```

### Seeder tidak jalan

**Solution:**
```bash
# Run dengan verbose
php artisan db:seed --verbose

# Check DocumentSeeder file
cat database/seeders/DocumentSeeder.php
```

---

## 📁 File Structure Quick Reference

```
tugas-ir-search/
├── app/
│   ├── Http/Controllers/SearchController.php   ← PENCARIAN
│   └── Models/Document.php                     ← DATABASE MODEL
├── database/
│   ├── migrations/2025_01_01_000003_*.php      ← BUAT TABEL
│   └── seeders/DocumentSeeder.php              ← DATA DUMMY
├── resources/views/search.blade.php            ← HALAMAN UI
├── routes/web.php                             ← URL ROUTING
├── api/index.php                              ← VERCEL ENTRY
├── vercel.json                                ← VERCEL CONFIG
├── .env                                       ← KONFIGURASI
├── .env.production                            ← PRODUCTION CONFIG
└── [DOCUMENTATION FILES]
```

---

## 📚 Documentation Quick Links

| Dokumen | Untuk |
|---------|-------|
| [QUICKSTART.md](./QUICKSTART.md) | Setup 5 menit |
| [SETUP.md](./SETUP.md) | Dokumentasi lengkap |
| [DATABASE_SETUP.md](./DATABASE_SETUP.md) | Database detail |
| [VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md) | Deploy Vercel |
| [IMPLEMENTATION_SUMMARY.md](./IMPLEMENTATION_SUMMARY.md) | Ringkasan implementasi |

---

## 🎯 Common Tasks

### Tambah Data Manual

```php
php artisan tinker

>>> App\Models\Document::create([
    'title' => 'My Document',
    'content' => 'This is the content of my document with relevant keywords'
]);

>>> exit
```

### Query Database Langsung

```bash
psql -U postgres -d ir_search

# List tables
\dt

# Query documents
SELECT * FROM documents;

# Test full-text search
SELECT * FROM documents WHERE to_tsvector(title || ' ' || content) @@ plainto_tsquery('Python');

# Exit
\q
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

### Reset Database

```bash
# Delete all data & recreate
php artisan migrate:refresh --seed

# Delete all data only
php artisan migrate:refresh

# Rollback one migration
php artisan migrate:rollback
```

---

## ✅ Pre-Launch Checklist

- [ ] .env file updated dengan database credentials
- [ ] `php artisan migrate` berhasil dijalankan
- [ ] `php artisan db:seed --class=DocumentSeeder` berhasil dijalankan
- [ ] `php artisan serve` berjalan tanpa error
- [ ] Browser http://localhost:8000 bisa diakses
- [ ] Search functionality berfungsi normal
- [ ] Verification script menunjukkan 16/16 passed
- [ ] Documentation sudah dibaca

---

## 🚀 Ready to Launch!

Ketika semua di atas sudah done, project Anda siap untuk:

1. ✅ Development lokal
2. ✅ Testing & debugging
3. ✅ Demo ke reviewer/dosen
4. ✅ Production deployment ke Vercel

---

## 📞 Need Help?

1. **Review QUICKSTART.md** untuk setup cepat
2. **Check DATABASE_SETUP.md** untuk database issues
3. **See VERCEL_DEPLOYMENT.md** untuk deployment problems
4. **Read SETUP.md** untuk complete documentation

---

**Good luck! 🎉**

Jangan lupa untuk:
- ✅ Commit kode ke GitHub
- ✅ Deploy ke Vercel
- ✅ Share hasil dengan dosen/reviewer
- ✅ Siapkan dokumentasi lengkap

**Version:** 1.0.0  
**Status:** Ready to Use ✅
