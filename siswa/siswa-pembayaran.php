<?php
session_start();
if (!isset($_SESSION['nisn'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='../index2.php';</script>";
    exit();
}

include '../koneksi.php';
require_once '../config.php';
$nisn = $_SESSION['nisn'];

// Ambil data siswa
$query_siswa = "SELECT s.*, k.nama_kelas, k.kompetensi_keahlian, sp.nominal, sp.tahun 
                FROM siswa s 
                JOIN kelas k ON s.id_kelas = k.id_kelas 
                JOIN spp sp ON s.id_spp = sp.id_spp 
                WHERE s.nisn = '$nisn'";
$result_siswa = mysqli_query($koneksi, $query_siswa);
$data_siswa = mysqli_fetch_assoc($result_siswa);

// Proses pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_spp = $data_siswa['id_spp'];
    $bulan_dibayar = $_POST['bulan_dibayar'];
    $tahun_dibayar = $_POST['tahun_dibayar'];
    $jumlah_bayar = $data_siswa['nominal'];

    // Simpan ke tabel notifikasi_pembayaran
    $query_bayar = "INSERT INTO notifikasi_pembayaran (nisn, id_spp, bulan_dibayar, tahun_dibayar, jumlah_bayar) 
                    VALUES ('$nisn', '$id_spp', '$bulan_dibayar', '$tahun_dibayar', '$jumlah_bayar')";
    if (mysqli_query($koneksi, $query_bayar)) {
        echo "<script>alert('Pembayaran berhasil! Silahkan lakukan pembayaran.');</script>";
    } else {
        echo "<script>alert('Pembayaran gagal. Silakan coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran SPP</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Pembayaran SPP</h2>
        <p>Nama: <?php echo $data_siswa['nama']; ?></p>
        <p>Kelas: <?php echo $data_siswa['nama_kelas'] . " - " . $data_siswa['kompetensi_keahlian']; ?></p>
        <p>Nominal SPP: Rp<?php echo number_format($data_siswa['nominal'], 2); ?> (<?php echo $data_siswa['tahun']; ?>)</p>

        <form method="POST">
            <div class="mb-3">
                <label for="bulan_dibayar" class="form-label">Bulan Dibayar</label>
                <select class="form-control" id="bulan_dibayar" name="bulan_dibayar" required>
                    <?php
                    $bulan = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];
                    foreach ($bulan as $b) {
                        echo "<option value='$b'>$b</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tahun_dibayar" class="form-label">Tahun Dibayar</label>
                <input type="number" class="form-control" id="tahun_dibayar" name="tahun_dibayar" value="<?php echo date('Y'); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Bayar</button>
        </form>
    </div>
</body>

</html>