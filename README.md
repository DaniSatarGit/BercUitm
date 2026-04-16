# 🍪 BercUITM – Sistem Pengurusan Ulasan Reviewer

Sistem berasaskan web untuk menguruskan ulasan aplikasi etika. Koordinator menugaskan aplikasi kepada reviewer dan menjejaki hasil penilaian dengan status real-time.

---

## 🚀 Ciri-Ciri Utama / Features

✅ Akses berasaskan peranan (Koordinator / Reviewer)  
✅ Sistem penugasan aplikasi  
✅ Borang ulasan berstruktur (BERC 1-5)  
✅ Penghantaran ulasan dengan penjejakan status  
✅ Penjanaan & muat turun PDF  
✅ Penyimpanan ulasan berasaskan JSON (fleksibel & berskala)  
✅ Status otomatis (Pending → Completed)  

---

## 🛠️ Tindanan Teknologi / Tech Stack

```
Backend:     PHP (Native)
Database:    MySQL / MariaDB
Frontend:    HTML, CSS, JavaScript
Framework:   Bootstrap 5
PDF:         FPDF Library
Environment: XAMPP (Development)
```

---

## 📌 Aliran Kerja / Workflow

### Koordinator
```
1. Login → Coordinator/CoordinatorPage.php
2. Buka Aplikasi → cari aplikasi
3. Assign Reviewer → pilih dari dropdown
4. Status: Pending
```

### Reviewer
```
1. Login → Reviewer/ReviewerPage.php
2. Klik Application Portal
3. Lihat senarai aplikasi ditugaskan
4. Buka aplikasi → isi borang ulasan
5. Submit → sistem simpan + beri PDF
```

### Sistem
```
1. Terima data ulasan (POST)
2. INSERT ke reviews (JSON + metadata)
3. UPDATE reviewer_application.status = Completed
4. Janakan PDF & simpan di /reviews_pdf/
5. Beri muat turun kepada reviewer
```

---

## 🗄️ Struktur Database / Database Schema

| Jadual | Tujuan | Status |
|--------|--------|--------|
| `reviewer_application` | Tugasan reviewer ke aplikasi | Existing |
| `reviews` ⭐ | Rekod ulasan penuh (JSON) | NEW |
| `project_evaluations` | Legacy (backward compat) | Existing |

### Jadual Utama

**`reviewer_application`** (Penugasan)
```sql
id, application_id, reviewer_id, status (Pending/Completed), assigned_at
```

**`reviews`** (Ulasan Penuh) ⭐
```sql
id, application_id, reviewer_application_id, reviewer_id,
review_data (JSON), decision, modifications, pdf_filename, created_at
```

---

## 📂 Fail-Fail Penting / Key Files

| Fail | Lokasi | Tujuan |
|------|--------|--------|
| `create_reviews_table.sql` | Root | Migration jadual `reviews` |
| `berc9N.php` | `Reviewer/Application/` | Borang ulasan (isi) |
| `submitBerc9.php` | `Reviewer/` | Proses & simpan ulasan |
| `view_application.php` | `Reviewer/Application/` | Lihat aplikasi + ulasan |
| `application.php` | `Reviewer/Application/` | Senarai aplikasi |
| `assign_reviewer_application.php` | `Coordinator/` | Assign reviewer (AJAX) |

---

## ⚙️ Pemasangan / Installation

### 1️⃣ Persediaan
```bash
# Salin ke xampp htdocs
C:\xampp\htdocs\BercUitm\

# Buka XAMPP Control Panel
# Mulai Apache + MySQL
```

### 2️⃣ Import Database
```bash
# Kaedah 1: phpMyAdmin
# - Pilih database bercuitm
# - Tab Import → pilih create_reviews_table.sql
# - Klik Import

# Kaedah 2: CLI
mysql -u root -p bercuitm < create_reviews_table.sql
```

### 3️⃣ Akses Sistem
```
http://localhost/BercUitm/
```

---

## ▶️ Cara Guna / Usage

### Login
```
URL: http://localhost/BercUitm/
Pilih Peranan: Coordinator / Reviewer
Masukkan Staff ID & Password
```

### Koordinator: Tugaskan Reviewer
```
1. Login (Coordinator)
2. Aplikasi → cari aplikasi
3. Dropdown Assign Reviewer → pilih reviewer
4. Tekan "Assign Reviewer"
5. Status → "Not Assigned" jadi nama reviewer
```

### Reviewer: Beri Ulasan
```
1. Login (Reviewer)
2. Application Portal → lihat senarai
3. Klik aplikasi → buka halaman ulasan
4. Isi borang:
   - Bahagian A: Kaedah Penyelidikan
   - Bahagian B: Subjek
   - Bahagian C: Borang BERC (Yes/No + komentar)
   - Status BERC2/3/5
   - Keputusan Akhir
5. Tekan "Submit"
6. Muat turun PDF hasil ulasan
7. Status → Completed
```

---

## 📄 Output & Penyimpanan / Output & Storage

### Database
```sql
-- Lihat ulasan terbaru
SELECT * FROM reviews ORDER BY id DESC LIMIT 5;

-- Lihat status tugasan
SELECT id, application_id, reviewer_id, status, assigned_at
FROM reviewer_application
WHERE application_id = <app_id>;

-- Lihat data lengkap (JSON)
SELECT review_data, decision, pdf_filename
FROM reviews
WHERE application_id = <app_id>;
```

### Filesystem
```
Folder: C:\xampp\htdocs\BercUitm\Reviewer\reviews_pdf\
Nama: <project_title>_review_<timestamp>.pdf
```

---

## 🔍 Verifikasi / Verification

### Di Database
```powershell
# Buka phpMyAdmin → pilih bercuitm
SELECT * FROM reviews ORDER BY id DESC;

# Semak status
SELECT status FROM reviewer_application WHERE application_id = 1;
```

### Di Filesystem
```powershell
dir "C:\xampp\htdocs\BercUitm\Reviewer\reviews_pdf\"
```

### Hasil Dijangka / Expected Result
✅ Rekod ulasan muncul di `reviews` table  
✅ Status berubah: Pending → Completed  
✅ File PDF ada di folder `reviews_pdf/`  
✅ Reviewer dapat muat turun PDF  

---

## ⚠️ Catatan Penting / Important Notes

- **Session & Security**: Pastikan reviewer login sebelum beri ulasan
- **PDF Generation**: Menggunakan FPDF; disimpan untuk rujukan
- **Backward Compatibility**: Data tetap di `project_evaluations` untuk keserasian
- **JSON Storage**: Semua data borang disimpan JSON di column `review_data`
- **Permissions**: Pastikan folder `reviews_pdf/` writable (chmod 755)

---

## 🐛 Penyelesaian Masalah / Troubleshooting

| Masalah | Penyelesaian |
|--------|-------------|
| Submit button tidak berfungsi | Semak JS console; validasi form |
| PDF tidak muat turun | Buat folder `reviews_pdf/`; set permissions |
| Status tetap Pending | Semak error di submitBerc9.php; DB connection |
| Aplikasi tidak muncul | Pastikan reviewer di-assign via Coordinator |
| Borang tidak load data | Pastikan parameter `?id=<app_id>` dihantarkan |

---

## 📞 Sokongan / Support

Untuk bantuan atau pertanyaan, sila hubungi team development atau lihat dokumentasi dalam kod.

---

**Versi**: 1.0  
**Tarikh**: April 2026  
**Status**: ✅ Siap Guna / Production Ready


