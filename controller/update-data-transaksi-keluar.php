<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_transaksi = mysqli_escape_string($conn, $_POST['id-transaksi']);
    $tgl = mysqli_escape_string($conn, $_POST['date']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $type_transaksi = mysqli_escape_string($conn, $_POST['type-transaksi']);

    $sql = "UPDATE tb_transaksi_keluar SET tgl_trans_keluar = '$tgl', keterangan = '$keterangan', type_transaksi = $type_transaksi, update_at = '$tgl_now' WHERE id_transaksi_keluar = '$id_transaksi'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $sqldel = "DELETE FROM tb_detail_trans_keluar WHERE id_transaksi_keluar = '$id_transaksi'";
        $resultdel = mysqli_query($conn, $sqldel);

        if (!$resultdel) {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        }

        $_SESSION['msg-f'] = [
            'key' => 'Data transaksi masuk gagal diupdate' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }
    if ($result) {
        $sqlJurnal = "UPDATE tb_jurnal SET tgl_jurnal = '$tgl', keterangan = '$keterangan', type_transaksi = $type_transaksi, update_at = '$tgl_now' WHERE id_jurnal = '$id_transaksi'";
        $resultJurnal = mysqli_query($conn, $sqlJurnal);
        if (!$resultJurnal) {
            $sqlDelJurnal = "DELETE FROM tb_jurnal WHERE id_jurnal = '$id_transaksi'";
            $resultDelJurnal = mysqli_query($conn, $sqlDelJurnal);

            if (!$resultDelJurnal) {
                $_SESSION['msg-f'] = [
                    'key' => 'Error : ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
                exit;
            }

            $_SESSION['msg-f'] = [
                'key' => 'Data transaksi masuk gagal diupdate' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/");
            exit;
        }
        $_SESSION['msg'] = [
            'key' => 'Data transaksi masuk berhasil diupdate',
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }
}
