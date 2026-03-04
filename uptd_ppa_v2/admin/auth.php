<?php
// admin/auth.php
// Middleware autentikasi — include di setiap halaman admin.
// Jika belum login → redirect ke login.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau belum login, redirect
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Helper: nama admin yang sedang login
function getAdminName(): string {
    return $_SESSION['admin_nama'] ?? 'Administrator';
}
?>
