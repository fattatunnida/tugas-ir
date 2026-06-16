# PostgreSQL & Supabase Setup Guide

Panduan lengkap untuk konfigurasi PostgreSQL dan Supabase untuk IR Search Engine.

## 🔧 Setup PostgreSQL Lokal (Windows/Mac/Linux)

### Windows

1. **Download & Install PostgreSQL**
   - Kunjungi: https://www.postgresql.org/download/windows/
   - Download PostgreSQL 12 atau lebih baru
   - Jalankan installer dan ikuti wizard
   - Ingat username (default: `postgres`) dan password yang Anda buat

2. **Buka PostgreSQL Command Line**
   ```cmd
   psql -U postgres
   ```

3. **Buat Database**
   ```sql
   CREATE DATABASE ir_search;
   ```

4. **Verifikasi**
   ```sql
   \l
   ```

5. **Keluar**
   ```sql
   \q
   ```

### Mac

```bash
# Install menggunakan Homebrew
brew install postgresql@15

# Start service
brew services start postgresql@15

# Connect ke PostgreSQL
psql postgres

# Buat database
CREATE DATABASE ir_search;

# Keluar
\q
```

### Linux (Ubuntu/Debian)

```bash
# Update package manager
sudo apt update

# Install PostgreSQL
sudo apt install postgresql postgresql-contrib

# Start service
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Connect sebagai postgres user
sudo -u postgres psql

# Buat database
CREATE DATABASE ir_search;

# Keluar
\q
```

---

## 🌐 Setup Supabase (Cloud PostgreSQL)

Supabase adalah provider PostgreSQL cloud yang gratis dan mudah digunakan.

### 1. Buat Account Supabase

1. Kunjungi: https://supabase.com
2. Klik "Start your project"
3. Login dengan GitHub atau email
4. Buat project baru

### 2. Dapatkan Connection String

1. Masuk ke Supabase Dashboard
2. Navigasi ke Project Settings → Database
3. Copy connection string atau individual parameters:
   ```
   Host: xxx.supabase.co
   Port: 5432
   Database: postgres
   User: postgres
   Password: [your-password]
   ```

### 3. Update .env

```env
DB_CONNECTION=pgsql
DB_HOST=xxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-secure-password
DB_SSLMODE=require
```

---

## 🗄️ Full-Text Search di PostgreSQL

### Cara Kerja

Full-text search di PostgreSQL menggunakan:
- **Text Search Vector**: Preprocessing teks untuk pencarian
- **Query Operator**: Menentukan parameter pencarian
- **Ranking**: Menentukan relevansi hasil

### Membuat Full-Text Index

```sql
-- Sudah dilakukan otomatis oleh migration
CREATE INDEX documents_fulltext_idx 
ON documents USING GIN (to_tsvector('english', title || ' ' || content));
```

### Query Contoh

```sql
-- Mencari dokumen dengan kata "Python"
SELECT * FROM documents 
WHERE to_tsvector('english', title || ' ' || content) 
  @@ plainto_tsquery('english', 'Python');

-- Dengan ranking
SELECT *, 
       ts_rank(to_tsvector('english', title || ' ' || content), 
               plainto_tsquery('english', 'Python')) AS rank
FROM documents
WHERE to_tsvector('english', title || ' ' || content) 
  @@ plainto_tsquery('english', 'Python')
ORDER BY rank DESC;
```

### Di Laravel

```php
// Method built-in Laravel
$documents = Document::whereFullText(['title', 'content'], 'Python')->get();

// Dengan ordering by relevance
$documents = Document::whereFullText(['title', 'content'], 'Python')
    ->orderByRaw("RANK(fulltext_search) DESC")
    ->get();
```

---

## 🧪 Testing Database Connection

### Menggunakan Laravel Artisan Tinker

```bash
# Buka tinker shell
php artisan tinker

# Test connection
>>> DB::connection()->getPdo();
# Should return PDO object, not error

# Cek migration status
>>> \Illuminate\Support\Facades\Artisan::call('migrate:status');

# Insert test data
>>> App\Models\Document::create([
    'title' => 'Test Document',
    'content' => 'This is a test content for IR system'
]);

# Query test
>>> App\Models\Document::whereFullText(['title', 'content'], 'test')->get();

# Exit tinker
>>> exit
```

### Menggunakan PostgreSQL CLI

