<?php
$kontak_rows = [];
try {
    $stmt = $pdo->query("SELECT * FROM kontak_darurat WHERE aktif = 1 ORDER BY urutan ASC");
    $kontak_rows = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- ━━━ FOOTER ━━━ -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-grid" style="display:flex;justify-content:space-between;align-items:flex-start;gap:20px;">
      <div style="flex:1;min-width:220px;">
        <h5>Panduan Layanan UPTD PPA</h5>
        <p>Sistem informasi ini bersifat informatif dan edukatif. Tidak menyimpan data pribadi dan tidak memproses laporan resmi. Dikembangkan oleh Diskominfo sebagai media panduan layanan perlindungan perempuan dan anak.</p>
      </div>
      <div id="footer-contact" style="flex:1;min-width:220px;text-align:right;">
        <h5>Kontak</h5>
        <p style="margin:6px 0;color:var(--text);">Email: csirt@bekasikab.go.id</p>
        <p style="margin:6px 0;color:var(--text);">Address: Kantor Diskominfosantik Kab. Bekasi Komplek Perkantoran Pemkab Bekasi Ds. Sukamahi Kec. Cikarang Pusat Kab. Bekasi</p>
      </div>
    </div>
    <div class="footer-bottom">
      © 2026 Sistem Informasi Panduan Layanan UPTD PPA<br>
      — Draft Magang. Sistem ini bersifat informatif semata.
    </div>
  </div>
</footer>

<!-- ━━━ MODAL DARURAT ━━━ -->
<div class="modal-overlay" id="modalDarurat" role="dialog" aria-modal="true" aria-labelledby="modalDaruratTitle" aria-hidden="true">
  <div class="modal" role="document">
    <button class="modal-close" id="modalCloseBtn" aria-label="Tutup dialog">✕</button>
    <div style="text-align:center;margin-bottom:8px;"><img src="images/sirine_icon.png" alt="Ikon sirene" style="width:44px;height:44px;object-fit:contain;"></div>
    <h3 id="modalDaruratTitle" style="text-align:center;">Bantuan Darurat</h3>
    <p class="m-sub" style="text-align:center;">Nomor berikut dapat dihubungi kapan saja untuk mendapatkan bantuan.</p>

    <?php if (empty($kontak_rows)): ?>
      <p style="text-align:center;color:#718096;font-size:14px;padding:16px 0;">Nomor kontak sedang disiapkan. Silakan hubungi layanan bantuan langsung.</p>
    <?php else: ?>
      <?php foreach ($kontak_rows as $i => $k): ?>
          <?php if ($i > 0): ?><hr class="modal-divider"><?php endif; ?>
          <div class="modal-num">
            <div class="mn-label"><?php echo htmlspecialchars($k['nama']); ?></div>
            <?php
              // Siapkan versi untuk link tel: (hapus karakter yang bukan angka atau +)
              $tel_link = preg_replace('/[^0-9+]/', '', $k['nomor']);
            ?>
            <div class="mn-val <?php echo $k['is_utama']?'red':''; ?>">
              <a href="tel:<?php echo htmlspecialchars($tel_link); ?>" style="color:inherit;text-decoration:none;">
                <?php echo htmlspecialchars($k['nomor']); ?>
              </a>
            </div>
            <?php if ($k['keterangan']): ?><div class="mn-note"><?php echo htmlspecialchars($k['keterangan']); ?></div><?php endif; ?>
          </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <p style="text-align:center;font-size:12px;color:#718096;margin-top:18px;">
      Verifikasi nomor terkini di daerah Anda.
    </p>
  </div>
</div>

<!-- ━━━ BASE JS ━━━ -->
<script>
window.addEventListener('scroll',function(){
  var n = document.getElementById('navbar'); if(n) n.classList.toggle('scrolled',window.scrollY>40);
});
function toggleAcc(trigger){
  var item=trigger.closest('.acc-item');
  item.parentElement.querySelectorAll('.acc-item').forEach(function(i){if(i!==item)i.classList.remove('open');});
  item.classList.toggle('open');
}
</script>
<script>
// Modal open/close handling for Darurat modal
(function(){
  var overlay = document.getElementById('modalDarurat');
  if(!overlay) return;
  var closeBtn = document.getElementById('modalCloseBtn');
  function openModal(){ overlay.classList.add('open'); document.body.style.overflow='hidden'; }
  function closeModal(){ overlay.classList.remove('open'); document.body.style.overflow=''; }
  // bind close button
  if(closeBtn) closeBtn.addEventListener('click', closeModal);
  // close when clicking outside modal
  overlay.addEventListener('click', function(e){ if(e.target === overlay) closeModal(); });
  // close on ESC
  document.addEventListener('keydown', function(e){ if(e.key==='Escape' && overlay.classList.contains('open')) closeModal(); });
  // Bind hero Emergency button if present
  var heroBtn = document.getElementById('heroEmergency');
  if(heroBtn) heroBtn.addEventListener('click', function(){ openModal(); });
  // Expose utility for other elements (mobile menu already uses direct add of 'open')
  window.openDaruratModal = openModal;
})();
</script>
</body>
</html>
