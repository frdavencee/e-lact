# Fitur Upload Gambar untuk Laporan Commissioning Test

## Deskripsi
Fitur ini memungkinkan pengguna untuk mengupload dan mengelola gambar dokumentasi untuk Laporan Commissioning Test (CT) di setiap lokasi.

## Komponen yang Ditambahkan

### 1. Database
- **Tabel Baru:** `commissioning_test_images`
- **Fields:**
  - `id` - Primary Key
  - `commissioning_test_id` - Foreign Key ke `commissioning_tests`
  - `file_path` - Path ke file gambar yang disimpan
  - `label` - Label/keterangan untuk gambar (contoh: "Dokumentasi Penarikan Kabel")
  - `urutan` - Urutan gambar (untuk sorting)
  - `timestamps` - created_at, updated_at

### 2. Model
- **CommissioningTestImage** (`app/Models/CommissioningTestImage.php`)
  - Relations: Belongs to CommissioningTest

- **CommissioningTest** (updated)
  - Relasi baru: `images()` - HasMany ke CommissioningTestImage

### 3. Controller
- **CommissioningTestController** (updated)
  - `store()` - Handle upload gambar saat membuat CT
  - `update()` - Handle upload gambar saat edit CT
  - `storeImages()` - Private method untuk memproses dan menyimpan file

### 4. View
- **commissioning_test.blade.php** (updated)
  - Form upload multiple gambar
  - Preview gambar yang sudah di-upload
  - Button untuk menambah/menghapus upload field
  - Label/keterangan untuk setiap gambar

### 5. LACT Document Service
- **LactDocumentService.php** (updated)
  - Load relasi `commissioningTest.images`
  - Generate halaman baru "LAMPIRAN DOKUMENTASI COMMISSIONING TEST"
  - Tampilkan gambar dalam grid 3 kolom
  - Include label dan baris PARAF untuk setiap gambar

## Fitur Utama

### Upload Gambar
1. Buka halaman Lokasi → tab "Commissioning Test"
2. Scroll ke bagian "Upload Dokumentasi Gambar"
3. Klik "Tambah Gambar" untuk menambah field upload
4. Upload foto dengan format: JPEG, PNG, JPG, GIF (max 5MB per file)
5. Isi label/keterangan untuk setiap gambar
6. Klik "Simpan Data CT" untuk menyimpan

### Edit Gambar
1. Gambar yang sudah ter-upload akan ditampilkan
2. Klik link gambar untuk melihat preview
3. Upload gambar baru untuk mengganti (atau kosongkan untuk tidak mengubah)
4. Edit label/keterangan
5. Klik "Simpan Data CT"

### Hapus Gambar
- Saat upload baru, klik tombol "Hapus" pada baris gambar yang tidak ingin diupload

## Validasi
- Format file: JPEG, PNG, JPG, GIF
- Ukuran maksimal: 5MB per file
- Multiple upload: Unlimited (sesuai server memory)

## Penyimpanan File
- Path: `storage/app/public/commissioning-test-images/`
- Accessible via: `/storage/commissioning-test-images/`

## LACT Output
Saat generate LACT DOCX:
1. Halaman "LAPORAN COMMISSIONING TEST" tetap seperti biasa
2. Halaman baru ditambahkan: "LAMPIRAN DOKUMENTASI COMMISSIONING TEST"
3. Gambar ditampilkan dalam grid 3 kolom
4. Setiap gambar memiliki baris untuk label dan PARAF

## Database Migration
Migration file: `2026_06_21_045552_create_commissioning_test_images_table.php`
Status: Sudah di-create menggunakan tinker command

## Cara Testing

### 1. Akses Form Upload
```
URL: http://127.0.0.1:8000/lokasi/{id}/commissioning
```

### 2. Upload Gambar
- Klik tab "Commissioning Test"
- Scroll ke "Upload Dokumentasi Gambar"
- Klik "Tambah Gambar"
- Upload 3-5 foto dummy
- Isi label untuk setiap foto
- Klik "Simpan Data CT"

### 3. Verify di Database
```sql
SELECT * FROM commissioning_test_images WHERE commissioning_test_id = 1;
```

### 4. Generate LACT
```
php tools/generate_all_lact.php
```

### 5. Buka DOCX
- File akan ter-generate di: `storage/app/public/generated/LACT_[CODE]_v1.docx`
- Cek halaman "LAMPIRAN DOKUMENTASI COMMISSIONING TEST"
- Verifikasi gambar, label, dan baris PARAF muncul dengan benar

## File yang Diubah
1. `app/Models/CommissioningTest.php` - Tambah relasi images()
2. `app/Models/CommissioningTestImage.php` - Model baru
3. `app/Http/Controllers/CommissioningTestController.php` - Handle upload & storage
4. `resources/views/lokasi/partials/commissioning_test.blade.php` - Form upload
5. `app/Services/LactDocumentService.php` - Generate halaman dokumen dengan gambar
6. `database/migrations/2026_06_21_045552_create_commissioning_test_images_table.php` - Migration

## Notes
- Gambar disimpan dalam folder terpisah untuk organisasi yang lebih baik
- Setiap gambar dapat memiliki label sendiri untuk dokumentasi yang lebih jelas
- Urutan gambar dapat diatur melalui `urutan` field
- Saat CT dihapus, semua gambar terhapus otomatis (cascadeOnDelete)
- Storage link sudah dikonfigurasi untuk akses file di public

