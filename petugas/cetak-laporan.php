<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Pembayaran SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h5 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header p {
            font-size: 14px;
            margin: 5px 0;
        }

        button.btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button.btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        td:first-child, th:first-child {
            width: 5%;
        }

        footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #666;
        }

        /* Styling khusus untuk cetak */
        @media print {
            .btn {
                display: none;
            }

            footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h5>Laporan Pembayaran SPP</h5>
        <p>Yayasan Pendidikan Tunas Bangsa</p>
        <p>Alamat: Jl. S.Parman No.6 Kwala Begumit, Kec. Binjai, Kab. Langkat</p>
    </div>

    <button class="btn" onclick="window.print()">Cetak</button>
    <table>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tahun SPP</th>
            <th>Status</th>
            <th>Tanggal Bayar</th>
            <th>Petugas</th>
        </tr>
        <?php
        include '../koneksi.php';
        $no = 1;
        $sql = "SELECT siswa.nisn, siswa.nama, kelas.nama_kelas, spp.tahun, 
                spp.nominal, pembayaran.jumlah_bayar, pembayaran.tgl_bayar, 
                petugas.nama_petugas
                FROM siswa 
                LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                LEFT JOIN spp ON siswa.id_spp = spp.id_spp
                LEFT JOIN pembayaran ON siswa.nisn = pembayaran.nisn
                LEFT JOIN petugas ON pembayaran.id_petugas = petugas.id_petugas
                ORDER BY siswa.nama ASC";
        $query = mysqli_query($koneksi, $sql);

        foreach ($query as $data) {
            $status = ($data['jumlah_bayar'] >= $data['nominal']) ? "Lunas" : "Belum Lunas";
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nisn'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nama_kelas'] ?></td>
                <td><?= $data['tahun'] ?></td>
                <td><?= $status ?></td>
                <td><?= $data['tgl_bayar'] ? $data['tgl_bayar'] : '-' ?></td>
                <td><?= $data['nama_petugas'] ? $data['nama_petugas'] : '-' ?></td>
            </tr>
        <?php } ?>
    </table>

    <footer>
        <p>&copy; <?= date('Y'); ?> Yayasan Pendidikan Tunas Bangsa. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
