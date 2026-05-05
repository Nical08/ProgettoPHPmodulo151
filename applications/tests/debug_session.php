<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../application/config/config.php';
require __DIR__ . '/../application/libs/eloquent.php';

echo "Session active: " . (session_status() === PHP_SESSION_ACTIVE ? "yes" : "no") . "\n";

Auth::logout();
echo "After logout\n";

$r = Auth::login("admin@ti.ch", "Password&1");
echo "Login result: " . var_export($r, true) . "\n";
echo "isLoggedIn: " . (Auth::isLoggedIn() ? "yes" : "no") . "\n";

$keys = ['user_id', 'user_nome', 'user_email', 'user_ruolo', 'user_table'];
foreach ($keys as $k) {
    echo "\$_SESSION['$k'] = " . var_export($_SESSION[$k] ?? 'NOT SET', true) . "\n";
}
