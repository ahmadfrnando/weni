<?php
include '../koneksi.php';

$nisn = $_GET['nisn'];
$id_spp = $_POST['id_spp'];
$bulan_dibayar = $_POST['bulan_dibayar'];
$tahun_dibayar = $_POST['tahun_dibayar'];
$tgl_bayar = $_POST['tgl_bayar'];
$jumlah_bayar = $_POST['jumlah_bayar'];

// Simpan data pembayaran
$sql = "INSERT INTO pembayaran (nisn, id_spp, bulan_dibayar, tahun_dibayar, tgl_bayar, jumlah_bayar)
        VALUES ('$nisn', '$id_spp', '$bulan_dibayar', '$tahun_dibayar', '$tgl_bayar', '$jumlah_bayar')";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    echo "<script>alert('Pembayaran berhasil'); window.location='?url=pembayaran';</script>";
} else {
    echo "<script>alert('Pembayaran gagal'); window.location='?url=pembayaran';</script>";
}
?>
