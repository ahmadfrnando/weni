<h5>Halaman Pilih Data Siswa Untuk Pembayaran</h5>
<hr>

<!-- Form Filter -->
<form action="" method="get" class="mb-3">
    <input type="hidden" name="url" value="pembayaran"> <!-- Agar tetap di halaman pembayaran -->
    <div class="input-group">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Nama Siswa..." value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="width: 250px;">
        <button class="btn btn-outline-secondary btn-sm" type="submit">Cari</button>
    </div>
</form>

<table class="table table-striped table-bordered">
    <tr class="fw-bold">
        <td>No</td>
        <td>NISN</td>
        <td>Nama</td>
        <td>Kelas</td>
        <td>SPP</td>
        <td>Nominal</td>
        <td>Status</td>
        <td>History</td>
    </tr>
    <?php
    include '../koneksi.php';

    // Tentukan jumlah data per halaman
    $jumlahDataPerHalaman = 10;

    // Menangani pencarian
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Hitung total data
    $sqlTotalData = "SELECT COUNT(*) AS total FROM siswa 
                     JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                     JOIN spp ON siswa.id_spp = spp.id_spp
                     WHERE siswa.nama LIKE '%$search%'";
    $result = mysqli_query($koneksi, $sqlTotalData);
    $totalData = mysqli_fetch_assoc($result)['total'];

    // Hitung total halaman
    $totalHalaman = ceil($totalData / $jumlahDataPerHalaman);

    // Tentukan halaman aktif
    $halamanAktif = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
    $awalData = ($halamanAktif - 1) * $jumlahDataPerHalaman;

    // Ambil data sesuai halaman dan pencarian
    $sql = "SELECT siswa.*, spp.nominal, spp.tahun, kelas.nama_kelas 
            FROM siswa
            JOIN spp ON siswa.id_spp = spp.id_spp
            JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            WHERE siswa.nama LIKE '%$search%'
            ORDER BY siswa.nama ASC 
            LIMIT $awalData, $jumlahDataPerHalaman";
    $query = mysqli_query($koneksi, $sql);

    $no = $awalData + 1;
    foreach ($query as $data) {
        $bulan_dibayar = date('n');
        $tahun_dibayar = date('Y');

        $data_pembayaran = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) as jumlah_bayar FROM 
                pembayaran WHERE nisn= '$data[nisn]' AND bulan_dibayar='$bulan_dibayar' AND tahun_dibayar='$tahun_dibayar'");
        $data_pembayaran = mysqli_fetch_array($data_pembayaran);
        $sudah_bayar = $data_pembayaran['jumlah_bayar'];
        $kekurangan = $data['nominal'] - $sudah_bayar;
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nisn'] ?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['nama_kelas'] ?></td>
            <td><?= $data['tahun'] ?></td>
            <td><?= number_format($data['nominal'], 2, ',', '.'); ?></td>
            <td>
                <?php
                if ($kekurangan == 0) {
                    echo "<span class='badge text-bg-success'>Sudah Lunas</span>";
                } else { ?>
                    <a href="?url=tambah-pembayaran&nisn=<?= $data['nisn'] ?>&kekurangan=<?= $kekurangan ?>" class="btn btn-danger btn-sm">Pilih & Bayar</a>
                <?php }
                ?>
            </td>
            <td>
                <a href="?url=history-pembayaran&nisn=<?= $data['nisn'] ?>" class='btn btn-info btn-sm'>History</a>
            </td>
        </tr>
    <?php
    }
    ?>
</table>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalHalaman; $i++) : ?>
            <li class="page-item <?= ($i == $halamanAktif) ? 'active' : '' ?>">
                <a class="page-link" href="?url=pembayaran&halaman=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
