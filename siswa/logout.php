<?php
session_start();
session_unset(); // Hapus semua session
session_destroy(); // Hancurkan session
echo "<script>alert('Anda berhasil logout!'); window.location='../index.php';</script>";
exit();
?>
