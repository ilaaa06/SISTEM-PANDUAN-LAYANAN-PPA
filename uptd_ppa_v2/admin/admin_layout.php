<?php
if (!isset($admin_page)) $admin_page = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title><?php echo isset($page_title)?htmlspecialchars($page_title).' — ':''; ?>Admin UPTD PPA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ━━━ ADMIN PANEL — Blue #36A9F0 theme ━━━ */
:root{
  --blue:#36A9F0;--blue-dark:#1E8FD5;--blue-light:#E8F4FD;--blue-mid:#C2E2F7;
  --red:#E93235;--red-dark:#C82A2D;--red-light:#FEF0F0;--red-border:#F5C0C1;
  --green:#3CB371;--green-dark:#2E9B5E;--green-light:#E8F7EE;
  --white:#FFF;--grey-50:#F7FAFC;--grey-100:#EDF2F7;--grey-200:#E2E8F0;
  --grey-400:#A0AEC0;--grey-600:#718096;--grey-800:#2D3748;--grey-900:#1A202C;
  --text:#2D3748;--text-mid:#4A5568;--text-light:#718096;
  --radius:10px;--shadow:0 2px 12px rgba(54,169,240,.08);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%}
body{font-family:'Outfit',system-ui,sans-serif;color:var(--text);background:var(--grey-50);display:flex;min-height:100vh;font-size:14px}

/* ── Sidebar ──*/
.sidebar{
  width:230px;flex-shrink:0;
  background:var(--blue);color:#fff;
  display:flex;flex-direction:column;
  min-height:100vh;position:sticky;top:0;height:100vh;overflow-y:auto;
}
.sidebar-logo{padding:20px 18px;border-bottom:1px solid rgba(255,255,255,.18);display:flex;align-items:center;gap:10px}
.sidebar-logo img{width:34px;height:34px;object-fit:contain;filter:drop-shadow(0 2px 4px rgba(0,0,0,.15))}
.sidebar-logo .sl-text{font-size:14px;font-weight:700;line-height:1.25}
.sidebar-logo .sl-text span{display:block;font-size:11px;font-weight:400;color:rgba(255,255,255,.65)}

