<?php

include ($type_page == 1) ? '../controller/KoneksiController.php' : '../../controller/KoneksiController.php';

function getKategoriAkun()
{
    global $conn;

    $data = [];

    $sql = "SELECT * FROM tb_kategori_akun";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Gunakan [] untuk menambahkan $row ke dalam $data
        }
    } else {
        // Handle kesalahan saat menjalankan query
        echo "Error: " . mysqli_error($conn);
    }

    return $data;
}
