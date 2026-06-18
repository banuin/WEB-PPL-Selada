# Banu In Selada - Sistem Pemesanan Selada Hidroponik 🥬

Sistem Informasi Pemesanan Selada Hidroponik berbasis Web yang dirancang khusus untuk mempermudah pelanggan dalam memesan selada segar dan membantu admin dalam mengelola katalog produk, konten edukasi (artikel), data pelanggan, serta pemrosesan transaksi pemesanan secara efisien.

---

## 🚀 Fitur Utama

### 🧑‍💼 Sisi Pelanggan (Customer)
* **Katalog Produk Interaktif:** Menjelajahi berbagai pilihan selada hidroponik segar dengan detail harga, deskripsi, dan stok yang selalu *up-to-date*.
* **Sistem Pemesanan & Kalkulasi Pintar:** Memesan selada dengan menentukan jumlah bungkus dan berat paket (per 100gr, 500gr, 1kg, dsb.) dengan perhitungan otomatis.
* **Pembatalan Pesanan Instan:** Pelanggan dapat membatalkan pesanan langsung dari halaman detail pemesanan selama statusnya masih **Menunggu Verifikasi** atau **Menunggu Konfirmasi**.
* **Keamanan Stok:** Stok selada yang dipesan akan otomatis dikembalikan ke katalog jika pelanggan membatalkan pesanan mereka sebelum diproses.
* **Kelola Profil & Alamat:** Memperbarui data diri, kecamatan, serta detail alamat pengiriman untuk akurasi pengiriman.
* **Artikel Edukatif:** Membaca artikel informasi dan tips seputar gaya hidup sehat dan pertanian hidroponik.
* **Lupa Password via OTP:** Pemulihan akun menggunakan kode OTP (One-Time Password) yang aman.

### 👑 Sisi Admin (Administrator)
* **Dashboard Ringkasan:** Memantau ringkasan statistik operasional toko selada.
* **Kelola Katalog & Stok (CRUD):** Menambah, mengubah, menampilkan, dan menghapus produk selada.
* **Kelola Artikel (CRUD):** Mempublikasikan tips kesehatan atau panduan hidroponik baru.
* **Kelola Pelanggan:** Melihat data detail pelanggan serta menghapus akun yang tidak aktif atau melanggar ketentuan.
* **Kelola Transaksi Pemesanan:**
  * Memproses status pembayaran dan pengiriman secara bertahap (Menunggu Konfirmasi ➡️ Diproses ➡️ Dikirim ➡️ Selesai).
  * Membatalkan pesanan pelanggan dengan sistem pengembalian stok yang cerdas.
* **Sistem Laporan:** Menghasilkan laporan transaksi pemesanan untuk evaluasi performa bisnis.

---

## 🛠️ Stack Teknologi
* **Framework Backend:** Laravel (PHP)
* **Frontend:** Blade Templating, Tailwind CSS, Alpine.js (untuk interaksi dinamis & modal pop-up)
* **Database:** MySQL
* **Build Tool:** Vite

---

## 📦 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### Prasyarat
* PHP >= 8.2
* Composer
* Node.js & NPM
* Laragon, XAMPP, atau server lokal sejenis

### Langkah-Langkah

1. **Clone Repositori**
   ```bash
   git clone https://github.com/banuin/WEB-PPL-Selada.git
   cd WEB-PPL-Selada
   ```

2. **Instal Dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend (NPM)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` lalu sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding (Opsional)**
   Jalankan migrasi untuk membuat tabel-tabel di database:
   ```bash
   php artisan migrate
   ```

7. **Hubungkan Storage Link**
   Untuk menampilkan gambar katalog produk atau bukti pembayaran:
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Aplikasi**
   Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
   Di terminal baru, jalankan Vite untuk aset frontend:
   ```bash
   npm run dev
   ```
   Buka browser dan akses alamat `http://127.0.0.1:8000`.

---

## 🛡️ Alur Pembatalan & Pengembalian Stok
Sistem ini mengimplementasikan aturan bisnis yang ketat dalam pembatalan pesanan untuk menjaga kesegaran selada hidroponik:
* **Pengembalian Stok Otomatis:** Jika pesanan dibatalkan saat status masih **Menunggu Verifikasi** atau **Menunggu Konfirmasi**, stok akan dikembalikan secara utuh ke katalog dengan perhitungan berat paket yang dipesan.
* **Kebijakan Pembatalan setelah "Dikirim":** Apabila pesanan dibatalkan oleh Admin setelah produk masuk status **Dikirim**, sistem **tidak akan** mengembalikan stok ke katalog. Hal ini dilakukan karena selada yang telah dikirim rawan layu/busuk di perjalanan sehingga tidak dapat dimasukkan kembali ke stok siap jual.
