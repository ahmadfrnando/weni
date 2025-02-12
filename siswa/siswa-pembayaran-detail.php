<?php
// Mulai session
session_start();

// // Periksa apakah session telah terdaftar untuk username tersebut
// if(isset($_SESSION['nisn'])) {
//     // Dan jika terdaftar
//     echo 'Selamat Datang, ' . $_SESSION['nisn'] . '! Session anda telah terdaftar';
// } else {
//     // Jika tidak terdaftar, kembalikan user ke login.html
//     echo '<meta http-equiv="refresh" content="0;url=http://localhost/login.html">';
//     exit; // Pastikan tidak ada kode yang dieksekusi setelah melakukan redirect
// }


error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';
require_once '../config.php';
require_once '../config_midtrans.php'; // Pastikan file konfigurasi Midtrans sudah dibuat

// Pastikan user sudah login
if (empty($_SESSION['nisn'])) {
    echo "<script>alert('Maaf, Anda belum login!'); window.location='../index.php';</script>";
    exit();
}

// Ambil id_pembayaran dari parameter URL
if (!isset($_GET['id_pembayaran'])) {
    echo "<script>alert('ID pembayaran tidak ditemukan!'); window.location='siswa.php';</script>";
    exit();
}

$id_pembayaran = $_GET['id_pembayaran'];
$status = $_GET['status'];
$nisn = $_SESSION['nisn'];

// Query untuk mengambil data pembayaran berdasarkan id_pembayaran
$query = "SELECT np.*, s.nama 
          FROM notifikasi_pembayaran np 
          JOIN siswa s ON np.nisn = s.nisn 
          WHERE np.id = '$id_pembayaran'";

$result = mysqli_query($koneksi, $query);

// **Tambahkan pengecekan jika query gagal**
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data pembayaran tidak ditemukan!'); window.location='siswa.php';</script>";
    exit();
}

if (!$data) {
    echo "<script>alert('Data pembayaran tidak ditemukan!'); window.location='siswa.php';</script>";
    exit();
}

// Data transaksi
$nama_siswa = $data['nama'];
$jumlah_bayar = $data['jumlah_bayar'];
$bulan_dibayar = $data['bulan_dibayar'];
$tahun_dibayar = $data['tahun_dibayar'];
$id_spp = $data['id_spp'];

// Integrasi Midtrans
\Midtrans\Config::$serverKey = $MIDTRANS_SERVER_KEY;
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Buat array transaksi untuk Midtrans
$transaction_details = [
    'order_id' => "SPP-{$id_pembayaran}-" . time(),
    'gross_amount' => $jumlah_bayar,
];

$item_details = [
    [
        'id' => "SPP-{$id_pembayaran}",
        'price' => $jumlah_bayar,
        'quantity' => 1,
        'name' => "SPP Bulan $bulan_dibayar $tahun_dibayar",
    ]
];

$customer_details = [
    'first_name' => $nama_siswa,
    'email' => "siswa{$nisn}@example.com",
];

// Buat transaksi Snap Midtrans
$transaction = [
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details,
];

$snapToken = \Midtrans\Snap::getSnapToken($transaction);
?>

<!DOCTYPE html>
<html lang="id">

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

        #pay-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
                    <h2>Pembayaran SPP</h2>
                    <p>Nama Siswa: <b><?= $nama_siswa; ?></b></p>
                    <p>Bulan Dibayar: <b><?= $bulan_dibayar; ?> <?= $tahun_dibayar; ?></b></p>
                    <p>Jumlah Bayar: <b>Rp<?= number_format($jumlah_bayar, 2); ?></b></p>
                    <p>Status Bayar: <b><?= $status ?></b></p>

                    <button id="pay-button">Bayar Sekarang</button>
                    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $MIDTRANS_CLIENT_KEY ?>"></script>
                    <script type="text/javascript">
                        document.getElementById('pay-button').onclick = function() {
                            snap.pay('<?= $snapToken; ?>', {
                                onSuccess: function(result) {
                                    window.location.href = "siswa.php?url=laporan&id_pembayaran=<?= $id_pembayaran; ?>";
                                },
                                onPending: function(result) {
                                    window.location.href = "siswa-pembayaran-detail.php?id_pembayaran=<?= $id_pembayaran; ?>&status=pending";
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal!");
                                }
                            });
                        };
                    </script>
                </div>
            </div>
        </div>
</body>

</html>