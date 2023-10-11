<?php

include "../controller/KoneksiController.php";

function getDataUser()
{
    global $conn;

    $data = [];

    $sql = "SELECT * FROM tb_user";
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

function getDataUserDetail($id)
{
    global $conn;

    $data = [];

    $sql = "SELECT * FROM tb_user WHERE id_user = " . $id;
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
