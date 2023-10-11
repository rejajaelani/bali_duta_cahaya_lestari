<?php
session_start();

include "./controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) == true) {
    header("Location: ./dashboard/");
    exit;
}

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';


// echo $_SESSION['isLogin'];
// Data sesuai dengan session login_status, tidak perlu mengarahkan
// Anda dapat melanjutkan eksekusi kode jika pengguna memiliki akses yang valid
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bali Duta Cahaya Lestari | Log in</title>
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
                <form action="controller/login.php" method="post">
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