```bash
# Connect ke database
psql -h 127.0.0.1 -U postgres -d ir_search

# List tables
\dt

# Check documents table
SELECT * FROM documents;

# Count documents
SELECT COUNT(*) FROM documents;

# Test full-text search
SELECT * FROM documents 
WHERE to_tsvector(title || ' ' || content) @@ plainto_tsquery('Python');

# Exit
\q
```

---

## 🔐 Security Best Practices

### Untuk Production (Supabase)

1. **Use Strong Passwords**
   ```
   Minimal 12 karakter, kombinasi:
   - Uppercase letters (A-Z)
   - Lowercase letters (a-z)
   - Numbers (0-9)
   - Special characters (!@#$%^&*)
   ```

2. **Enable SSL Connections**
   ```env
   DB_SSLMODE=require
   ```

3. **Use Connection Pooling**
   ```env
   # Jika menggunakan PgBouncer
   DB_POOL_SIZE=5
   DB_POOL_TIMEOUT=30
   ```

4. **Restrict Access**
   - Supabase: Set IP whitelist jika tersedia
   - Jangan share password di GitHub
   - Gunakan environment variables

5. **Regular Backups**
   - Supabase: Automatic daily backups
   - Manual: Export database regularly

---

## 📊 Performance Tips

### 1. Index Optimization

```sql
-- Check index usage
SELECT * FROM pg_indexes 
WHERE tablename = 'documents';

-- Analyze query performance
EXPLAIN ANALYZE
SELECT * FROM documents 
WHERE to_tsvector(title || ' ' || content) @@ plainto_tsquery('Python');
```

### 2. Query Optimization

```php
// ❌ BAD: N+1 queries
$documents = Document::all();
foreach ($documents as $doc) {
    echo $doc->created_at;
}

// ✅ GOOD: Single query
$documents = Document::select('id', 'title', 'created_at')->get();
```

### 3. Pagination untuk Dataset Besar

```php
// ✅ Pagination
$documents = Document::whereFullText(['title', 'content'], 'query')
    ->paginate(15);

// ✅ Infinite scroll dengan cursor
$documents = Document::whereFullText(['title', 'content'], 'query')
    ->cursorPaginate(15);
```

---

## 🆘 Common Issues & Solutions

### Issue: "FATAL: password authentication failed for user "postgres""

**Solusi:**
```bash
# Reset password PostgreSQL
sudo -u postgres psql

postgres=# ALTER USER postgres PASSWORD 'new_password';

# Update .env
DB_PASSWORD=new_password
```

### Issue: "SQLSTATE[08006] could not connect to server"

**Solusi:**
1. Pastikan PostgreSQL service berjalan
2. Check host, port, dan credentials di .env
3. Untuk Supabase, pastikan SSL mode enabled
4. Check firewall settings

### Issue: "Full-text search tidak bekerja"

**Solusi:**
```php
// Pastikan migration sudah berjalan
php artisan migrate:status

// Jika belum, jalankan migration
php artisan migrate

// Verify index di database
psql -U postgres -d ir_search
\d documents
```

### Issue: "SQLSTATE[42601] syntax error in full text search"

**Solusi:**
```php
// Escape special characters
$query = str_replace(['&', '|', '!', '(', ')', '<', '>'], '', $query);

// Atau gunakan plainto_tsquery (lebih aman)
Document::whereFullText(['title', 'content'], $query)->get();
```

---

## 📈 Monitoring & Debugging

### Laravel Logs

```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log

# Clear logs
php artisan tinker
>>> \Log::flush();
```

### Database Slow Query Log

```sql
-- Enable slow query log (Supabase)
-- Tidak bisa diakses langsung, gunakan application monitoring

-- Di local PostgreSQL
ALTER SYSTEM SET log_min_duration_statement = 1000; -- 1 second
SELECT pg_reload_conf();
```

### Query Profiling

```php
// Enable query logging
\DB::enableQueryLog();

$documents = Document::whereFullText(['title', 'content'], 'query')->get();

// View queries
\DB::getQueryLog();
```

---

## 📚 Resources

- [PostgreSQL Official Documentation](https://www.postgresql.org/docs/)
- [Supabase Documentation](https://supabase.com/docs)
- [Laravel Database Documentation](https://laravel.com/docs/database)
- [Full-Text Search in PostgreSQL](https://www.postgresql.org/docs/current/textsearch.html)
- [Vercel PostgreSQL Setup](https://vercel.com/docs/storage/vercel-postgres)

---

**Version:** 1.0.0  
**Last Updated:** 2025-01-16
