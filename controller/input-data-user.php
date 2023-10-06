<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    $targetDirectory = "../images/"; // Folder tempat menyimpan file yang diunggah
    $randomFileName = uniqid() . "_" . time(); // Membuat nama file acak

    // Mendapatkan informasi tentang file yang diunggah
    $fileName = $_FILES["foto"]["name"];
    $fileSize = $_FILES["foto"]["size"];
    $fileTmpName = $_FILES["foto"]["tmp_name"];
    $fileType = $_FILES["foto"]["type"];
    $fileError = $_FILES["foto"]["error"];

    $foto = $randomFileName . "." . pathinfo($fileName, PATHINFO_EXTENSION);

    // Menentukan tipe-tipe file gambar yang diperbolehkan
    $allowedImageTypes = array("image/jpeg", "image/png", "image/gif");

    $sql = "INSERT INTO tb_user (nama, email, username, password, level, status, foto) VALUES ('$nama', '$email', '$username', '$password', '$level', 1, '$foto')";
    // Memeriksa tipe file yang diunggah
    if (in_array($fileType, $allowedImageTypes)) {
        // Memeriksa apakah terdapat error saat mengunggah
        if ($fileError === 0) {
            // Membuat path lengkap untuk menyimpan file
            $filePath = $targetDirectory . $randomFileName . "." . pathinfo($fileName, PATHINFO_EXTENSION);

            // Memindahkan file ke folder tujuan
            if (move_uploaded_file($fileTmpName, $filePath)) {
                if ($result = mysqli_query($conn, $sql)) {
                    if ($level == 1) {
                        header("Location: ../data-user/pimpinan/");
                        exit;
                    } else if ($level == 2) {
                        header("Location: ../data-user/admin/");
                        exit;
                    } else {
                        header("Location: ../data-user/akunting/");
                        exit;
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            echo "Terjadi error saat mengunggah file.";
        }
    } else {
        echo "Tipe file tidak valid. Hanya file gambar (jpeg, png, gif) yang diperbolehkan.";
    }
}
