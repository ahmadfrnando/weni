<h5>Halaman Data SPP</h5>
<a href="?url=tambah-spp" class="btn btn-primary btn-sm">Tambah SPP</a>
<hr>

<!-- Filter Berdasarkan Jenjang Pendidikan -->
<form method="GET">
    <input type="hidden" name="url" value="spp">
    <label for="filter_jenjang">Filter Jenjang: </label>
    <select name="filter_jenjang" id="filter_jenjang" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="SMP" <?= isset($_GET['filter_jenjang']) && $_GET['filter_jenjang'] == 'SMP' ? 'selected' : '' ?>>SMP</option>
        <option value="SMA" <?= isset($_GET['filter_jenjang']) && $_GET['filter_jenjang'] == 'SMA' ? 'selected' : '' ?>>SMA</option>
        <option value="SMK" <?= isset($_GET['filter_jenjang']) && $_GET['filter_jenjang'] == 'SMK' ? 'selected' : '' ?>>SMK</option>
    </select>
</form>
<hr>

<table class="table table-striped table-bordered">
    <tr class="fw-bold">
        <td>No</td>
        <td>Tahun Ajaran</td>
        <td>Jenjang</td>
        <td>Nominal</td>
        <td>Edit</td>
        <td>Hapus</td>
    </tr>
    <?php
    include '../koneksi.php';
    $no = 1;

    // Filter berdasarkan jenjang jika ada
    $filterJenjang = isset($_GET['filter_jenjang']) && !empty($_GET['filter_jenjang']) ? $_GET['filter_jenjang'] : '';
    $whereClause = $filterJenjang ? "WHERE jenjang = '$filterJenjang'" : '';
    $sql = "SELECT * FROM spp $whereClause ORDER BY id_spp DESC";
    $query = mysqli_query($koneksi, $sql);

    foreach ($query as $data) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['tahun'] ?></td>
            <td><?= $data['jenjang'] ?></td>
            <td><?= number_format($data['nominal'], 2, ',', '.') ?></td>
            <td>
                <a href="?url=edit-spp&id_spp=<?= $data['id_spp'] ?>" class='btn btn-warning btn-sm'>Edit</a>
            </td>
            <td>
                <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data')" href="?url=hapus-spp&id_spp=<?= $data['id_spp'] ?>" class='btn btn-danger btn-sm'>Hapus</a>
            </td>
        </tr>
    <?php
    }
    ?>
</table>
