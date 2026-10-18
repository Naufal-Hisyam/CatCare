# Anggota 4 — Proses Penitipan, Pembayaran, dan Riwayat

Alur: menunggu -> disetujui / ditolak -> aktif (kucing masuk) -> keluar aktual -> bayar tunai -> selesai.

File baru:
- app/Http/Controllers/Admin/{PenitipanController,PembayaranController,RiwayatController}.php
- app/Http/Controllers/Pelanggan/PenitipanSayaController.php
- app/Support/Format.php
- database/migrations/2026_10_18_100000_add_proses_penitipan_to_penitipan_table.php
- resources/views/layouts/panel.blade.php, partials/, admin/{penitipan,pembayaran,riwayat}/, pelanggan/penitipan/, vendor/pagination/catcare.blade.php
- resources/views/errors/{403,419,429,500,503,partial}.blade.php
- public/css/panel.css
- tests/Feature/ProsesPenitipanTest.php

File lama yang diubah (kecil):
- app/Models/Penitipan.php (tambah status, helper biaya, aturan transisi; relasi tetap)
- routes/web.php (blok routes Anggota 4 di bagian bawah)
- app/Http/Controllers/DashboardController.php (hitung pembayaran menunggu + label status)
- bootstrap/app.php (QueryException -> pesan ramah), config/app.php (timezone Asia/Jakarta)
- resources/views/errors/404.blade.php, dashboard/*, profile/edit, customers/index (link sidebar '#')
- tests/Feature/ExampleTest.php

Jalankan: composer install; cp .env.example .env; php artisan key:generate;
touch database/database.sqlite; php artisan migrate; php artisan db:seed --class=AdminSeeder;
php artisan serve. Tes: php artisan test
