<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pembayaran SPP</title>
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
            color: #333;
        }

        h1,
        h5 {
            text-align: center;
            margin-bottom: 5px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-header p {
            font-size: 14px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 5px;
            color: #fff;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #666;
        }

        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include '../koneksi.php';

    $nisn = $_SESSION['nisn']; // Mengambil NISN dari sesi login siswa

    // Query untuk mengambil data siswa
    $student_query = mysqli_query($koneksi, "
        SELECT siswa.nama, siswa.nisn, spp.nominal 
        FROM siswa 
        JOIN spp ON siswa.id_spp = spp.id_spp 
        WHERE siswa.nisn = '$nisn'
    ");
    $student_data = mysqli_fetch_assoc($student_query);

    // Query untuk mengambil data pembayaran siswa
    $payment_query = mysqli_query($koneksi, "
        SELECT * 
        FROM pembayaran 
        WHERE nisn = '$nisn' 
        ORDER BY tgl_bayar DESC
    ");
    ?>
    <div class="report-header">
        <h1>Yayasan Pendidikan Tunas Bangsa</h1>
        <h5>Laporan Pembayaran SPP</h5>
        <p>Alamat: Jl. S.Parman No.6, Kwala Begumit, Kec. Binjai, Kab. Langkat</p>
        <p>Nama: <strong><?= $student_data['nama'] ?></strong> | NISN: <strong><?= $student_data['nisn'] ?></strong></p>
        <p>SPP: Rp<?= number_format($student_data['nominal'], 2, ',', '.') ?></p>
    </div>

    <a href="#" class="btn btn-primary btn-sm" onclick="window.print()">Cetak Laporan</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Bayar</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($payment_query) > 0) {
                while ($data = mysqli_fetch_assoc($payment_query)) {
                    // Tentukan status pembayaran
                    if ($data['jumlah_bayar'] >= $student_data['nominal']) {
                        $status = '<span class="badge badge-success">Lunas</span>';
                    } elseif ($data['jumlah_bayar'] > 0) {
                        $status = '<span class="badge badge-warning">Tertunda</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Belum Dibayar</span>';
                    }
            ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['bulan_dibayar'] ?></td>
                        <td><?= $data['tahun_dibayar'] ?></td>
                        <td>Rp<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                        <td><?= $status ?></td>
                        <td><?= $data['tgl_bayar'] ? date('d-m-Y', strtotime($data['tgl_bayar'])) : '-' ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6">Tidak ada riwayat pembayaran</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <footer>
        <p>&copy; <?= date('Y'); ?> Yayasan Pendidikan Tunas Bangsa. Semua Hak Dilindungi.</p>
    </footer>
</body>

</html>