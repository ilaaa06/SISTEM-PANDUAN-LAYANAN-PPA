<?php
// Generate password hash untuk "admin123"
$password = "admin123";
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n";

// Juga test kecocokan
echo "\nTest verify:\n";
echo password_verify("admin123", $hash) ? "✅ Password cocok!" : "❌ Password tidak cocok!";
?>
