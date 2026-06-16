# Information Retrieval Search Engine

Sistem Temu Kembali Informasi (IR Search Engine) berbasis Laravel dengan database PostgreSQL, dirancang untuk deployment di Vercel.

## 📋 Daftar Fitur

✅ Full-text search menggunakan PostgreSQL dengan `whereFullText()`  
✅ Pencatatan retrieval time dalam milidetik (ms)  
✅ Highlight otomatis kata kunci pada hasil pencarian  
✅ Desain minimalis & responsive dengan Tailwind CSS  
✅ Ready to deploy di Vercel (serverless)  
✅ 5 data dummy teknologi untuk testing  
✅ SEO-friendly dengan metadata yang tepat  

---

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- PostgreSQL 12+ (atau Supabase)
- Node.js 18+ (untuk Tailwind CDN, optional)

### 1️⃣ Clone & Install Dependencies

```bash
# Clone repository
git clone <your-repo-url>
cd tugas-ir-search

# Install PHP dependencies
composer install

# Install Node dependencies (jika ada)
npm install
```

### 2️⃣ Setup Environment

```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

### 3️⃣ Konfigurasi Database

**Untuk Development (PostgreSQL Lokal):**

Edit `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ir_search
DB_USERNAME=postgres
DB_PASSWORD=password
```

**Untuk Production (Supabase):**

Edit `.env.production`:
```env
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

### 4️⃣ Jalankan Migration & Seeder

```bash
# Jalankan migration untuk membuat tabel documents
php artisan migrate

# Jalankan seeder untuk insert data dummy
php artisan db:seed --class=DocumentSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

### 5️⃣ Start Development Server

```bash
# Jalankan development server
php artisan serve

# Aplikasi dapat diakses di http://localhost:8000
```

---

## 📁 Struktur File Proyek

```
tugas-ir-search/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── SearchController.php       # Controller untuk pencarian
│   └── Models/
│       └── Document.php                   # Model Document
├── database/
│   ├── migrations/
│   │   └── 2025_01_01_000003_create_documents_table.php  # Migration tabel documents
│   └── seeders/
│       ├── DocumentSeeder.php             # Seeder data dummy
│       └── DatabaseSeeder.php             # Main seeder
├── resources/
│   └── views/
│       └── search.blade.php               # View halaman search
├── routes/
│   └── web.php                            # Route definition
├── api/
│   └── index.php                          # Entry point Vercel
├── config/
│   └── database.php                       # Database configuration
├── .env                                   # Environment variables
├── .env.example                           # Template .env untuk development
├── .env.production                        # Template .env untuk production
├── vercel.json                            # Vercel deployment config
└── README.md                              # Dokumentasi (file ini)
```

---

## 🔧 Komponen Utama

### 1. Migration: `create_documents_table.php`
- Membuat tabel `documents` dengan kolom: `id`, `title`, `content`, `created_at`, `updated_at`
- Menambahkan full-text index pada `title` dan `content`

### 2. Model: `Document.php`
- Model Eloquent untuk tabel documents
- Mass assignable: `title`, `content`

### 3. Seeder: `DocumentSeeder.php`
- Insert 5 data dummy bertema teknologi menggunakan foreach loop
- Terdaftar di `DatabaseSeeder.php`

### 4. Controller: `SearchController.php`
- Method `index()` untuk menampilkan halaman search
- Menggunakan `whereFullText()` untuk pencarian full-text
- Menghitung retrieval time dalam milidetik

### 5. Route: `routes/web.php`
- Route GET `/` mengarah ke `SearchController@index`

### 6. View: `search.blade.php`
- Form pencarian
- Statistik hasil (jumlah dokumen, retrieval time)
- Kartu hasil pencarian dengan highlight
- Responsive design dengan Tailwind CSS

### 7. Vercel Config: `vercel.json`
- Runtime: PHP 8.2
- Memory: 3008 MB
- Entry point: `api/index.php`

---

## 🔍 Fitur Pencarian

### Cara Kerja Search:

1. User mengetik keyword di form pencarian
2. Form dikirim via GET request dengan parameter `q`
3. `SearchController` menerima parameter dan mulai timer
4. Query menggunakan `Document::whereFullText(['title', 'content'], $query)`
5. Hasil ditampilkan dengan retrieval time
6. JavaScript secara otomatis highlight kata kunci (background kuning)

### Contoh Pencarian:

- **"Python"** → Menemukan dokumen dengan kata "Python" di title atau content
- **"Laravel Docker"** → Menemukan dokumen dengan salah satu atau kedua kata tersebut
- **"Information Retrieval"** → Menemukan dokumen relevan tentang IR

---

## 📊 Data Dummy yang Tersedia

1. **Panduan Lengkap Python untuk Pemula**
2. **Memahami Framework Laravel untuk Web Development**
3. **Docker: Virtualisasi Container untuk Deployment**
4. **Information Retrieval: Teknologi Pencarian di Era Digital**
5. **Keamanan Jaringan: Proteksi Data dan Sistem Informasi**

---

## 🌐 Deployment ke Vercel

### 1. Persiapan

```bash
# Init git (jika belum)
git init
git add .
git commit -m "Initial commit: IR Search Engine"

