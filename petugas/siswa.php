<h5>Halaman Data Siswa</h5>
<a href="?url=tambah-siswa" class="btn btn-primary btn-sm">Tambah Siswa</a>
<hr>

<!-- Form Pencarian -->
<form action="" method="get" class="mb-3">
    <input type="hidden" name="url" value="siswa"> <!-- Agar tetap di halaman siswa setelah pencarian -->
    <div class="input-group">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Nama Siswa..." value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="width: 250px;">
        <button class="btn btn-outline-secondary btn-sm" type="submit">Cari</button>
    </div>
</form>

<table class="table table-striped table-bordered">
    <tr class="fw-bold">
        <td>No</td>
        <td>NISN</td>
        <td>NIS</td>
        <td>Nama</td>
        <td>Kelas</td>
        <td>Alamat</td>
        <td>SPP</td>
        <td>Edit</td>
        <td>Hapus</td>
    </tr>
    <?php
    include '../koneksi.php';

    // Tentukan jumlah data per halaman
    $jumlahDataPerHalaman = 10; // Sesuaikan dengan kebutuhan

    // Menangani pencarian
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Hitung total data
    $sqlTotalData = "SELECT COUNT(*) AS total FROM siswa 
                     WHERE nama LIKE '%$search%'";
    $result = mysqli_query($koneksi, $sqlTotalData);
    $totalData = mysqli_fetch_assoc($result)['total'];

    // Hitung total halaman
    $totalHalaman = ceil($totalData / $jumlahDataPerHalaman);

    // Tentukan halaman aktif
    $halamanAktif = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
    $awalData = ($halamanAktif - 1) * $jumlahDataPerHalaman;

    // Ambil data sesuai halaman dan pencarian
    $sql = "SELECT siswa.*, spp.tahun, spp.nominal, kelas.nama_kelas 
            FROM siswa
            JOIN spp ON siswa.id_spp = spp.id_spp
            JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            WHERE siswa.nama LIKE '%$search%'
            ORDER BY siswa.nama ASC 
            LIMIT $awalData, $jumlahDataPerHalaman";
    $query = mysqli_query($koneksi, $sql);

    $no = $awalData + 1;
    foreach ($query as $data) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nisn'] ?></td>
            <td><?= $data['nis'] ?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['nama_kelas'] ?></td>
            <td><?= $data['alamat'] ?></td>
            <td><?= $data['tahun'] ?> - <?= number_format($data['nominal'], 0, ',', '.'); ?></td>
            <td>
                <a href="?url=edit-siswa&nisn=<?= $data['nisn'] ?>" class='btn btn-warning btn-sm'>Edit</a>
            </td>
            <td>
                <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data?')" href="?url=hapus-siswa&nisn=<?= $data['nisn'] ?>" class='btn btn-danger btn-sm'>Hapus</a>
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
                <a class="page-link" href="?url=siswa&halaman=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
