<?php
require_once __DIR__.'/includes/config.php';
$page_active = 'home';
$page_title  = 'Beranda';
include 'includes/header.php';

// beri id main untuk skip-link
echo "<main id=\"main\">";

// Tarik panduan dari DB untuk kartu dinamis
$panduan_list = [];
try {
    $panduan_list = $pdo->query("SELECT * FROM panduan WHERE aktif=1 ORDER BY urutan ASC")->fetchAll();
} catch (Exception $e) {}
?>

<!-- ━━━ HERO ━━━ -->
<section class="hero fade-up stagger-1" aria-labelledby="hero-title" role="region">
  <div class="hero-img">
    <img src="images/pict1_icon.png" alt="Panduan Layanan">
  </div>
  <div class="hero-text">
    <h1 id="hero-title">Panduan Layanan untuk<br><span>Perlindungan Anda</span></h1>
    <p>Halaman ini hadir untuk memberikan informasi yang jelas dan mudah dipahami mengenai langkah-langkah yang dapat Anda ambil untuk mendapatkan perlindungan dan bantuan.</p>
    <div class="hero-cta">
      <button id="heroEmergency" class="btn-cta btn-cta-red" aria-label="Kontak Darurat">
        <span style="font-size:18px;">🚨</span> Kontak Darurat
      </button>
    </div>
  </div>
</section>

<!-- ━━━ DISCLAIMER ━━━ -->
<div style="padding:24px 24px 0;">
  <div class="disclaimer-bar">
    <div class="db-icon">⚠️</div>
    <p><strong>Perhatian:</strong> Sistem ini bersifat informatif dan edukatif semata. Sistem ini tidak menyimpan data pribadi dan tidak memproses laporan resmi. Untuk melaporkan kasus, silakan kunjungi aplikasi BEBUNGE pada fitur Lapor PPA</p>
  </div>
</div>

<!-- ━━━ BEBUNGE INFO ━━━ -->
<div class="section-alt">
  <div class="section-inner">
    <div class="info-box green">
      <div class="ib-icon">📱</div>
      <div>
        <p><strong>Aplikasi BEBUNGE:</strong> <?php echo BEBUNGE_DESC; ?>
        <br><a href="<?php echo htmlspecialchars(BEBUNGE_URL); ?>" target="_blank" rel="noopener" class="btn-cta btn-cta-green" style="margin-top:12px;display:inline-block;">Buka Aplikasi / Tautan BEBUNGE</a></p>
      </div>
    </div>
  </div>
</div>

<!-- ━━━ PILLAR CARDS ━━━ -->
<section class="section">
  <div class="section-inner">
    <h2 class="section-title">Pilih Panduan yang Anda Butuhkan</h2>
    <p class="section-sub">Setiap panduan disusun untuk membantu Anda memahami proses dan hak-hak yang dimiliki secara langkah demi langkah.</p>

    <div class="cards-grid">
      <!-- Card 1: Pelaporan -->
      <a href="panduan.php?slug=pelaporan" class="card fade-up stagger-1" aria-label="Buka panduan Pelaporan ke Lapor PPA">
        <img class="card-icon" src="images/book_icon.jpg" alt="Panduan Pelaporan">
        <div class="card-body">
          <h3>Panduan Pelaporan<br>ke Lapor PPA</h3>
          <p>Informasi lengkap mengenai tata cara, prosedur, dan langkah pertama dalam menyampaikan laporan.</p>
          <span class="card-link">Baca Panduan</span>
        </div>
      </a>

      <!-- Card 2: Psikolog -->
      <a href="panduan.php?slug=psikolog" class="card fade-up stagger-2" aria-label="Buka panduan Pendampingan Psikolog dan Psikiater">
        <img class="card-icon" src="images/psikologi_icon.png" alt="Pendampingan Psikolog">
        <div class="card-body">
          <h3>Pendampingan<br>Psikolog & Psikiater</h3>
          <p>Penjelasan tahapan dukungan kesehatan jiwa mulai dari asesmen hingga pendampingan berkelanjutan</p>
          <span class="card-link">Baca Panduan</span>
        </div>
      </a>

      <!-- Card 3: Bantuan Hukum -->
      <a href="panduan.php?slug=hukum" class="card fade-up stagger-3" aria-label="Buka panduan Bantuan Hukum">
        <img class="card-icon" src="images/hukum_icon.webp" alt="Bantuan Hukum">
        <div class="card-body">
          <h3>Panduan Bantuan<br>Hukum</h3>
          <p>Informasi mengenai hak-hak korban, cara mengakses bantuan hukum, dan prosedur penanganan.</p>
          <span class="card-link">Baca Panduan</span>
        </div>
      </a>

      <!-- Card 4: Dasar Hukum -->
      <a href="dasar-hukum.php" class="card fade-up stagger-2" aria-label="Buka halaman Dasar Hukum yang Berlaku">
        <img class="card-icon" src="images/dasar_hukum_icon.webp" alt="Dasar Hukum">
        <div class="card-body">
          <h3>Dasar Hukum yang<br>Berlaku</h3>
          <p>Referensi peraturan perundang-undangan yang menjadi landasan perlindungan korban di Indonesia.</p>
          <span class="card-link">Baca Panduan</span>
        </div>
      </a>
    </div>
  </div>
</section>

<?php
echo "</main>"; // tutup main
include 'includes/footer.php';
?>