.sidebar-nav{flex:1;padding:14px 10px}
.sidebar-nav .nav-section-label{font-size:10.5px;text-transform:uppercase;letter-spacing:1.2px;color:rgba(255,255,255,.4);padding:12px 12px 5px;font-weight:600}
.sidebar-nav a{
  display:flex;align-items:center;gap:10px;
  padding:10px 13px;border-radius:8px;
  color:rgba(255,255,255,.7);font-size:14px;font-weight:500;
  text-decoration:none;transition:background .2s,color .2s;margin-bottom:2px;
}
.sidebar-nav a:hover{background:rgba(255,255,255,.12);color:#fff}
.sidebar-nav a.active{background:rgba(255,255,255,.22);color:#fff;font-weight:600}
.sidebar-nav a .sn-icon{font-size:17px;flex-shrink:0;width:20px;text-align:center}

.sidebar-bottom{padding:14px 10px;border-top:1px solid rgba(255,255,255,.18)}
.sidebar-bottom a{display:flex;align-items:center;gap:10px;padding:10px 13px;border-radius:8px;color:rgba(255,255,255,.6);font-size:13px;text-decoration:none;transition:background .2s,color .2s}
.sidebar-bottom a:hover{background:rgba(255,255,255,.12);color:#fff}

/* ── Main wrap ──*/
.main-wrap{flex:1;display:flex;flex-direction:column;min-width:0}

/* ── Topbar ──*/
.topbar{
  background:#fff;border-bottom:1px solid var(--grey-200);
  padding:0 24px;height:54px;
  display:flex;align-items:center;justify-content:space-between;
  flex-shrink:0;box-shadow:0 1px 4px rgba(0,0,0,.05);
}
.topbar .tb-left{font-size:15px;font-weight:700;color:var(--blue-dark)}
.topbar .tb-left span{font-size:13px;font-weight:400;color:var(--text-light);margin-left:10px}
.topbar .tb-right{display:flex;align-items:center;gap:16px}
.topbar .tb-user{font-size:13px;color:var(--text-mid)}
.topbar .tb-user strong{color:var(--grey-900)}
.topbar .btn-logout{
  background:none;border:1.5px solid var(--grey-200);
  padding:6px 14px;border-radius:8px;font-size:13px;
  color:var(--text-mid);cursor:pointer;font-family:inherit;
  transition:border-color .2s,color .2s;
}
.topbar .btn-logout:hover{border-color:var(--red);color:var(--red)}

/* ── Content area ──*/
.content-area{flex:1;padding:24px;overflow-y:auto}

/* ── Stats grid ──*/
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-bottom:24px}
.stat-card{background:#fff;border-radius:var(--radius);padding:20px 18px;box-shadow:var(--shadow);border:1px solid var(--grey-200);display:flex;gap:14px;align-items:center}
.stat-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
.stat-icon.blue{background:var(--blue-light)} .stat-icon.green{background:var(--green-light)} .stat-icon.red{background:var(--red-light)} .stat-icon.grey{background:var(--grey-100)}
.stat-card .sc-num{font-size:22px;font-weight:700;color:var(--grey-900);line-height:1}
.stat-card .sc-label{font-size:12px;color:var(--text-light);margin-top:3px}

/* ── Quick links ──*/
.quick-links{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:12px}
.quick-link{background:#fff;border:1px solid var(--grey-200);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;text-decoration:none;color:inherit;box-shadow:var(--shadow);transition:transform .2s,box-shadow .2s}
.quick-link:hover{transform:translateY(-2px);box-shadow:0 4px 14px rgba(54,169,240,.12)}
.quick-link .ql-icon{font-size:22px}
.quick-link .ql-text{font-size:14px;font-weight:600;color:var(--grey-900)}
.quick-link .ql-sub{font-size:12px;color:var(--text-light)}

/* ── CRUD header ──*/
.crud-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px}
.crud-header h2{font-family:'DM Serif Display',serif;font-size:21px;font-weight:400;color:var(--grey-900)}
.btn-add{
  background:var(--blue);color:#fff;border:none;
  padding:9px 20px;border-radius:8px;font-size:14px;font-weight:600;
  cursor:pointer;font-family:inherit;text-decoration:none;
  display:inline-flex;align-items:center;gap:6px;transition:background .2s;
}
.btn-add:hover{background:var(--blue-dark)}

/* ── CRUD table ──*/
.crud-table-wrap{background:#fff;border-radius:var(--radius);border:1px solid var(--grey-200);box-shadow:var(--shadow);overflow:hidden}
.crud-table{width:100%;border-collapse:collapse}
.crud-table th{background:var(--grey-50);padding:11px 14px;text-align:left;font-size:11.5px;font-weight:600;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--grey-200)}
.crud-table td{padding:12px 14px;border-bottom:1px solid var(--grey-200);font-size:14px;vertical-align:middle}
.crud-table tr:last-child td{border-bottom:none}
.crud-table tr:hover td{background:var(--blue-light)}
.td-actions{display:flex;gap:6px}
.btn-edit,.btn-delete{
  background:none;border:1.5px solid var(--grey-200);
  padding:5px 11px;border-radius:6px;font-size:13px;
  cursor:pointer;font-family:inherit;transition:.2s;
  text-decoration:none;display:inline-flex;align-items:center;gap:4px;
}
.btn-edit{color:var(--blue-dark)} .btn-edit:hover{border-color:var(--blue);background:var(--blue-light)}
.btn-delete{color:var(--red)} .btn-delete:hover{border-color:var(--red);background:var(--red-light)}

/* Badges */
.badge{padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600}
.badge-aktif{background:var(--green-light);color:var(--green-dark)}
.badge-nonaktif{background:var(--grey-100);color:var(--text-light)}
.badge-urgent{background:var(--red-light);color:var(--red)}
.badge-kat{background:var(--blue-light);color:var(--blue-dark)}

/* ── Form ──*/
.form-wrap{background:#fff;border-radius:var(--radius);border:1px solid var(--grey-200);box-shadow:var(--shadow);padding:24px;max-width:760px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:5px}
/* Inline label for checkbox inputs to keep checkbox and text aligned */
.label-inline{display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-weight:600}
.label-inline input[type="checkbox"]{width:18px;height:18px;margin:0;flex:0 0 18px;accent-color:var(--blue-dark)}
.form-group input,.form-group select,.form-group textarea{
  width:100%;padding:11px 14px;border-radius:8px;
  border:1.5px solid var(--grey-200);font-size:14px;
  font-family:inherit;color:var(--text);background:var(--grey-50);
  transition:border-color .2s;
}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--blue);background:#fff}
.form-group textarea{min-height:130px;resize:vertical}
.form-group .fg-note{font-size:12px;color:var(--text-light);margin-top:4px}
.form-row{display:flex;gap:14px;flex-wrap:wrap}
.form-row.align-center{align-items:flex-end}
.form-row .form-group{flex:1;min-width:140px}

.form-actions{display:flex;gap:10px;margin-top:22px;flex-wrap:wrap}
.btn-save{background:var(--blue);color:#fff;border:none;padding:10px 22px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .2s}
.btn-save:hover{background:var(--blue-dark)}
.btn-cancel{background:none;border:1.5px solid var(--grey-200);padding:10px 22px;border-radius:8px;font-size:14px;color:var(--text-mid);cursor:pointer;font-family:inherit;text-decoration:none;transition:border-color .2s}
.btn-cancel:hover{border-color:var(--text-mid)}

/* ── Alerts ──*/
.alert-success{background:var(--green-light);border:1px solid #A8E6C3;border-radius:var(--radius);padding:13px 18px;font-size:14px;color:#1E5631;margin-bottom:18px;display:flex;gap:8px;align-items:center}
.alert-error{background:var(--red-light);border:1px solid var(--red-border);border-radius:var(--radius);padding:13px 18px;font-size:14px;color:#7A2828;margin-bottom:18px;display:flex;gap:8px;align-items:center}

.info-note{background:var(--blue-light);border:1px solid var(--blue-mid);border-radius:var(--radius);padding:13px 16px;font-size:13.5px;color:#1A5276;margin-bottom:16px}

/* ── Responsive ──*/
@media(max-width:700px){
  body{flex-direction:column}
  /* Hide full sidebar on small screens to avoid pushing content down.
     A compact hamburger menu will be used instead. */
  .sidebar{display:none}
  .content-area{padding:16px}
  .topbar{padding:0 14px}
  /* Show admin menu toggle in topbar */
  .admin-toggle{display:inline-flex;background:none;border:1.5px solid var(--grey-200);padding:8px 10px;border-radius:8px;align-items:center;gap:8px;cursor:pointer}
  .admin-toggle .at-bars{font-size:18px}
}

/* Mobile admin menu overlay */
.admin-mobile-menu{display:none;position:fixed;inset:0;z-index:120;background:rgba(0,0,0,.45);align-items:flex-start;justify-content:flex-start}
.admin-mobile-menu.open{display:flex}
.admin-mobile-menu .amm-panel{background:#fff;width:280px;max-width:84%;height:100%;padding:18px 16px;box-shadow:0 10px 30px rgba(0,0,0,.24);overflow:auto}
.admin-mobile-menu .amm-close{background:none;border:none;font-size:20px;position:absolute;right:10px;top:10px;cursor:pointer}
.admin-mobile-menu .amm-links{margin-top:8px;display:flex;flex-direction:column;gap:6px}
.admin-mobile-menu .amm-links a{padding:10px 12px;border-radius:8px;background:transparent;color:var(--grey-900);text-decoration:none;border:1px solid var(--grey-100)}
.admin-mobile-menu .amm-links a.active{background:var(--blue-light);border-color:var(--blue-mid);font-weight:700}
</style>
</head>
<body>

<!-- ━━━ SIDEBAR ━━━ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="../images/logo_ppa.jpg" alt="Logo">
    <div class="sl-text">Admin Panel<span>UPTD PPA</span></div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section-label">Utama</div>
    <a href="dashboard.php" class="<?php echo $admin_page==='dashboard'?'active':''; ?>"><span class="sn-icon">📊</span> Dashboard</a>
    <div class="nav-section-label">Kelola Konten</div>
    <a href="panduan.php"     class="<?php echo $admin_page==='panduan'?'active':''; ?>"><span class="sn-icon">📋</span> Panduan Layanan</a>
    <a href="dasar-hukum.php" class="<?php echo $admin_page==='dasar'?'active':''; ?>"><span class="sn-icon">📚</span> Dasar Hukum</a>
    <a href="faq.php"         class="<?php echo $admin_page==='faq'?'active':''; ?>"><span class="sn-icon">❓</span> FAQ</a>
    <a href="kontak.php"      class="<?php echo $admin_page==='kontak'?'active':''; ?>"><span class="sn-icon">📞</span> Kontak Darurat</a>
  </nav>
  <div class="sidebar-bottom">
    <a href="../index.php" target="_blank"><span class="sn-icon">🌐</span> Lihat Website Publik</a>
  </div>
</aside>

<!-- ━━━ MAIN ━━━ -->
<div class="main-wrap">
  <header class="topbar">
    <div class="tb-left">
      <?php
        $titles=['dashboard'=>'Dashboard','panduan'=>'Kelola Panduan','dasar'=>'Kelola Dasar Hukum','faq'=>'Kelola FAQ','kontak'=>'Kelola Kontak Darurat'];
        echo $titles[$admin_page]??'Admin';
      ?><span>UPTD PPA</span>
    </div>
    <div class="tb-right">
      <div class="tb-user">Login sebagai <strong><?php echo htmlspecialchars($_SESSION['admin_nama']??'Admin'); ?></strong></div>
      <a href="logout.php" class="btn-logout">Logout</a>
    </div>
  </header>
  <!-- Mobile admin menu toggle and overlay -->
  <button id="adminToggle" class="admin-toggle" aria-label="Buka menu admin" title="Menu admin" style="display:none"> 
    <span class="at-bars">☰</span>
  </button>

  <div id="adminMobileMenu" class="admin-mobile-menu" aria-hidden="true">
    <div class="amm-panel" role="dialog" aria-label="Menu Admin">
      <button class="amm-close" id="ammClose" aria-label="Tutup menu">×</button>
      <nav class="amm-links">
        <a href="dashboard.php" class="<?php echo $admin_page==='dashboard'?'active':''; ?>">📊 Dashboard</a>
        <a href="panduan.php" class="<?php echo $admin_page==='panduan'?'active':''; ?>">📋 Panduan Layanan</a>
        <a href="dasar-hukum.php" class="<?php echo $admin_page==='dasar'?'active':''; ?>">📚 Dasar Hukum</a>
        <a href="faq.php" class="<?php echo $admin_page==='faq'?'active':''; ?>">❓ FAQ</a>
        <a href="kontak.php" class="<?php echo $admin_page==='kontak'?'active':''; ?>">📞 Kontak Darurat</a>
        <a href="../index.php" target="_blank">🌐 Lihat Website Publik</a>
      </nav>
    </div>
  </div>

  <script>
  (function(){
    function qs(sel){return document.querySelector(sel)}
    document.addEventListener('DOMContentLoaded', function(){
      var toggle = qs('#adminToggle');
      var menu = qs('#adminMobileMenu');
      var closeBtn = qs('#ammClose');
      // Show toggle only on small screens (keeps markup safe on desktop)
      function updateToggleVisibility(){ if(window.innerWidth<=700){ toggle.style.display='inline-flex'; } else { toggle.style.display='none'; menu.classList.remove('open'); menu.setAttribute('aria-hidden','true'); }}
      updateToggleVisibility(); window.addEventListener('resize', updateToggleVisibility);
      toggle.addEventListener('click', function(e){ menu.classList.add('open'); menu.setAttribute('aria-hidden','false'); });
      closeBtn.addEventListener('click', function(e){ menu.classList.remove('open'); menu.setAttribute('aria-hidden','true'); });
      // click outside panel to close
      menu.addEventListener('click', function(e){ if(e.target===menu) { menu.classList.remove('open'); menu.setAttribute('aria-hidden','true'); } });
      // Escape to close
      document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ menu.classList.remove('open'); menu.setAttribute('aria-hidden','true'); } });
    });
  })();
  </script>
  <div class="content-area">
<!-- ▼▼▼ Setiap halaman admin inject konten di sini ▼▼▼ -->
