<?php
require_once 'includes/config.php';
$page_active = 'dasar';
$page_title  = 'Dasar Hukum yang Berlaku';

$dasar_hukum = [];
try {
    $dasar_hukum = $pdo->query("SELECT * FROM dasar_hukum WHERE aktif=1 ORDER BY urutan ASC")->fetchAll();
} catch (Exception $e) {}

include 'includes/header.php';
?>

<!-- ━━━ PAGE HEADER ━━━ -->
<div class="page-header">
  <div class="page-header-inner">
    <div class="ph-icon" style="font-size:40px;margin:0 auto 14px;">⚖️</div>
    <h1>Dasar Hukum yang Berlaku</h1>
    <p>Referensi peraturan perundang-undangan yang menjadi landasan perlindungan korban</p>
  </div>
</div>

<!-- ━━━ KONTEN ━━━ -->
<section class="section">
  <div class="section-inner" style="max-width:860px;">

    <div class="info-box">
      <div class="ib-icon">📖</div>
      <p>Halaman ini menyajikan <strong>ringkasan pokok materi</strong> dari peraturan perundang-undangan yang relevan. Untuk teks lengkap, silakan merujuk pada situs resmi perundangan pemerintah atau menghubungi petugas UPTD PPA.</p>
    </div>

    <!-- Tabel Peraturan -->
    <h2 class="section-title" style="margin-top:36px;text-align:left;font-size:20px;">Peraturan Perundang-Undangan</h2>

    <?php if (!empty($dasar_hukum)): ?>
    <table class="legal-table">
      <thead>
        <tr>
          <th style="width:44px;">#</th>
          <th style="width:40%;">Peraturan</th>
          <th>Pokok Materi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dasar_hukum as $i => $dh): ?>
        <tr>
          <td class="td-num"><?php echo $i+1; ?></td>
          <td class="td-title">
            <?php echo htmlspecialchars($dh['nama_uu']); ?>
            <br><span style="font-weight:400;color:var(--text-mid);font-size:13px;"><?php echo htmlspecialchars($dh['tentang']); ?></span>
          </td>
          <td><?php echo htmlspecialchars($dh['ringkasan']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p style="color:var(--text-mid);padding:20px 0;">Data dasar hukum sedang disiapkan.</p>
    <?php endif; ?>

    <!-- Ringkasan Hak Korban -->
    <h2 class="section-title" style="margin-top:40px;text-align:left;font-size:20px;">Ringkasan Hak Korban</h2>
    <p style="color:var(--text-mid);font-size:14.5px;margin-bottom:4px;">Berdasarkan peraturan perundang-undangan yang berlaku, berikut adalah hak-hak utama korban.</p>

    <div class="accordion">
      <div class="acc-item open">
        <button class="acc-trigger" onclick="toggleAcc(this)">
          <span class="at-icon">✅</span>
          <span class="at-text">Hak atas Keamanan dan Perlindungan</span>
          <span class="at-arrow">▼</span>
        </button>
        <div class="acc-body"><div class="acc-body-inner">
          <p>Korban berhak mendapatkan perlindungan dari ancaman dan bahaya lebih lanjut. Negara berkewajiban untuk memastikan keselamatan korban melalui langkah-langkah yang dipandang perlu.</p>
        </div></div>
      </div>
      <div class="acc-item">
        <button class="acc-trigger" onclick="toggleAcc(this)">
          <span class="at-icon">✅</span>
          <span class="at-text">Hak atas Pelayanan Kesehatan dan Psikologis</span>
          <span class="at-arrow">▼</span>
        </button>
        <div class="acc-body"><div class="acc-body-inner">
          <p>Korban berhak mendapatkan pelayanan kesehatan fisik dan mental. Layanan ini dapat berupa perawatan medis, konseling psikologis, dan terapi rehabilitatif.</p>
        </div></div>
      </div>
      <div class="acc-item">
        <button class="acc-trigger" onclick="toggleAcc(this)">
          <span class="at-icon">✅</span>
          <span class="at-text">Hak atas Keadilan dan Perlakuan yang Hormat</span>
          <span class="at-arrow">▼</span>
        </button>
        <div class="acc-body"><div class="acc-body-inner">
          <p>Korban berhak untuk diperlakukan dengan hormat dan bermartabat oleh semua pihak. Korban tidak boleh dipersalahkan atas kekerasan yang mereka alami.</p>
        </div></div>
      </div>
    </div>

    <!-- Disclaimer -->
    <div class="info-box warn" style="margin-top:28px;">
      <div class="ib-icon">⚠️</div>
      <p><strong>Pernyataan penyangkalan:</strong> Informasi hukum di halaman ini disusun berdasarkan peraturan yang berlaku dan bersifat panduan umum. Tidak dapat dijadikan dasar pengambilan keputusan hukum. Untuk konsultasi spesifik, hubungi lembaga bantuan hukum yang berwenang.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
