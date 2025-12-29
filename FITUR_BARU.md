# Fitur Baru Mitus Stationery - Panduan Lengkap

## ✨ Fitur-Fitur yang Ditambahkan

### 1. 🤍 Wishlist / Favorit Produk
**File yang terlibat:**
- [app/Models/Wishlist.php](app/Models/Wishlist.php)
- [app/Http/Controllers/WishlistController.php](app/Http/Controllers/WishlistController.php)
- [resources/views/wishlists/index.blade.php](resources/views/wishlists/index.blade.php)
- Database: `wishlists` table

**Fitur:**
- Pengguna bisa menambah/menghapus produk ke wishlist
- View wishlist dengan daftar produk favorit
- Tombol toggle wishlist di halaman produk
- Hanya tersedia untuk user yang login

**Penggunaan:**
```php
// Add to wishlist
POST /wishlist/add/{product}

// View wishlist
GET /wishlist

// Remove from wishlist
DELETE /wishlist/{wishlist}

// Toggle wishlist (AJAX)
POST /wishlist/toggle/{product}

// Check if in wishlist (AJAX)
GET /wishlist/check/{product}
```

---

### 2. ⭐ Review dan Rating Produk
**File yang terlibat:**
- [app/Models/Review.php](app/Models/Review.php)
- [app/Http/Controllers/ReviewController.php](app/Http/Controllers/ReviewController.php)
- [resources/views/products/show.blade.php](resources/views/products/show.blade.php)
- Database: `reviews` table

**Fitur:**
- User bisa memberikan rating (1-5 bintang) dan komentar
- Rating otomatis dihitung dari semua review
- Tampilan rating terintegrasi di halaman produk
- User bisa mengubah review mereka
- Admin bisa menghapus review

**Penggunaan:**
```php
// Store review
POST /review/{product}
Parameters: rating (1-5), comment (optional)

// Delete review
DELETE /review/{review}

// Get all reviews for a product (AJAX)
GET /review/{product}
```

---

### 3. 🔍 Pencarian Produk dengan Filter Pintar
**File yang terlibat:**
- [app/Http/Controllers/ProductController.php](app/Http/Controllers/ProductController.php)
- [resources/views/products/index.blade.php](resources/views/products/index.blade.php)

**Fitur Pencarian:**
- Search by nama produk atau deskripsi
- Filter berdasarkan kategori
- Filter berdasarkan harga (min & max)
- Sort: Terbaru, Harga Terendah, Harga Tertinggi, Rating Tertinggi
- Sidebar filter yang user-friendly

**URL Query Parameters:**
```
GET /products?search=pulpen&category=1&min_price=5000&max_price=50000&sort=price_low
```

---

### 4. 📂 Kategori Produk
**File yang terlibat:**
- [app/Models/Category.php](app/Models/Category.php)
- [database/migrations/2025_12_29_042057_create_categories_table.php](database/migrations/2025_12_29_042057_create_categories_table.php)
- [database/seeders/CategorySeeder.php](database/seeders/CategorySeeder.php)
- Database: `categories` table

**Kategori Default:**
1. Alat Tulis
2. Kertas
3. Buku
4. Penggaris & Alat Ukur
5. Cat & Kuas
6. Tas & Tempat

---

## 🗄️ Database Schema

### Categories Table
```sql
CREATE TABLE categories (
  id BIGINT PRIMARY KEY,
  name VARCHAR(255) UNIQUE,
  description TEXT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
)
```

### Wishlists Table
```sql
CREATE TABLE wishlists (
  id BIGINT PRIMARY KEY,
  user_id BIGINT FOREIGN KEY,
  product_id BIGINT FOREIGN KEY,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  UNIQUE(user_id, product_id)
)
```

### Reviews Table
```sql
CREATE TABLE reviews (
  id BIGINT PRIMARY KEY,
  user_id BIGINT FOREIGN KEY,
  product_id BIGINT FOREIGN KEY,
  rating TINYINT (1-5),
  comment TEXT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
)
```

### Products Table (Updated)
```sql
ALTER TABLE products ADD COLUMN category_id BIGINT FOREIGN KEY
```

---

## 🛣️ Routes

### Wishlist Routes (Authenticated)
```php
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check/{product}', [WishlistController::class, 'isInWishlist'])->name('wishlist.check');
});
```

### Review Routes (Authenticated)
```php
Route::middleware('auth')->group(function () {
    Route::post('/review/{product}', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::get('/review/{product}', [ReviewController::class, 'getProductReviews'])->name('review.get');
});
```

---

## 📦 Model Relationships

### Product
```php
- hasMany Wishlist
- hasMany Review
- belongsTo Category
- hasMany OrderItem
- hasMany CartItem
```

### User
```php
- hasMany Wishlist
- hasMany Review
```

### Category
```php
- hasMany Product
```

---

## ✅ Testing Checklist

- [ ] Login sebagai user
- [ ] Buka halaman produk
- [ ] Test search filter
- [ ] Test kategori filter
- [ ] Test price range filter
- [ ] Test sort options
- [ ] Tambahkan produk ke wishlist
- [ ] Lihat halaman wishlist
- [ ] Berikan rating dan review
- [ ] Ubah review
- [ ] Hapus review

---

## 📝 Catatan Penting

1. **Category ID pada Produk Lama:** Produk yang sudah ada sebelumnya akan memiliki `category_id = NULL`. Silakan update secara manual atau bulk update di database.

2. **Migration:** Semua migration sudah dijalankan otomatis saat menjalankan `php artisan migrate`.

3. **Seeder:** Kategori sudah dibuat melalui `CategorySeeder`. Jalankan `php artisan db:seed --class=CategorySeeder` jika belum.

4. **AJAX:** Fitur wishlist toggle dan review menggunakan AJAX untuk pengalaman yang lebih smooth.

---

**Dibuat pada:** 29 December 2025  
**Framework:** Laravel 11  
**Database:** MySQL
