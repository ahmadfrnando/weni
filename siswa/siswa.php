 <?php
    ob_start();
    session_start();
    if (empty($_SESSION['nisn'])) {
        echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('../index.php');</script>";
        exit();
    }

    include '../koneksi.php';

    // Handler logout
    if (isset($_GET['url']) && $_GET['url'] == 'logout') {
        session_unset(); // Delete all data session
        session_destroy(); // Destroy session
        echo "<script>alert('Anda berhasil logout!'); window.location='../index.php';</script>";
        exit();
    }

    // Ambil informasi nama siswa dari database berdasarkan NISN
    $nisn = $_SESSION['nisn'];
    $query_nama_siswa = mysqli_query($koneksi, "
    SELECT siswa.*, spp.nominal 
    FROM siswa 
    JOIN spp ON siswa.id_spp = spp.id_spp 
    WHERE siswa.nisn = '$nisn'");
    $data_siswa = mysqli_fetch_assoc($query_nama_siswa);
    if (!$data_siswa) {
        echo "<script>alert('Data siswa tidak ditemukan! Silakan hubungi admin.'); window.location='logout.php';</script>";
        exit();
    }
    $id_spp = $data_siswa['id_spp']; // Ambil id_spp dari hasil query sebelumnya

    $nama_siswa = $data_siswa['nama'];
    // Jika siswa mengajukan pembayaran
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bulan_dibayar = $_POST['bulan_dibayar'];
        $tahun_dibayar = $_POST['tahun_dibayar'];
        $jumlah_bayar = $data_siswa['nominal']; // nominal dari tabel spp

        // Query untuk insert data pembayaran
        $query = "INSERT INTO notifikasi_pembayaran (nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar, status) 
              VALUES ('$nisn', NOW(), '$bulan_dibayar', '$tahun_dibayar', '$id_spp', '$jumlah_bayar', 'pending')";
        if (mysqli_query($koneksi, $query)) {
            $id_pembayaran = mysqli_insert_id($koneksi); // Mendapatkan id yang baru saja diinsert
        }
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Pembayaran Anda berhasil diajukan. Tunggu konfirmasi dari admin.'); window.location='siswa-pembayaran-detail.php?id_pembayaran=$id_pembayaran&status=pending';</script>";
        } else {
            echo "<script>alert('Gagal mengajukan pembayaran. Silakan coba lagi.');</script>";
        }
    }
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Siswa - Aplikasi Pembayaran SPP</title>
     <link href="../css/bootstrap.min.css" rel="stylesheet">

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

         .sidebar .payment-item a {
             background: #6c757d;
         }

         .main-content {
             margin-left: 250px;
             padding: 20px;
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
                     <a href="siswa.php?url">
                         <i class="fa fa-user-graduate icon"></i>
                         <span class="description">Siswa</span>
                     </a>
                 </div>
                 <div class="list-item">
                     <a href="siswa.php?url=laporan">
                         <i class="fa fa-file-alt icon"></i>
                         <span class="description">Laporan</span>
                     </a>
                 </div>
                 <div class="list-item">
                     <a href="siswa.php?url=pembayaran">
                         <i class="fa fa-credit-card icon"></i>
                         <span class="description">Pembayaran SPP</span>
                     </a>
                 </div>
                 <div class="list-item">
                     <a href="siswa.php?url=logout">
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
                 Anda Login Sebagai Siswa <b><?= $_SESSION['nama'] ?></b> Aplikasi Pembayaran SPP
             </div>
             <div class="card">
                 <div class="card-body">
                     <!-- Main content here -->
                     <?php
                        $file = @$_GET['url'];
                        if (empty($file)) {
                            echo "<h4>Selamat Datang Di Halaman Siswa</h4>";
                            echo "Aplikasi Pembayaran SPP digunakan untuk mempermudah dalam mencatat pembayaran siswa/siswi di sekolah";
                            echo "<hr>";
                            include 'history-pembayaran.php';
                        } elseif ($file == 'pembayaran') {
                        ?>
                         <h4>Form Pembayaran SPP</h4>
                         <form action="" method="POST">
                             <div class="form-group">
                                 <label for="bulan_dibayar">Bulan Dibayar</label>
                                 <select name="bulan_dibayar" class="form-control" required>
                                     <option value="">Pilih Bulan</option>
                                     <?php
                                        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        foreach ($bulan as $b) {
                                            echo "<option value='$b'>$b</option>";
                                        }
                                        ?>
                                 </select>
                             </div>
                             <div class="form-group">
                                 <label for="tahun_dibayar">Tahun Dibayar</label>
                                 <input type="number" name="tahun_dibayar" class="form-control" placeholder="Masukkan Tahun" required>
                             </div>
                             <div class="form-group">
                                 <label>Jumlah Bayar</label>
                                 <input type="text" class="form-control" value="Rp<?php echo number_format($data_siswa['nominal'], 2); ?>" readonly>
                             </div>
                             <br>
                             <button type="submit" class="btn btn-primary">Ajukan Pembayaran</button>
                         </form>
                     <?php
                        } elseif ($file == 'laporan') {
                            include 'laporan.php';
                        } ?>
                     <hr>
                     <?php
                        if (empty($file)) { // Hanya tampilkan status pembayaran di halaman utama
                        ?>
                         <!-- Status Pembayaran -->
                         <h4>Status Pembayaran Anda</h4>
                         <?php
                            $query_status = "SELECT * FROM notifikasi_pembayaran WHERE nisn = '$nisn' ORDER BY tgl_bayar DESC";
                            $result_status = mysqli_query($koneksi, $query_status);

                            if (mysqli_num_rows($result_status) > 0) { ?>
                             <table class="table table-bordered">
                                 <thead>
                                     <tr>
                                         <th>Bulan</th>
                                         <th>Tahun</th>
                                         <th>Jumlah</th>
                                         <th>Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php while ($row = mysqli_fetch_assoc($result_status)) { ?>
                                         <tr>
                                             <td><?php echo $row['bulan_dibayar']; ?></td>
                                             <td><?php echo $row['tahun_dibayar']; ?></td>
                                             <td>Rp<?php echo number_format($row['jumlah_bayar'], 2); ?></td>
                                             <td><?php echo ucfirst($row['status']); ?></td>
                                         </tr>
                                     <?php } ?>
                                 </tbody>
                             </table>
                         <?php } else { ?>
                             <p>Belum ada pembayaran yang diajukan.</p>
                     <?php }
                        }
                        ?>
                 </div>
             </div>
         </div>
         <!-- Footer -->
         <div class="footer">
             &copy; <?php echo date("Y"); ?> Aplikasi Pembayaran SPP Tunas Bangsa
         </div>
     </div>
     </div>
     </div>
     <script src="../js/bootstrap.bundle.min.js"></script>
     <script>
         function toggleSidebar() {
             const sidebar = document.querySelector('.sidebar');
             const mainContent = document.querySelector('.main-content');
             const showSidebarButton = document.getElementById('show-sidebar-button');
             const footer = document.querySelector('.footer');

             sidebar.classList.toggle('hide');
             mainContent.classList.toggle('hide');

             if (sidebar.classList.contains('hide')) {
                 showSidebarButton.classList.add('show');
                 footer.classList.add('hide-sidebar'); // Menambahkan class untuk lebar penuh footer
             } else {
                 showSidebarButton.classList.remove('show');
                 footer.classList.remove('hide-sidebar'); // Menghapus class agar footer kembali normal
             }
         }
     </script>
 </body>

 </html>