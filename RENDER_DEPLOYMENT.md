# Panduan Deployment Laravel ke Render.com 🚀

Project ini telah dikonfigurasi secara lengkap agar dapat langsung dideploy ke **Render.com** (menggunakan Docker & PostgreSQL / MySQL).

---

## 🛠️ Langkah-Langkah Deployment

### Cara 1: Menggunakan Render Blueprint (Otomatis & Direkomendasikan) 🌟

1. **Push Perubahan ke GitHub/GitLab:**
   Pastikan file-file berikut sudah di-commit dan di-push ke repository Git Anda:
   - `Dockerfile`
   - `render.yaml`
   - `docker/entrypoint.sh`
   - `docker/nginx-render.conf`
   - `config/database.php`

   ```bash
   git add .
   git commit -m "Configure Docker & Render deployment setup"
   git push origin main
   ```

2. **Buka Render Dashboard:**
   - Login ke [dashboard.render.com](https://dashboard.render.com/).
   - Klik tombol **New +** di pojok kanan atas, lalu pilih **Blueprint**.

3. **Hubungkan Repository:**
   - Pilih repository GitHub / GitLab project Anda.
   - Render secara otomatis akan membaca file `render.yaml`.
   - Render akan membuat:
     - 1 Service Web Container (PHP 8.2 + Nginx)
     - 1 Database PostgreSQL (Free Tier)
   - Klik **Approve** / **Apply**.

4. **Selesai!**
   Render akan membuild container Docker dan menjalankan migrasi database secara otomatis saat aplikasi dimulai.

---

### Cara 2: Manual Web Service & Database di Render

Jika Anda ingin membuat Web Service dan Database secara manual di dashboard Render:

#### Step 1: Buat Database PostgreSQL
1. Di dashboard Render, klik **New +** -> **PostgreSQL**.
2. Isi nama database, contoh: `supply-chain-db`.
3. Pilih Region (contoh: **Singapore**).
4. Pilih Plan **Free**.
5. Setelah database selesai dibuat, catat informasi koneksinya:
   - `Hostname` (Host)
   - `Port` (5432)
   - `Database`
   - `Username`
   - `Password`

#### Step 2: Buat Web Service (Laravel App)
1. Klik **New +** -> **Web Service**.
2. Hubungkan repository GitHub Anda.
3. Konfigurasi Service:
   - **Name**: `supply-chain-platform`
   - **Region**: Singapore
   - **Environment / Runtime**: `Docker`
   - **Dockerfile Path**: `./Dockerfile`
   - **Instance Type**: `Free`

4. Tambahkan **Environment Variables** berikut:

| Key | Value | Keterangan |
|---|---|---|
| `APP_ENV` | `production` | Lingkungan aplikasi |
| `APP_DEBUG` | `false` | Matikan mode debug |
| `APP_KEY` | *(Generate via `php artisan key:generate --show`)* | Key aplikasi Laravel |
| `APP_URL` | `https://supply-chain-platform.onrender.com` | URL Render Anda |
| `DB_CONNECTION` | `pgsql` | Gunakan driver PostgreSQL |
| `DB_HOST` | *(Internal Hostname dari PostgreSQL Render)* | Host DB |
| `DB_PORT` | `5432` | Port PostgreSQL |
| `DB_DATABASE` | `supply_chain_db` | Nama Database |
| `DB_USERNAME` | *(Username dari PostgreSQL Render)* | User DB |
| `DB_PASSWORD` | *(Password dari PostgreSQL Render)* | Password DB |

5. Klik **Create Web Service**.

---

## 🔍 Apa yang Terjadi Saat Deployment?

Saat container Docker Render dinyalakan, file script `docker/entrypoint.sh` akan otomatis:
1. Membaca port dinamis `$PORT` yang diberikan oleh Render.
2. Mengkonfigurasi Nginx Web Server secara otomatis.
3. Melakukan caching konfigurasi Laravel (`config:cache`, `route:cache`, `view:cache`).
4. Jalankan migrasi database otomatis (`php artisan migrate --force`).
5. Menjalankan PHP-FPM dan Nginx.

---

## ⚡ Opsional: Menjalankan Seeder Data Awal

Jika ingin mengisi data awal (Seeder) pada database Render:
1. Buka Web Service Anda di Render Dashboard.
2. Klik tab **Shell** di menu sebelah kiri.
3. Jalankan perintah:
   ```bash
   php artisan db:seed --force
   ```
