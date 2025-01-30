<?php
require 'config_midtrans.php';

// Data pembayaran
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => 500000, // Total bayar
);

// Item yang dibeli
$item_details = array(
    array(
        'id' => 'SPP001',
        'price' => 500000,
        'quantity' => 1,
        'name' => 'Pembayaran SPP Bulanan'
    )
);

// Data pelanggan
$customer_details = array(
    'first_name' => 'Budi',
    'last_name' => 'Santoso',
    'email' => 'budi@example.com',
    'phone' => '08123456789'
);

// Gabungkan semua data ke transaksi
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details
);

// Buat transaksi ke Midtrans
$snapToken = \Midtrans\Snap::getSnapToken($transaction);
echo json_encode(['snap_token' => $snapToken]);
exit();

?>
