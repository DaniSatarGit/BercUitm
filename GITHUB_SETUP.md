# 📤 Cara Push ke GitHub / How to Push to GitHub

Panduan ringkas untuk masukkan project BercUITM ke GitHub.

---

## 🔧 Setup Awal (One-Time) / Initial Setup

### 1. Pastikan Git Sudah Installed
```powershell
git --version
```
Jika tidak ada, download dari: https://git-scm.com/

### 2. Config Git (First Time)
```powershell
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
```

### 3. Buat Repository di GitHub
- Buka https://github.com/new
- Nama: `BercUITM` (atau pilihan anda)
- Description: `Sistem Pengurusan Ulasan Reviewer`
- Pilih: Public atau Private
- **JANGAN** tick "Initialize this repository with a README"
- Klik "Create repository"

Anda akan dapat link seperti:
```
https://github.com/username/BercUITM.git
```

---

## 📝 Push Project ke GitHub

### Langkah 1: Buka PowerShell/Terminal
```powershell
cd C:\xampp\htdocs\BercUitm
```

### Langkah 2: Inisialisasi Repository Lokal
```powershell
git init
```

### Langkah 3: Add Semua Files
```powershell
git add .
```

### Langkah 4: Commit Pertama
```powershell
git commit -m "Initial commit: BercUITM Reviewer Management System"
```

### Langkah 5: Set Remote Repository
```powershell
git remote add origin https://github.com/USERNAME/BercUITM.git
```
*(Gantikan USERNAME dengan username GitHub anda)*

### Langkah 6: Rename Branch ke 'main' (Optional)
```powershell
git branch -M main
```

### Langkah 7: Push ke GitHub
```powershell
git push -u origin main
```

Anda akan diminta masukkan GitHub credentials:
- **Username**: username GitHub anda
- **Password**: personal access token (bukan password biasa)

---

## 🔑 Jika Error: "Authentication Failed"

### Buat Personal Access Token (PAT)
1. Buka: https://github.com/settings/tokens
2. Klik "Generate new token" → "Generate new token (classic)"
3. Set Expiration: 90 days (atau lebih)
4. Tick checkbox: `repo` (full control of private repositories)
5. Klik "Generate token"
6. **COPY token yang dihasilkan** (sekali saja muncul)

### Guna Token untuk Push
```powershell
git push -u origin main
```
Masukkan:
- **Username**: username GitHub anda
- **Password**: (paste token yang di-copy tadi, bukan password)

---

## ✅ Verifikasi Push

Buka browser:
```
https://github.com/USERNAME/BercUITM
```

Anda sepatutnya lihat semua files sudah di-upload! ✨

---

## 📤 Push Update Seterusnya (Untuk Perubahan Masa Depan)

### Setiap kali ada perubahan:
```powershell
# 1. Check status
git status

# 2. Add changes
git add .

# 3. Commit dengan message
git commit -m "Description of changes"

# 4. Push ke GitHub
git push
```

### Contoh:
```powershell
git add .
git commit -m "Fix: reviewer form validation"
git push
```

---

## 🔀 Clone Project (Untuk Orang Lain)

Jika orang lain nak guna project anda:
```powershell
git clone https://github.com/USERNAME/BercUITM.git
cd BercUITM
```

---

## 📋 File-File Yang Perlu di-Ignore / .gitignore

Buat file `.gitignore` di root project:

```powershell
# Buat file
echo @"
# System
.DS_Store
Thumbs.db

# IDE
.vscode/
.idea/
*.swp

# PHP/Development
*.php.bak
error.log
debug.log

# Database
*.sql
backup/

# Credentials (JANGAN push password/config)
# config.php (jika ada sensitive data)

# Cache
__pycache__/
*.cache

# Node (jika ada)
node_modules/
package-lock.json

# Upload folders (opsyonal)
uploads/
Reviewer/reviews_pdf/*
# Tapi keep folder structure
!Reviewer/reviews_pdf/.gitkeep
"@ | Out-File .gitignore
```

Then:
```powershell
git add .gitignore
git commit -m "Add .gitignore"
git push
```

---

## 🎯 Command Ringkas (Copy-Paste Ready)

### Setup Pertama:
```powershell
cd C:\xampp\htdocs\BercUitm
git init
git add .
git commit -m "Initial commit: BercUITM Reviewer Management System"
git remote add origin https://github.com/USERNAME/BercUITM.git
git branch -M main
git push -u origin main
```

### Update Seterusnya:
```powershell
git add .
git commit -m "Your message here"
git push
```

---

## ❓ Troubleshooting

| Error | Solusi |
|-------|--------|
| `fatal: not a git repository` | Jalankan `git init` dulu |
| `authentication failed` | Guna Personal Access Token, bukan password |
| `rejected... (non-fast-forward)` | Jalankan `git pull` dulu sebelum push |
| `branch 'main' set up to track 'origin/main'` | Normal ✅ |

---

## 📚 Resources

- GitHub Guide: https://guides.github.com/
- Git Cheatsheet: https://github.github.com/training-kit/downloads/github-git-cheat-sheet.pdf
- Personal Access Token: https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token

---

**Selesai!** 🎉 Project anda sudah ready untuk di-share di GitHub.
