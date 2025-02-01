<?php
require 'vendor/autoload.php'; // Jika pakai Composer

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = '#';
\Midtrans\Config::$isProduction = false; // false = Sandbox, true = Production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>

