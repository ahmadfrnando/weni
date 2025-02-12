<?php 

// $nisn = $_POST['nisn'];
// $nis = $_POST['nis'];

// include 'koneksi.php';
// $sql = "SELECT*FROM siswa WHERE nisn='$nisn' AND nis='$nis'";
// $query = mysqli_query($koneksi, $sql);
// if(mysqli_num_rows($query)>0){
//     session_start();
//     $data = mysqli_fetch_array($query);
//     $_SESSION['nama'] = $data['nama'];
//     $_SESSION['nisn'] = $data['nisn'];

//     header('location:siswa/siswa.php');
//     } else{
//         echo "<script>alert('Maaf Anda Gagal Login, Silahkan Coba Lagi');
//         window.location.assign('index.php') ;
//         </script>";
//     }

session_start(); // HARUS DITARUH DI PALING AWAL

$nisn = $_POST['nisn'];
$nis = $_POST['nis'];

include 'koneksi.php';

// Cegah SQL Injection
$nisn = mysqli_real_escape_string($koneksi, $nisn);
$nis = mysqli_real_escape_string($koneksi, $nis);

$sql = "SELECT * FROM siswa WHERE nisn='$nisn' AND nis='$nis'";
$query = mysqli_query($koneksi, $sql);

if(mysqli_num_rows($query) > 0){
    $data = mysqli_fetch_assoc($query);

    // Pastikan session ID unik setiap login
    session_regenerate_id(true);

    $_SESSION['nama'] = $data['nama'];
    $_SESSION['nisn'] = $data['nisn'];

    // Redirect ke halaman siswa
    header('Location: siswa/siswa.php');
    exit();
} else {
    echo "<script>
        alert('Maaf Anda Gagal Login, Silahkan Coba Lagi');
        window.location.assign('index.php');
    </script>";
    exit();
}

?>