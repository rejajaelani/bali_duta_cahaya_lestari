<?php
session_start();

include "controller/KoneksiController.php"; // Pastikan Anda memasukkan file yang benar

if (isset($_SESSION['login_status'])) {
    $sql = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Pengguna tidak memiliki akses yang valid, arahkan kembali ke halaman login atau halaman lain yang sesuai
        header("Location: dashboard/");
        exit; // Pastikan untuk menghentikan eksekusi kode setelah pengalihan
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
}


// Data sesuai dengan session login_status, tidak perlu mengarahkan
// Anda dapat melanjutkan eksekusi kode jika pengguna memiliki akses yang valid
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalXtreme | Log in</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <section class="container">
        <div class="wrapper">
            <div class="image">
                <img src="images/logo.png" alt="">
            </div>
            <div class="form-login">
                <?php
                if ($msg != '') { ?>
                    <div style="font-weight: bold;padding: 2px 10px;background-color: #FF6969;border-radius: 10px;"><?= $msg ?></div>
                <?php } ?>
                <form action="controller/LoginController.php" method="post">
                    <p style="text-align: center;">Welcome to</p>
                    <p style="text-align: center;font-weight: bold;">PT. XXXX</p>
                    <input type="email" name="email" id="email" placeholder="Alamat Email" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button>Login</button>
                    <a href="#">Forgot password?</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>