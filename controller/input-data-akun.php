<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $id_akun = mysqli_escape_string($conn, $_POST['kode-akun']);
    $nama_akun = mysqli_escape_string($conn, $_POST['nama']);
    $kategori_akun = mysqli_escape_string($conn, $_POST['kategori-akun']);
    $sifat_akun = mysqli_escape_string($conn, $_POST['sifat-akun']);

    $sql_cek_kategori = "SELECT id_kategori_akun FROM tb_kategori_akun WHERE id_kategori_akun = '$kategori_akun'";
    $result_cek_kategori = mysqli_query($conn, $sql_cek_kategori);

    if ($result_cek_kategori->num_rows > 0) {
        $sql_cek = "SELECT id_akun FROM tb_akun WHERE id_akun = '$id_akun'";
        $result_cek = mysqli_query($conn, $sql_cek);

        if ($result_cek->num_rows > 0) {
            $_SESSION['msg-w'] = [
                'key' => 'Kode akun sudah terdaftar',
                'timestamp' => time()
            ];
            header("Location: ../data-akun/");
            exit;
        } else {
            date_default_timezone_set('Asia/Makassar');
            $tgl_now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tb_akun (id_akun, nama, id_kategori_akun, sifat, created_at) VALUES('$id_akun', '$nama_akun', $kategori_akun, '$sifat_akun', '$tgl_now')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['msg'] = [
                    'key' => 'Data akun berhasil didaftarkan',
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
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-akun/");
        exit;
    }
}
