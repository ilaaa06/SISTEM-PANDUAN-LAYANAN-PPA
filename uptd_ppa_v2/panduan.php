<?php
require_once 'includes/config.php';

$slug = isset($_GET['slug']) ? preg_replace('/[^a-z0-9\-]/','',strtolower(trim($_GET['slug']))) : '';

$panduan = null;
if ($slug !== '') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM panduan WHERE slug=? AND aktif=1 LIMIT 1");
        $stmt->execute([$slug]);
        $panduan = $stmt->fetch();
    } catch (Exception $e) {}
}
if (!$panduan) { header('Location: index.php'); exit; }

$page_active = $panduan['slug'];
$page_title  = $panduan['judul'];

// Icon per slug untuk page header - pakai emoji karena file image tidak valid
$icon_emoji = ['pelaporan'=>'📋','psikolog'=>'💭','hukum'=>'⚖️'];
$ph_emoji = $icon_emoji[$panduan['slug']] ?? '💙';

include 'includes/header.php';
echo "<main id=\"main\">";
?>

<!-- ━━━ PAGE HEADER ━━━ -->
<div class="page-header fade-up" role="region">
  <div class="page-header-inner">
    <div class="ph-icon" style="font-size:40px;margin:0 auto 14px;"><?php echo $ph_emoji; ?></div>
    <h1><?php echo htmlspecialchars($panduan['judul']); ?></h1>
    <?php if ($panduan['deskripsi']): ?>
      <p><?php echo htmlspecialchars($panduan['deskripsi']); ?></p>
    <?php endif; ?>

    <!-- actions removed: printing/saving disabled per request -->
  </div>
</div>

<!-- ━━━ KONTEN ━━━ -->
<section class="section">
  <div class="section-inner" style="max-width:780px;">
    <div class="info-box">
      <div class="ib-icon">💙</div>
      <p><strong>Kami memahami bahwa langkah ini bukanlah hal yang mudah.</strong> Halaman ini hadir agar Anda dapat memahami prosesnya secara menyeluruh — tanpa tekanan, dan sesuai dengan kesiapan Anda.</p>
    </div>

    <div class="panduan-konten" style="margin-top:28px;">
      <?php echo $panduan['konten']; ?>
    </div>

    <div class="info-box warn" style="margin-top:32px;">
      <div class="ib-icon">📌</div>
      <p><strong>Catatan penting:</strong> Halaman ini hanya menyajikan panduan umum. Prosedur spesifik dapat bervariasi sesuai kebijakan UPTD PPA di daerah Anda. Silakan hubungi UPTD PPA setempat untuk informasi lebih lanjut.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php echo "</main>"; ?>
