<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $nama_akun = mysqli_escape_string($conn, $_POST['nama']);

    $sql_cek = "SELECT nama_kategori FROM tb_kategori_akun WHERE nama_kategori = '$nama_akun'";
    $result_cek = mysqli_query($conn, $sql_cek);

    if ($result_cek->num_rows > 0) {
        $_SESSION['msg-w'] = [
            'key' => 'Nama akun sudah terdaftar',
            'timestamp' => time()
        ];
        header("Location: ../data-akun/");
        exit;
    } else {
        date_default_timezone_set('Asia/Makassar');
        $tgl_now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tb_kategori_akun (nama_kategori, created_at) VALUES('$nama_akun', '$tgl_now')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = [
                'key' => 'Data kategori akun berhasil didaftarkan',
                'timestamp' => time()
            ];
            header("Location: ../data-akun/");
            exit;
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-akun/");
            exit;
        }
    }
}
