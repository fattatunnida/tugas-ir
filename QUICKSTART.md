# 🚀 Quick Start Guide

Panduan singkat untuk langsung menjalankan IR Search Engine dalam 5 menit.

## ⚡ Setup 5 Menit

### Step 1: Clone & Install (2 menit)

```bash
# Masuk folder project
cd tugas-ir-search

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate key
php artisan key:generate
```

### Step 2: Konfigurasi Database (1 menit)

**Pilih salah satu:**

**Option A: PostgreSQL Lokal**
```env
# Di .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ir_search
DB_USERNAME=postgres
DB_PASSWORD=password
```

**Option B: Supabase (Cloud)**
```env
# Di .env
DB_CONNECTION=pgsql
DB_HOST=xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xxxxx
```

### Step 3: Setup Database (1 menit)

```bash
# Buat tabel
php artisan migrate

# Insert data dummy
php artisan db:seed --class=DocumentSeeder
```

### Step 4: Jalankan Server (1 menit)

```bash
# Start development server
php artisan serve

# Buka browser: http://localhost:8000
```

---

## 🧪 Test Search

1. Buka http://localhost:8000
2. Cari keyword:
   - `Python`
   - `Laravel`
   - `Docker`
   - `Information Retrieval`
   - `Keamanan`

3. Hasilnya:
   - ✅ Dokumen ditemukan
   - ✅ Retrieval time (ms) ditampilkan
   - ✅ Kata kunci ter-highlight kuning
   - ✅ Statistik jumlah hasil

---

## 📁 File Struktur Penting

```
tugas-ir-search/
├── app/Http/Controllers/SearchController.php  # Logic pencarian
├── app/Models/Document.php                    # Model database
├── database/
│   ├── migrations/2025_01_01_000003_*.php    # Buat tabel
│   └── seeders/DocumentSeeder.php             # Data dummy
├── resources/views/search.blade.php           # Halaman UI
├── routes/web.php                            # Route
├── vercel.json                               # Deploy Vercel
└── .env                                      # Konfigurasi
```

---

## 🔍 Troubleshooting

### Error: "SQLSTATE[08006]"
**Solusi:** Pastikan database sudah buat dan .env benar
```bash
# Cek connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Error: "No application key has been generated"
**Solusi:** Jalankan
```bash
php artisan key:generate
```

### Error: "Base table or view not found"
**Solusi:** Jalankan migration
```bash
php artisan migrate
```

---

## 📊 Cek Status

```bash
# Check migration status
php artisan migrate:status

# Check database connection
php artisan db:show

# List all routes
php artisan route:list
```

---

## 🎯 Next Steps

1. ✅ Jalankan project lokal
2. 📖 Baca [SETUP.md](./SETUP.md) untuk dokumentasi lengkap
3. 🗄️ Baca [DATABASE_SETUP.md](./DATABASE_SETUP.md) untuk setup database detail
4. 🚀 Baca [VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md) untuk deploy ke Vercel

---

**Selamat, project sudah siap! 🎉**
