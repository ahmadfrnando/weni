<?php
require 'vendor/autoload.php'; // Jika pakai Composer
require_once 'config.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = $MIDTRANS_SERVER_KEY;
\Midtrans\Config::$isProduction = false; // false = Sandbox, true = Production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>

