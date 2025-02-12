<?php
session_start(); // Harus dipanggil di awal sebelum output apapun

include 'koneksi.php';

// Cegah SQL Injection
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// Ambil data pengguna berdasarkan username
$sql = "SELECT * FROM petugas WHERE username='$username' LIMIT 1";
$query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    // Verifikasi password (asumsikan password di database disimpan dengan password_hash)
    if ($password = $data['password']) {

        // Regenerasi session untuk keamanan
        session_regenerate_id(true);

        // Simpan data sesi
        $_SESSION['id_petugas'] = $data['id_petugas'];
        $_SESSION['nama_petugas'] = $data['nama_petugas'];
        $_SESSION['level'] = $data['level'];

        // Arahkan berdasarkan level pengguna
        if ($data['level'] == 'admin') {
            header('Location: admin/admin.php');
            exit();
        } elseif ($data['level'] == 'kepala sekolah') {
            header('Location: petugas/petugas.php');
            exit();
        } else {
            echo "<script>
                alert('Maaf Login Gagal, Silahkan Ulangi Lagi');
                window.location.assign('index2.php');
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Username atau Password Salah');
            window.location.assign('index2.php');
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('Username tidak ditemukan');
        window.location.assign('index2.php');
    </script>";
    exit();
}
?>
