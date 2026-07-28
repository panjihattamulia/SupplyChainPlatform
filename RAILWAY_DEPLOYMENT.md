# Panduan Deployment Laravel ke Railway.app 🚀

Project ini telah siap dideploy ke **Railway.app** menggunakan Dockerfile & Database (MySQL / PostgreSQL).

---

## 🛠️ Langkah-Langkah Deployment

### Cara 1: Deploy dari Dashboard Railway (GitHub Integration) 🌟

1. **Push Kode ke GitHub:**
   Pastikan perubahan terbaru sudah di-commit dan di-push ke repository GitHub Anda:
   ```bash
   git add .
   git commit -m "Add Railway deployment setup"
   git push origin main
   ```

2. **Buka Railway Dashboard:**
   - Login ke [railway.app](https://railway.app/).
   - Klik **New Project** di pojok kanan atas.
   - Pilih **Deploy from GitHub repo** dan pilih repository project ini.

3. **Tambahkan Database (MySQL atau PostgreSQL):**
   - Di dalam project Railway Anda, klik **+ New** / **Add Service**.
   - Pilih **Database** -> Pilih **MySQL** (atau **PostgreSQL**).
   - Railway akan secara otomatis membuatkan instance database.

4. **Konfigurasi Environment Variables di Web Service:**
   Klik pada service Laravel Anda di Railway Dashboard, masuk ke tab **Variables**, lalu tambahkan variabel berikut:

   **Jika Menggunakan MySQL:**
   | Key | Value (Gunakan Reference Railway) |
   |---|---|
   | `APP_ENV` | `production` |
   | `APP_DEBUG` | `false` |
   | `APP_KEY` | `base64:...` *(Generate dengan `php artisan key:generate --show`)* |
   | `DB_CONNECTION` | `mysql` |
   | `DB_HOST` | `${{MySQL.MYSQLHOST}}` |
   | `DB_PORT` | `${{MySQL.MYSQLPORT}}` |
   | `DB_DATABASE` | `${{MySQL.MYSQLDATABASE}}` |
   | `DB_USERNAME` | `${{MySQL.MYSQLUSER}}` |
   | `DB_PASSWORD` | `${{MySQL.MYSQLPASSWORD}}` |

   *(Catatan: Gantilah `MySQL` sesuai nama service database Anda di Railway jika berbeda)*

   **Jika Menggunakan PostgreSQL:**
   | Key | Value |
   |---|---|
   | `DB_CONNECTION` | `pgsql` |
   | `DB_HOST` | `${{Postgres.PGHOST}}` |
   | `DB_PORT` | `${{Postgres.PGPORT}}` |
   | `DB_DATABASE` | `${{Postgres.PGDATABASE}}` |
   | `DB_USERNAME` | `${{Postgres.PGUSER}}` |
   | `DB_PASSWORD` | `${{Postgres.PGPASSWORD}}` |

5. **Generate Public Domain:**
   - Masuk ke tab **Settings** pada Web Service Anda di Railway.
   - Di bagian **Networking** -> **Public Networking**, klik **Generate Domain**.
   - Tambahkan Environment Variable:
     - `APP_URL` = `https://<domain-railway-anda>.up.railway.app`

6. **Selesai!**
   Railway akan membuild Docker container secara otomatis dan `docker/entrypoint.sh` akan langsung menjalankan migrasi database (`php artisan migrate --force`) saat aplikasi dinyalakan.

---

### Cara 2: Deploy Menggunakan Railway CLI

1. **Install Railway CLI:**
   ```bash
   npm i -g @railway/cli
   ```
2. **Login ke Railway:**
   ```bash
   railway login
   ```
3. **Inisialisasi Project:**
   ```bash
   railway init
   ```
4. **Link Database & Deploy:**
   ```bash
   railway add --database mysql
   railway up
   ```

---

## ⚡ Opsional: Menjalankan Seeder Data Awal

Jika ingin mengisikan data awal (Seeder) ke dalam database:
1. Buka Web Service Anda di Railway.
2. Masuk ke tab **Terminal** / CLI.
3. Jalankan:
   ```bash
   php artisan db:seed --force
   ```
