<?php
require_once 'includes/config.php';
$page_active = 'faq';
$page_title  = 'FAQ';

$faq_rows = [];
try {
    $faq_rows = $pdo->query("SELECT * FROM faq WHERE aktif=1 ORDER BY kategori ASC, urutan ASC")->fetchAll();
} catch (Exception $e) {}

// Kelompokkan per kategori
$faq_grouped = [];
foreach ($faq_rows as $f) {
    $kat = $f['kategori'] ?? 'Umum';
    $faq_grouped[$kat][] = $f;
}

include 'includes/header.php';
?>

<!-- ━━━ PAGE HEADER ━━━ -->
<div class="page-header">
  <div class="page-header-inner">
    <div style="font-size:42px;margin-bottom:10px;">❓</div>
    <h1>Pertanyaan yang Sering Diajukan</h1>
    <p>Temukan jawaban atas pertanyaan umum seputar layanan UPTD PPA</p>
  </div>
</div>

<!-- ━━━ KONTEN ━━━ -->
<section class="section">
  <div class="section-inner" style="max-width:780px;">

    <div class="info-box">
      <div class="ib-icon">💙</div>
      <p><strong>Tidak menemukan jawaban yang Anda cari?</strong> Jangan ragu untuk menghubungi UPTD PPA secara langsung. Tim kami siap membantu Anda.</p>
    </div>

    <?php if (empty($faq_grouped)): ?>
      <p style="color:var(--text-mid);text-align:center;padding:36px 0;font-size:15px;">FAQ sedang disiapkan. Silakan hubungi UPTD PPA untuk pertanyaan Anda.</p>
    <?php else: ?>

      <?php foreach ($faq_grouped as $kategori => $items): ?>
        <h2 class="section-title" style="margin-top:36px;text-align:left;font-size:19px;">📂 <?php echo htmlspecialchars($kategori); ?></h2>

        <div class="accordion">
          <?php foreach ($items as $idx => $f): ?>
          <div class="acc-item <?php echo $idx===0?'open':''; ?>">
            <button class="acc-trigger" onclick="toggleAcc(this)">
              <span class="at-icon">❓</span>
              <span class="at-text"><?php echo htmlspecialchars($f['pertanyaan']); ?></span>
              <span class="at-arrow">▼</span>
            </button>
            <div class="acc-body"><div class="acc-body-inner">
              <p><?php echo htmlspecialchars($f['jawaban']); ?></p>
            </div></div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

    <?php endif; ?>

    <div class="info-box green" style="margin-top:32px;">
      <div class="ib-icon">📞</div>
      <p>Untuk pertanyaan yang tidak tercantum, silakan hubungi UPTD PPA melalui <a href="#" onclick="document.getElementById('modalDarurat').classList.add('open');return false;" style="color:var(--blue-dark);font-weight:700;">nomor kontak darurat</a> atau kunjungi kantor UPTD PPA terdekat.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
