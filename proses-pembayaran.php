<?php
include '../koneksi.php';

if (!isset($_GET['id_pembayaran']) || !isset($_GET['status'])) {
    echo "<script>alert('Data tidak valid!'); window.location='siswa.php';</script>";
    exit();
}

$id_pembayaran = $_GET['id_pembayaran'];
$status = $_GET['status'];

// Update status pembayaran di database
if ($status == 'success') {
    $query = "UPDATE notifikasi_pembayaran SET status='lunas' WHERE id_pembayaran='$id_pembayaran'";
} elseif ($status == 'pending') {
    $query = "UPDATE notifikasi_pembayaran SET status='pending' WHERE id_pembayaran='$id_pembayaran'";
}

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Status pembayaran diperbarui!'); window.location='siswa-pembayaran-detail.php?id_pembayaran=<?= $id_pembayaran; ?>&status=sukses';</script>";
} else {
    echo "<script>alert('Gagal memperbarui status pembayaran.'); window.location='siswa-pembayaran-detail.php?id_pembayaran=<?= $id_pembayaran; ?>&status=pending';</script>";
}
?>
