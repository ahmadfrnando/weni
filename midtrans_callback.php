<?php
require_once '../config_midtrans.php'; // Pastikan file config Midtrans ada
include '../koneksi.php';

\Midtrans\Config::$serverKey = '#';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data JSON dari Midtrans
$json = file_get_contents("php://input");
$data = json_decode($json);

if (!$data) {
    http_response_code(400);
    exit("Invalid Request");
}

$order_id = $data->order_id; // Formatnya "SPP-27"
$id_pembayaran = str_replace("SPP-", "", $order_id); // Ambil ID pembayaran
$transaction_status = $data->transaction_status;

$status = "pending"; // Default

if ($transaction_status == "capture" || $transaction_status == "settlement") {
    $status = "lunas"; // Berhasil
} elseif ($transaction_status == "deny" || $transaction_status == "cancel" || $transaction_status == "expire") {
    $status = "gagal"; // Gagal
}

// Update status pembayaran di database
$query = "UPDATE notifikasi_pembayaran SET status='$status' WHERE id_pembayaran='$id_pembayaran'";
if (mysqli_query($koneksi, $query)) {
    echo "Success";
} else {
    echo "Failed to update database";
}
?>
