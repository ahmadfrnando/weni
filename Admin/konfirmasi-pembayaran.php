<?php
session_start();
if (empty($_SESSION['id_petugas']) || $_SESSION['level'] != 'admin') {
    echo "<script>
        alert('Anda tidak memiliki akses!');
        window.location.assign('../index2.php');
        </script>";
    exit();
}

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_notifikasi = $_POST['id_notifikasi'];

    // Ambil data pembayaran
    $query = "SELECT * FROM notifikasi_pembayaran WHERE id = '$id_notifikasi'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<script>alert('Data pembayaran tidak ditemukan.'); window.location.href='admin.php';</script>";
        exit();
    }

    // Simpan ke tabel pembayaran
    $query_pembayaran = "INSERT INTO pembayaran (id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar) 
                         VALUES ('{$_SESSION['id_petugas']}', '{$data['nisn']}', NOW(), '{$data['bulan_dibayar']}', '{$data['tahun_dibayar']}', 
                                 '{$data['id_spp']}', '{$data['jumlah_bayar']}')";
    $query_update = "UPDATE notifikasi_pembayaran SET status = 'lunas' WHERE id = '$id_notifikasi'";

    if (mysqli_query($koneksi, $query_pembayaran) && mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Pembayaran telah dikonfirmasi!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengkonfirmasi pembayaran.'); window.location.href='admin.php';</script>";
    }
}
?>
