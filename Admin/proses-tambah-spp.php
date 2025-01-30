<?php

$tahun = $_POST['tahun'];
$jenjang = $_POST['jenjang'];
$nominal = $_POST['nominal'];

include '../koneksi.php';
$sql = "INSERT INTO spp (tahun, jenjang, nominal) VALUES ('$tahun', '$jenjang', '$nominal')";
$query = mysqli_query($koneksi, $sql);
if ($query) {
    header("Location:?url=spp");
} else {
    echo "<script>alert('Maaf Data Tidak Tersimpan'); window.location.assign('?url=spp');</script>";
}

?>
