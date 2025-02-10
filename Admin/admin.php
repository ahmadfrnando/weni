<?php
session_start();
if (empty($_SESSION['id_petugas'])) {
    echo "<script>
        alert('Maaf Anda Belum Login');
        window.location.assign('../index2.php');
        </script>";
    exit();
}
if ($_SESSION['level'] != 'admin') {
    echo "<script>
        alert('Maaf Anda Bukan Sesi Admin');
        window.location.assign('../index2.php');
        </script>";
    exit();
}

// Include koneksi database
include '../koneksi.php';

// Query untuk menghitung jumlah siswa
$query = "SELECT COUNT(*) as jumlah_siswa FROM siswa";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_siswa = $data['jumlah_siswa'];
// Query untuk mengambil notifikasi pembayaran
$query_notifikasi = "SELECT n.*, s.nama AS nama_siswa, k.nama_kelas 
                     FROM notifikasi_pembayaran n
                     JOIN siswa s ON n.nisn = s.nisn
                     JOIN kelas k ON s.id_kelas = k.id_kelas
                     ORDER BY n.tgl_bayar DESC";
$result_notifikasi = mysqli_query($koneksi, $query_notifikasi);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Aplikasi Pembayaran SPP</title>

    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS styles here */
        body {
            font-family: 'Ubuntu', sans-serif;
            background-color: #f8f9fa;
            /* warna keseluruhan main content */
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom right, #9EBAF3, #353A5F) no-repeat;
            /* warna sidebar */
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transition: all 0.3s;
            overflow: hidden;
        }

        .sidebar.hide {
            margin-left: -250px;
        }

        .sidebar .header,
        .sidebar .main {
            padding: 20px;
        }

        .sidebar .header {
            border-bottom: 1px solid #ffffff;
            /* warna garis dibawah logo sidebar */
        }

        .sidebar .list-item {
            margin: 10px 0;
        }

        .sidebar .list-item a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: color 0.3s, background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .sidebar .list-item a .icon {
            width: 30px;
            margin-right: 10px;
            transition: transform 0.3s;
        }

        .sidebar .list-item a:hover {
            color: #ffffff;
            background: linear-gradient(to bottom right, #9EBAF3, #353A5F) no-repeat;
            /* warna hover */
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar .list-item a:hover .icon {
            transform: scale(1.2);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-bottom: 70px;
            /* Tambahkan ruang ekstra untuk tombol di bawah */
            transition: margin-left 0.3s;
        }

        .main-content.hide {
            margin-left: 0;
        }

        .main-content h3 {
            margin-bottom: 20px;
        }

        .main-content .alert {
            margin-bottom: 20px;
        }

        .alert-info {
            background: linear-gradient(to bottom right, #353A5F, #9EBAF3) no-repeat;
            color: #ffffff;
            border-color: #9EBAF3;
        }

        .main-content .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            /* warna border main content */
        }

        #menu-button {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            transition: transform 0.3s;
        }

        #menu-button:hover {
            transform: rotate(90deg);
        }

        .show-sidebar-button {
            display: none;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            background: linear-gradient(to bottom right, #353A5F, #9EBAF3) no-repeat;
            /* warna show sidebar */
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        .show-sidebar-button.show {
            display: block;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 250px;
            /* Align with the right side of the sidebar */
            width: calc(100% - 250px);
            /* Width should cover remaining width excluding sidebar */
            background: linear-gradient(to bottom right, #353A5F, #9EBAF3);
            color: #ffffff;
            padding: 10px;
            text-align: center;
            font-family: 'Ubuntu', sans-serif;
            font-size: 13px;
            z-index: 1000;
            /* Ensure footer is on top of other content */
            transition: left 0.3s, width 0.3s;
            /* Smooth transition when sidebar toggles */
        }

        /* CSS untuk ketika sidebar tersembunyi */
        .footer.hide-sidebar {
            left: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="sidebar">
            <div id="menu-button" onclick="toggleSidebar()">
                <i class="fas fa-bars fa-lg" style="color: #ffffff; /* warna pada garis 3 sidebar atas */"></i>
            </div>
            <div class="header">
                <div class="logo-container">
                    <img src="Tunas-Bangsa2.png" alt="logo" height="50px" style="margin-bottom: -10px">
                </div>
            </div>
            <div class="main">
                <div class="list-item">
                    <a href="admin.php">
                        <i class="fa fa-tachometer-alt icon"></i>
                        <span class="description">Administration</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=spp">
                        <i class="fa fa-money-bill-wave icon"></i>
                        <span class="description">SPP</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=kelas">
                        <i class="fa fa-school icon"></i>
                        <span class="description">Kelas</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=siswa">
                        <i class="fa fa-user-graduate icon"></i>
                        <span class="description">Siswa</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=petugas">
                        <i class="fa fa-user-tie icon"></i>
                        <span class="description">Petugas</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=pembayaran">
                        <i class="fa fa-receipt icon"></i>
                        <span class="description">Pembayaran</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="admin.php?url=laporan">
                        <i class="fa fa-file-alt icon"></i>
                        <span class="description">Laporan</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="./logout.php">
                        <i class="fa fa-sign-out-alt icon"></i>
                        <span class="description">Logout</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-content">
            <button id="show-sidebar-button" class="show-sidebar-button" style="font-size: 12px; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 5px;" onclick="toggleSidebar()">Show Sidebar</button>

            <h3>Aplikasi Pembayaran SPP</h3>
            <div class="alert alert-info">
                Anda Login Sebagai <b>ADMINISTRATOR</b> Aplikasi Pembayaran SPP.
            </div>

            <?php
            $file = @$_GET['url'];
            if (empty($file)) {
                echo "<h4>Selamat Datang Di Halaman Administrator.</h4>";
                echo "Aplikasi Pembayaran SPP digunakan untuk mempermudah dalam mencatat pembayaran siswa/siswi di sekolah.";

                // Tampilkan jumlah siswa hanya di halaman utama
                echo "<div class='alert alert-success'>";
                echo "<h5><b>Jumlah Siswa Terdaftar:</b> $jumlah_siswa siswa</h5>";
                echo "</div>";

                // Tampilkan Notifikasi Pembayaran hanya di halaman utama
                echo "<div class='card mb-3'>";
                echo "<div class='card-header bg-info text-white'>";
                echo "<h5>Notifikasi Pembayaran</h5>";
                echo "</div>";
                echo "<div class='card-body'>";

                if (mysqli_num_rows($result_notifikasi) > 0) {
                    // Awal tabel
                    echo "<table class='table table-striped'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Nama Siswa</th>";
                    echo "<th>Kelas</th>";
                    echo "<th>Bulan Dibayar</th>";
                    echo "<th>Tahun Dibayar</th>";
                    echo "<th>Jumlah Bayar</th>";
                    echo "<th>Tanggal Bayar</th>";
                    echo "<th>Status</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $no = 1;
                    while ($notif = mysqli_fetch_assoc($result_notifikasi)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($notif['nama_siswa']) . "</td>";
                        echo "<td>" . htmlspecialchars($notif['nama_kelas']) . "</td>";
                        echo "<td>" . htmlspecialchars($notif['bulan_dibayar']) . "</td>";
                        echo "<td>" . htmlspecialchars($notif['tahun_dibayar']) . "</td>";
                        echo "<td>Rp" . number_format($notif['jumlah_bayar'], 2, ',', '.') . "</td>";
                        echo "<td>" . htmlspecialchars($notif['tgl_bayar']) . "</td>";
                        echo "<td>";
                        echo "<span class='badge " . ($notif['status'] == 'lunas' ? 'text-bg-success' : 'text-bg-danger') . "'>";
                        echo htmlspecialchars($notif['status']);
                        echo "</span>";
                        echo "</td>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    // Akhir tabel
                } else {
                    echo "<p>Tidak ada pembayaran baru</p>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                include $file . '.php';
            }
            ?>

        </div>
        <!-- Footer -->
        <div class="footer">
            &copy; <?php echo date("Y"); ?> Aplikasi Pembayaran SPP Tunas Bangsa
        </div>
    </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const showSidebarButton = document.getElementById('show-sidebar-button');

            sidebar.classList.toggle('hide');
            mainContent.classList.toggle('hide');

            if (sidebar.classList.contains('hide')) {
                showSidebarButton.classList.add('show');
            } else {
                showSidebarButton.classList.remove('show');
            }
        }
    </script>
</body>

</html>