# Push ke GitHub
git push origin main
```

### 2. Konfigurasi Vercel

1. Login ke [vercel.com](https://vercel.com)
2. Import project dari GitHub
3. Set environment variables di Vercel dashboard:
   - `APP_KEY` (dari `php artisan key:generate`)
   - `DB_HOST` (Supabase host)
   - `DB_PORT` (5432)
   - `DB_DATABASE` (nama database)
   - `DB_USERNAME` (postgres)
   - `DB_PASSWORD` (password Supabase)

4. Deploy!

### 3. Post-Deployment

```bash
# SSH ke Vercel atau jalankan migration manually
vercel env pull
php artisan migrate --force
php artisan db:seed --class=DocumentSeeder --force
```

---

## 🛠️ Development Commands

```bash
# Generate APP_KEY
php artisan key:generate

# Jalankan migration
php artisan migrate

# Rollback migration
php artisan migrate:rollback

# Refresh migration & seed
php artisan migrate:refresh --seed

# Buat model baru
php artisan make:model ModelName -m

# Buat controller baru
php artisan make:controller ControllerName

# Buat migration baru
php artisan make:migration create_table_name

# Buat seeder baru
php artisan make:seeder SeederName

# Cache config
php artisan config:cache

# Clear cache
php artisan cache:clear
```

---

## 🔐 Keamanan

- ✅ SQL injection: Dilindungi dengan Eloquent ORM & parameterized queries
- ✅ XSS: Blade templating secara otomatis melakukan escaping
- ✅ CORS: Dikonfigurasi di `api/index.php`
- ✅ Database: Gunakan prepared statements (sudah built-in di Laravel)

**Tips Produksi:**
- Set `APP_DEBUG=false` di `.env.production`
- Enable HTTPS di Vercel
- Gunakan strong password untuk database
- Regular backup Supabase database

---

## 📝 Konfigurasi untuk Supabase PostgreSQL

Supabase kompatibel 100% dengan PostgreSQL. Hanya perlu setting connection string:

```
postgresql://postgres:[PASSWORD]@[HOST]:[PORT]/[DATABASE]
```

Atau individual settings:
```env
DB_CONNECTION=pgsql
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-secure-password
DB_SSLMODE=require
```

---

## 🐛 Troubleshooting

### Migration tidak jalan
```bash
# Check migration status
php artisan migrate:status

# Rollback dan retry
php artisan migrate:rollback
php artisan migrate
```

### Seeder error
```bash
# Run dengan verbose
php artisan db:seed --verbose

# Run specific seeder
php artisan db:seed --class=DocumentSeeder
```

### Vercel deployment error
- Check logs: `vercel logs`
- Ensure all environment variables set
- Check PHP version compatibility
- Verify database connection from Vercel

### Full-text search tidak bekerja
- Pastikan PostgreSQL version 9.6+
- Ensure migration sudah jalan: `php artisan migrate:status`
- Test query di database directly

---

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [PostgreSQL Full-Text Search](https://www.postgresql.org/docs/current/textsearch.html)
- [Supabase Documentation](https://supabase.com/docs)
- [Vercel Documentation](https://vercel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---

## 📄 License

MIT License - Feel free to use this project for personal or commercial purposes.

---

## 👨‍💻 Author

Dibuat untuk memenuhi tugas Sistem Temu Kembali Informasi (Information Retrieval)

**Version:** 1.0.0  
**Last Updated:** 2025-01-16
