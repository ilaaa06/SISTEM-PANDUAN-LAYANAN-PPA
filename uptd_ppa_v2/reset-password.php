<?php
require_once 'includes/config.php';

// Password yang ingin diset
$new_password = "admin123";
$password_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 10]);

echo "Generated Hash: " . $password_hash . "\n\n";

// Update ke database
try {
    $stmt = $pdo->prepare("UPDATE admin SET password_hash = ? WHERE username = 'admin'");
    $stmt->execute([$password_hash]);
    
    echo "✅ Password berhasil diupdate!\n\n";
    
    // Verifikasi
    $result = $pdo->query("SELECT password_hash FROM admin WHERE username='admin'")->fetch();
    echo "Hash di database: " . $result['password_hash'] . "\n";
    echo "Test verify: " . (password_verify("admin123", $result['password_hash']) ? "✅ COCOK!" : "❌ TIDAK COCOK!") . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
