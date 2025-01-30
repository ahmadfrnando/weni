<?php
$nisn = $_SESSION['nisn']; // Mengambil NISN dari session siswa
?>
<h5>History Pembayaran</h5>
<hr>
<table class="table table-striped table-bordered">
    <tr class="fw-bold text-center">
        <td>No</td>
        <td>NISN</td>
        <td>Nama</td>
        <td>Kelas</td>
        <td>Tahun SPP</td>
        <td>Nominal</td>
        <td>Status</td>
        <td>Tanggal Bayar</td>
        <td>Petugas</td>
    </tr>
    <?php
    include '../koneksi.php';
    $no = 1;

    // Query untuk mendapatkan riwayat pembayaran berdasarkan nisn
    $sql = "SELECT 
                pembayaran.nisn, 
                siswa.nama, 
                kelas.nama_kelas, 
                spp.tahun, 
                spp.nominal, 
                pembayaran.jumlah_bayar, 
                pembayaran.tgl_bayar, 
                petugas.nama_petugas
            FROM 
                pembayaran 
            JOIN 
                siswa ON pembayaran.nisn = siswa.nisn
            JOIN 
                kelas ON siswa.id_kelas = kelas.id_kelas
            JOIN 
                spp ON pembayaran.id_spp = spp.id_spp
            JOIN 
                petugas ON pembayaran.id_petugas = petugas.id_petugas
            WHERE 
                pembayaran.nisn = '$nisn'
            ORDER BY 
                pembayaran.tgl_bayar DESC";

    $query = mysqli_query($koneksi, $sql);
    foreach ($query as $data) {
        // Tentukan status
        $status = ($data['jumlah_bayar'] >= $data['nominal']) ? "Lunas" : "Tidak Lunas";
    ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-center"><?= $data['nisn'] ?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['nama_kelas'] ?></td>
            <td class="text-center"><?= $data['tahun'] ?></td>
            <td class="text-end"><?= number_format($data['nominal'], 2, ',', '.'); ?></td> <!-- Nominal SPP -->
            <td class="text-center">
                <?php if ($status == "Lunas") { ?>
                    <span class="badge bg-success">Lunas</span>
                <?php } else { ?>
                    <span class="badge bg-danger">Tidak Lunas</span>
                <?php } ?>
            </td>
            <td class="text-center"><?= $data['tgl_bayar'] ? $data['tgl_bayar'] : '-'; ?></td>
            <td><?= $data['nama_petugas'] ? $data['nama_petugas'] : '-'; ?></td>
        </tr>
    <?php
    }
    ?>
</table>