<?php

session_start();

include "./KoneksiController.php";

$id = mysqli_real_escape_string($conn, $_POST['id']);

$sqlcek = "SELECT id_akun FROM tb_detail_jurnal WHERE id_akun = " . $id;
$resultcek = mysqli_query($conn, $sqlcek);

if ($resultcek) {
    $jumlahBaris = mysqli_num_rows($resultcek);

    if ($jumlahBaris > 0) {
        $_SESSION['msg-f'] = [
            'key' => 'Akun tidak bisa dihapus karena sudah digunakan dalam transaksi. Hapus terlebih dahulu transaksi yang menggunakan akun yang ingin di hapus!',
            'timestamp' => time()
        ];
        header("Location: ../data-akun/");
        exit;
    } else {
        $sql = "DELETE FROM tb_akun WHERE id_akun = '$id'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-akun/");
            exit;
        }

        $_SESSION['msg'] = [
            'key' => 'Akun berhasil di delete',
            'timestamp' => time()
        ];
        header("Location: ../data-akun/");
        exit;
    }
} else {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-akun/");
    exit;
}
