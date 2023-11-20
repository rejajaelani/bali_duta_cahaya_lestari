<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_transaksi = mysqli_escape_string($conn, $_POST['id-transaksi']);
    $id_akun = mysqli_escape_string($conn, $_POST['id-akun']);
    $debet = isset($_POST['debet']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['debet']))) : 0;
    $kredit = isset($_POST['kredit']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['kredit']))) : 0;
    $type = mysqli_escape_string($conn, $_POST['type']);

    function generateUniqueID($prefix = 'PM-', $length = 6)
    {
        $characters = '0123456789';
        $randomString = $prefix;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    function isIDUnique($conn, $table, $idColumn, $id)
    {
        $query = "SELECT 1 FROM $table WHERE $idColumn = '$id'";
        $result = mysqli_query($conn, $query);

        return mysqli_num_rows($result) == 0;
    }

    // Menghasilkan ID unik
    $newID = generateUniqueID();

    // Memeriksa keunikan ID dalam tabel
    while (!isIDUnique($conn, 'tb_detail_trans_masuk', 'id', $newID)) {
        $newID = generateUniqueID();
    }

    $sql = "INSERT INTO tb_detail_trans_masuk (id, id_transaksi_masuk, id_akun, debet, kredit, update_at) VALUES('$newID', '$id_transaksi', '$id_akun', $debet, $kredit, '$tgl_now')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Data detail transaksi masuk gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        if ($type == 1) {
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        } else {
            header("Location: ../data-transaksi/edit-data-pemasukan/?id=$id_transaksi");
            exit;
        }
    }

    if ($result) {
        $sqlJurnal = "INSERT INTO tb_detail_jurnal (id, id_jurnal, id_akun, debet, kredit, update_at) VALUES('$newID', '$id_transaksi', '$id_akun', $debet, $kredit, '$tgl_now')";
        $resultJurnal = mysqli_query($conn, $sqlJurnal);
        if (!$resultJurnal) {
            $_SESSION['msg-f'] = [
                'key' => 'Data detail transaksi masuk gagal ditambahkan' . mysqli_error($conn),
                'timestamp' => time()
            ];
            if ($type == 1) {
                header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
                exit;
            } else {
                header("Location: ../data-transaksi/edit-data-pemasukan/?id=$id_transaksi");
                exit;
            }
        }
        $_SESSION['msg'] = [
            'key' => 'Data detail transaksi masuk berhasil ditambahkan',
            'timestamp' => time()
        ];
        if ($type == 1) {
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        } else {
            header("Location: ../data-transaksi/edit-data-pemasukan/?id=$id_transaksi");
            exit;
        }
    }
}
