<?php

session_start();

include "./KoneksiController.php";

$error = "Email atau Password Invalid";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_escape_string($conn, $_POST['email']);
    $password = mysqli_escape_string($conn, $_POST['password']);

    $sql = "SELECT id_user,email, password FROM tb_user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $dataUser = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['isLogin'] = true;
                $_SESSION['msg'] = '';
                $_SESSION['dataUser'] = $dataUser[] = $row;
                header("Location: ../dashboard/");
                exit;
            }
            $_SESSION['msg'] = $error;
            header("Location: ../");
            exit;
        }
    } else {
        $_SESSION['msg'] = $error;
        header("Location: ../");
        exit;
    }
}
