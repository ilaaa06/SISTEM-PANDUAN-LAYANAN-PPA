<?php
session_start();
if (isset($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
require_once __DIR__.'/../includes/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $username = trim($_POST['username']??'');
    $password = $_POST['password']??'';
    if ($username===''||$password==='') {
        $error = 'Username dan password tidak boleh kosong.';
    } else {
        try {
            $stmt=$pdo->prepare("SELECT * FROM admin WHERE username=? LIMIT 1");
            $stmt->execute([$username]);
            $admin=$stmt->fetch();
            if ($admin && password_verify($password,$admin['password_hash'])) {
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_user'] = $admin['username'];
                $_SESSION['admin_nama'] = $admin['nama_lengkap'];
                header('Location: dashboard.php'); exit;
            } else {
                $error = 'Username atau password tidak valid.';
            }
        } catch (Exception $e) { $error = 'Kesalahan sistem.'; }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Login Admin — UPTD PPA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--blue:#36A9F0;--blue-dark:#1E8FD5;--red:#E93235;--red-light:#FEF0F0;--red-border:#F5C0C1;--grey-200:#E2E8F0;--grey-900:#1A202C;--text:#2D3748;--text-mid:#4A5568;--text-light:#718096}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Outfit',system-ui,sans-serif;min-height:100vh;display:flex;background:#fff}

/* Left panel */
.login-left{
  width:420px;min-height:100vh;flex-shrink:0;
  background:linear-gradient(160deg,var(--blue) 0%,var(--blue-dark) 100%);
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:60px 40px;position:relative;overflow:hidden;
}
.login-left::before{
  content:'';position:absolute;width:320px;height:320px;border-radius:50%;
  background:rgba(255,255,255,.07);top:-80px;right:-80px;
}
.login-left::after{
  content:'';position:absolute;width:220px;height:220px;border-radius:50%;
  background:rgba(255,255,255,.05);bottom:-60px;left:-40px;
}
.login-left .ll-logo{position:relative;z-index:1;text-align:center;color:#fff}
.login-left .ll-logo img{width:80px;height:80px;object-fit:contain;margin:0 auto 20px;filter:drop-shadow(0 4px 12px rgba(0,0,0,.2))}
.login-left .ll-logo h2{font-family:'DM Serif Display',serif;font-size:26px;font-weight:400;margin-bottom:8px}
.login-left .ll-logo p{font-size:14px;color:rgba(255,255,255,.7);max-width:260px;line-height:1.6}

/* Right panel */
.login-right{
  flex:1;display:flex;align-items:center;justify-content:center;
  padding:40px;background:var(--white);
}
.login-form-wrap{width:100%;max-width:360px}
.login-form-wrap h3{font-family:'DM Serif Display',serif;font-size:24px;color:var(--grey-900);margin-bottom:6px;font-weight:400}
.login-form-wrap .lf-sub{font-size:14px;color:var(--text-light);margin-bottom:28px}

.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px}
.form-group input{
  width:100%;padding:12px 16px;border-radius:10px;
  border:1.5px solid var(--grey-200);font-size:15px;
  font-family:inherit;color:var(--text);background:#F7FAFC;
  transition:border-color .2s;
}
.form-group input:focus{outline:none;border-color:var(--blue);background:#fff}

.btn-login{
  width:100%;padding:13px;border:none;border-radius:10px;
  background:var(--blue);color:#fff;font-size:16px;font-weight:700;
  cursor:pointer;font-family:inherit;transition:background .2s;margin-top:6px;
}
.btn-login:hover{background:var(--blue-dark)}

.error-box{
  background:var(--red-light);border:1px solid var(--red-border);
  border-radius:10px;padding:12px 16px;font-size:14px;color:#7A2828;
  margin-bottom:20px;display:flex;gap:8px;align-items:center;
}
.login-note{margin-top:22px;text-align:center;font-size:13px;color:var(--text-light)}
.login-note a{color:var(--blue);font-weight:600}

/* Mobile */
@media(max-width:680px){
  body{flex-direction:column}
  .login-left{width:100%;min-height:auto;padding:48px 24px 40px}
  .login-right{padding:32px 24px}
}
</style>
</head>
<body>

<!-- Left -->
<div class="login-left">
  <div class="ll-logo">
    <img src="../images/logo_ppa.jpg" alt="Logo PPA">
    <h2>Admin Panel</h2>
    <p>Sistem Informasi Panduan Layanan UPTD PPA — Pengelolaan Konten</p>
  </div>
</div>

<!-- Right -->
<div class="login-right">
  <div class="login-form-wrap">
    <h3>Selamat Datang</h3>
    <p class="lf-sub">Masuk dengan akun admin Anda untuk mengelola konten</p>

    <?php if ($error): ?>
      <div class="error-box">⚠️ &nbsp;<?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username" autocomplete="off" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="off" required>
      </div>
      <button type="submit" class="btn-login">Login →</button>
    </form>

    <div class="login-note">
      <a href="../index.php">← Kembali ke Website Publik</a>
    </div>
  </div>
</div>
</body>
</html>
