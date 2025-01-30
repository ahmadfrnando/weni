<?php
$nisn = isset($_GET['nisn']) ? $_GET['nisn'] : null;

if ($nisn === null) {
    echo "Parameter NISN tidak ditemukan.";
    exit();
}

include '../koneksi.php';
?>
<h5>Riwayat Pembayaran</h5>
<hr>

<table class="table table-striped table-bordered">
    <thead>
        <tr class="fw-bold">
            <td>No</td>
            <td>Bulan</td>
            <td>Nominal</td>
            <td>Tanggal Bayar</td>
            <td>Status</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;

        // Query untuk mendapatkan data riwayat pembayaran siswa berdasarkan NISN
        $sql = "
            SELECT
                pembayaran.*,
                spp.tahun AS tahun_spp,
                spp.nominal AS nominal_spp
            FROM pembayaran
            LEFT JOIN spp ON pembayaran.id_spp = spp.id_spp
            WHERE pembayaran.nisn = '$nisn'
            ORDER BY pembayaran.tgl_bayar ASC
        ";
        $query = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
                $status = ($data['jumlah_bayar'] >= $data['nominal_spp']) ? "Lunas" : "Belum Lunas";
        ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>UK. Termin <?= $data['bulan_dibayar']; ?></td>
                    <td><?= number_format($data['jumlah_bayar'], 2, ',', '.'); ?></td>
                    <td><?= date("d-m-Y", strtotime($data['tgl_bayar'])); ?></td>
                    <td>
                        <span class="badge <?= $status == 'Lunas' ? 'text-bg-success' : 'text-bg-danger'; ?>">
                            <?= $status; ?>
                        </span>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>Belum ada riwayat pembayaran</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Tombol Kembali -->
<button onclick="goBack()" class="btn btn-primary btn-sm">Kembali</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
