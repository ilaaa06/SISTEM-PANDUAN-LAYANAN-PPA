<?php
// ============================================================
// includes/config.php
// Konfigurasi aplikasi & koneksi database
// ============================================================

// ── Nama & Versi Aplikasi ──
define('APP_NAME',    'Sistem Informasi Panduan Layanan UPTD PPA');
define('APP_VERSION', '1.0.0');
define('APP_ENV',     'development'); // ganti ke 'production' saat deploy

// Link & informasi aplikasi BEBUNGE (sesuaikan jika ada URL resmi)
define('BEBUNGE_URL',  'https://play.google.com/store/search?q=bebunge&c=apps');
define('BEBUNGE_DESC', 'Aplikasi pelaporan terintegrasi untuk melaporkan kasus dan mendapatkan bantuan. Gunakan fitur "Lapor PPA" di aplikasi BEBUNGE untuk pelaporan resmi.');

// ── Konfigurasi Database ──
// !! Sesuaikan dengan kredensial server Anda !!
define('DB_HOST',     'localhost');
define('DB_NAME',     'uptd_ppa');
define('DB_USER',     'root');       // ganti sesuai user MySQL Anda
define('DB_PASS',     '');           // ganti sesuai password MySQL Anda
define('DB_CHARSET',  'utf8mb4');

// ── Koneksi PDO ──
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Di production, sembunyikan error detail
    if (APP_ENV === 'production') {
        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;
    }

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    if (APP_ENV === 'development') {
        die('<div style="font-family:sans-serif;padding:40px;background:#fef0f0;border:1px solid #f5bcba;border-radius:12px;max-width:600px;margin:60px auto;">
                <h3 style="color:#d9534f;">⚠️ Kesalahan Koneksi Database</h3>
                <p style="color:#8B4040;">' . htmlspecialchars($e->getMessage()) . '</p>
                <p style="color:#aaa;font-size:13px;">Pastikan database <strong>uptd_ppa</strong> sudah dibuat dan kredensial di config.php sudah disesuaikan.</p>
             </div>');
    } else {
        die('Sistem sedang dalam pemeliharaan. Silakan coba lagi nanti.');
    }
}
?>