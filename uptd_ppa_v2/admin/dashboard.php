<?php
require_once __DIR__.'/../includes/config.php';
require_once 'auth.php';
$admin_page='dashboard'; $page_title='Dashboard';
include 'admin_layout.php';

$c=['p'=>0,'d'=>0,'f'=>0,'k'=>0];
try{
  $c['p']=$pdo->query("SELECT COUNT(*) FROM panduan WHERE aktif=1")->fetchColumn();
  $c['d']=$pdo->query("SELECT COUNT(*) FROM dasar_hukum WHERE aktif=1")->fetchColumn();
  $c['f']=$pdo->query("SELECT COUNT(*) FROM faq WHERE aktif=1")->fetchColumn();
  $c['k']=$pdo->query("SELECT COUNT(*) FROM kontak_darurat WHERE aktif=1")->fetchColumn();
}catch(Exception $e){}
?>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card"><div class="stat-icon blue">📋</div><div><div class="sc-num"><?php echo $c['p']; ?></div><div class="sc-label">Panduan Layanan</div></div></div>
  <div class="stat-card"><div class="stat-icon green">📚</div><div><div class="sc-num"><?php echo $c['d']; ?></div><div class="sc-label">Dasar Hukum</div></div></div>
  <div class="stat-card"><div class="stat-icon red">❓</div><div><div class="sc-num"><?php echo $c['f']; ?></div><div class="sc-label">FAQ</div></div></div>
  <div class="stat-card"><div class="stat-icon grey">📞</div><div><div class="sc-num"><?php echo $c['k']; ?></div><div class="sc-label">Kontak Darurat</div></div></div>
</div>



<!-- Welcome -->
<div style="margin-top:24px;background:#fff;border-radius:10px;border:1px solid var(--grey-200);padding:20px 22px;box-shadow:var(--shadow);">
  <p style="font-size:14px;color:var(--text-mid);line-height:1.7;">
    <strong style="color:var(--grey-900);">Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama']??'Admin'); ?>.</strong><br>
    Gunakan panel ini untuk mengelola konten website Panduan Layanan UPTD PPA. Perubahan yang Anda simpan akan langsung tercermin di website publik.
  </p>
</div>

  </div><!-- end content-area --></div><!-- end main-wrap --></body></html>
