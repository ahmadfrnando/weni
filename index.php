<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Aplikasi Pembayaran SPP.</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to bottom right, #9EBAF3, #353A5F) no-repeat;
            /* Ganti dengan path file gambar latar belakang Anda */
            background-size: cover;
            /* Membuat gambar background mengisi seluruh layar */
            background-position: center;
            /* Posisi gambar di tengah-tengah */
        }

        .container {
            width: 420px;
            background: transparent rgba(255, 255, 255, 0.5);
            /* Warna latar belakang transparan */
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .container h4 {
            font-size: 24px;
            /* Mengurangi ukuran teks judul */
            text-align: center;
            margin-bottom: 20px;
            /* Menambahkan margin bawah */
        }

        .form-group {
            margin-bottom: 20px;
            /* Menambahkan margin bawah pada setiap form group */
        }

        .btn-primary {
            background-color: #007bff;
            /* Warna tombol login */
            border-color: #007bff;
            width: 100%;
            /* Mengatur lebar tombol */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Warna tombol saat dihover */
            border-color: #0056b3;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
            /* Menambahkan margin bawah pada container logo */
        }

        .logo {
            max-width: 320px;
            /* Mengatur ukuran logo */
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4>LOGIN SISWA</h4>
        <div class="logo-container">
            <img src="Tunas-Bangsa2.png" alt="Logo" class="logo">
        </div>
        <form action="proses-login-siswa.php" method="post">
            <div class="form-group">
                <label>NISN</label>
                <input type="number" name="nisn" class="form-control" placeholder="Masukan NISN" required>
            </div>
            <div class="form-group">
                <label>NIS</label>
                <input type="number" name="nis" class="form-control" placeholder="Masukan NIS" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><b>LOGIN</b></button>
            </div>
            <p style="text-align: center;">
                <a href="index2.php" style="color: white; font-size: 14px;">Login Sebagai Administrator / Petugas</a>
            </p>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>