<?php
if (!isset($page_active)) $page_active = 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo isset($page_title) ? htmlspecialchars($page_title).' — ' : ''; ?>Panduan Layanan UPTD PPA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Skip link for keyboard users -->
<a class="skip-link" href="#main">Lewati ke konten utama</a>

<!-- ━━━ NAVBAR ━━━ -->
<nav class="navbar" id="navbar" role="navigation" aria-label="Navigasi utama">
  <div class="nav-inner">
    <!-- Logo -->
    <a href="index.php" class="nav-logo">
      <img src="images/logo_ppa.jpg" alt="Logo PPA">
      <div class="nav-logo-text">
        <span class="lt-main">Panduan Layanan UPTD PPA</span>
        <span class="lt-sub">PERLINDUNGAN PEREMPUAN &amp; ANAK</span>
      </div>
    </a>

    <!-- Spacer -->
    <div style="flex:1;"></div>

    <!-- Desktop buttons -->
    <a href="faq.php" class="btn-faq">FAQ</a>
    <a href="admin/login.php" class="btn-faq" style="margin-left:8px;background:var(--green);">Login Admin</a>

    <!-- Mobile toggle -->
    <button class="nav-toggle" id="navToggle" aria-controls="mobileMenu" aria-expanded="false" aria-label="Buka menu" >
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- ━━━ MOBILE MENU ━━━ -->
<div class="mobile-menu" id="mobileMenu" role="menu" aria-hidden="true">
  <button class="mm-close" id="mmClose" aria-label="Tutup menu">✕</button>
  <a role="menuitem" href="index.php">🏠 Beranda</a>
  <a role="menuitem" href="panduan.php?slug=pelaporan">📋 Panduan Pelaporan</a>
  <a role="menuitem" href="panduan.php?slug=psikolog">💙 Pendampingan Psikolog</a>
  <a role="menuitem" href="panduan.php?slug=hukum">⚖️ Bantuan Hukum</a>
  <a role="menuitem" href="dasar-hukum.php">📚 Dasar Hukum</a>
  <a role="menuitem" href="faq.php">❓ FAQ</a>
  <a role="menuitem" href="admin/login.php">🔐 Login Admin</a>
  <button class="mm-emergency" id="mmEmergency" style="background:var(--red);margin-top:16px;" aria-label="Buka modal bantuan darurat">
    🚨 Bantuan Darurat
  </button>
</div>

<script>
// Accessible mobile menu toggling
(function(){
  var btn=document.getElementById('navToggle');
  var menu=document.getElementById('mobileMenu');
  var closeBtn=document.getElementById('mmClose');
  var mmEmergency=document.getElementById('mmEmergency');
  function openMenu(){menu.classList.add('open');btn.setAttribute('aria-expanded','true');menu.setAttribute('aria-hidden','false');
    // focus first link
    var f=menu.querySelector('[role="menuitem"]'); if(f) f.focus();
  }
  function closeMenu(){menu.classList.remove('open');btn.setAttribute('aria-expanded','false');menu.setAttribute('aria-hidden','true');btn.focus();}
  btn.addEventListener('click',function(){ if(menu.classList.contains('open')) closeMenu(); else openMenu(); });
  closeBtn.addEventListener('click',closeMenu);
  mmEmergency.addEventListener('click',function(){ closeMenu(); document.getElementById('modalDarurat').classList.add('open'); });
  // close on ESC
  document.addEventListener('keydown',function(e){ if(e.key==='Escape'){ if(menu.classList.contains('open')) closeMenu(); }});
})();
</script>

