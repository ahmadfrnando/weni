<h5>Laporan Pembayaran SPP</h5>
<a href="cetak-laporan.php" class="btn btn-primary btn-sm">Cetak Laporan PDF</a>
<hr>

<!-- Form Filter Bulan dan Tahun -->
<form action="" method="get" class="mb-3">
    <input type="hidden" name="url" value="laporan"> <!-- Agar tetap berada di halaman laporan -->
    <div class="row">
        <div class="col-md-3">
            <select name="bulan" class="form-select form-select-sm" required>
                <option value="">Pilih Bulan</option>
                <?php
                // Loop bulan (1-12)
                for ($i = 1; $i <= 12; $i++) {
                    $bulan = str_pad($i, 2, "0", STR_PAD_LEFT); // Format bulan 01, 02, dan seterusnya
                    $namaBulan = date("F", mktime(0, 0, 0, $i, 1)); // Nama bulan
                    $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $bulan) ? 'selected' : '';
                    echo "<option value='$bulan' $selected>$namaBulan</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="tahun" class="form-select form-select-sm" required>
                <option value="">Pilih Tahun</option>
                <?php
                // Loop tahun (misalnya 2 tahun terakhir)
                $tahunSekarang = date("Y");
                for ($i = $tahunSekarang - 2; $i <= $tahunSekarang; $i++) {
                    $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : '';
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Filter</button>
        </div>
    </div>
</form>

<table class="table table-striped table-bordered">
    <tr class="fw-bold">
        <td>No</td>
        <td>NISN</td>
        <td>Nama</td>
        <td>Kelas</td>
        <td>Bulan</td>
        <td>Tahun SPP</td>
        <td>Status</td>
        <td>Tanggal Bayar</td>
    </tr>
    <?php
    include '../koneksi.php';
    $no = 1;

    // Default filter
    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Bulan saat ini
    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Tahun saat ini

    // Konversi angka bulan ke nama bulan
    $bulan_nama = [
        1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 
        5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 
        9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
    ];

    // Query hanya mengambil data dari pembayaran
    $sql = "SELECT pembayaran.nisn, siswa.nama, kelas.nama_kelas, spp.tahun, 
                   pembayaran.tgl_bayar, pembayaran.bulan_dibayar
            FROM pembayaran
            LEFT JOIN siswa ON pembayaran.nisn = siswa.nisn
            LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            LEFT JOIN spp ON siswa.id_spp = spp.id_spp
            WHERE MONTH(pembayaran.tgl_bayar) = '$bulan' 
            AND YEAR(pembayaran.tgl_bayar) = '$tahun'
            ORDER BY pembayaran.tgl_bayar ASC";

    $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

    if (mysqli_num_rows($query) > 0) {
        while ($data = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nisn'] ?></td>
                <td><?= $data['nama'] ? $data['nama'] : 'Tidak Ada' ?></td>
                <td><?= $data['nama_kelas'] ? $data['nama_kelas'] : 'Tidak Ada' ?></td>
                <td><?= isset($bulan_nama[$data['bulan_dibayar']]) ? $bulan_nama[$data['bulan_dibayar']] : '-'; ?></td>
                <td><?= $data['tahun'] ? $data['tahun'] : '-' ?></td>
                <td>
                    <span class="badge text-bg-success">lunas</span>
                </td>
                <td><?= $data['tgl_bayar'] ? $data['tgl_bayar'] : '-'; ?></td>
            </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>Data tidak ditemukan untuk bulan dan tahun yang dipilih.</td></tr>";
    }
    ?>
</table>
