<?php
// Test Database Connection
echo "=== TEST KONEKSI DATABASE ===\n\n";

require_once 'includes/config.php';

try {
    echo "✅ Database terkoneksi!\n\n";
    
    // Test query
    $result = $pdo->query("SELECT * FROM admin");
    $admin = $result->fetch();
    
    echo "Admin ditemukan:\n";
    echo "  - Username: " . $admin['username'] . "\n";
    echo "  - Nama: " . $admin['nama_lengkap'] . "\n";
    echo "  - Password Hash: " . substr($admin['password_hash'], 0, 20) . "...\n\n";
    
    // Test tabel lain
    $tables = $pdo->query("SHOW TABLES")->fetchAll();
    echo "Tabel dalam database:\n";
    foreach ($tables as $t) {
        echo "  - " . reset($t) . "\n";
    }
    
    echo "\n✅ SISTEM SIAP DIGUNAKAN!\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
?>
