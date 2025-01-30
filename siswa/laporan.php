<?php
include '../koneksi.php';

// Pastikan pengguna sudah login
if (empty($_SESSION['nisn'])) {
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('../index.php');</script>";
    exit();
}

$nisn = $_SESSION['nisn'];

// Ambil data siswa
$query_student = mysqli_query($koneksi, "
    SELECT siswa.*, spp.nominal 
    FROM siswa 
    JOIN spp ON siswa.id_spp = spp.id_spp 
    WHERE siswa.nisn = '$nisn'");
$student_data = mysqli_fetch_assoc($query_student);
if (!$student_data) {
    echo "<script>alert('Data siswa tidak ditemukan! Silakan hubungi admin.'); window.location='logout.php';</script>";
    exit();
}

// Ambil data pembayaran
$query_payments = "SELECT * FROM pembayaran WHERE nisn = '$nisn' ORDER BY tgl_bayar DESC";
$result_payments = mysqli_query($koneksi, $query_payments);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Aplikasi Pembayaran SPP</title>
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        h4 {
            color: #353A5F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #353A5F;
            color: #fff;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: #fff;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <p><strong>Nama:</strong> <?= $student_data['nama'] ?></p>
    <p><strong>NISN:</strong> <?= $student_data['nisn'] ?></p>
    <p><strong>Nominal SPP:</strong> Rp<?= number_format($student_data['nominal'], 2) ?></p>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_payments) > 0) {
                while ($row = mysqli_fetch_assoc($result_payments)) {
                    // Hitung status pembayaran
                    $nominal_spp = $student_data['nominal'];
                    $status = "Tidak Lunas"; // Default
                    if ($row['jumlah_bayar'] >= $nominal_spp) {
                        $status = "Lunas";
                    } elseif ($row['jumlah_bayar'] > 0 && $row['jumlah_bayar'] < $nominal_spp) {
                        $status = "Tertunda";
                    }
            ?>
                    <tr>
                        <td><?= $row['bulan_dibayar'] ?></td>
                        <td><?= $row['tahun_dibayar'] ?></td>
                        <td>Rp<?= number_format($row['jumlah_bayar'], 2) ?></td>
                        <td>
                            <?php
                            if ($status == "Lunas") {
                                echo '<span class="badge badge-success">Lunas</span>';
                            } elseif ($status == "Tertunda") {
                                echo '<span class="badge badge-warning">Tertunda</span>';
                            } else {
                                echo '<span class="badge badge-danger">Tidak Lunas</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4">Belum ada pembayaran yang diajukan.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="cetak-laporan.php" class="btn btn-primary btn-sm">Cetak Laporan PDF</a>
</body>

</html>