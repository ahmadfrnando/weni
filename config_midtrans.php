<?php
require 'vendor/autoload.php'; // Jika pakai Composer

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-hWKMcVUEiQ-LTZ23xqqcIjb_';
\Midtrans\Config::$isProduction = false; // false = Sandbox, true = Production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>

