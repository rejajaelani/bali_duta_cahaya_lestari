<?php
$serverDB = "localhost"; // Ganti dengan nama server Anda
$usernameDB = "root"; // Ganti dengan nama pengguna Anda
$passwordDB = ""; // Ganti dengan kata sandi Anda
$database = "bali_duta_cahaya_lestari"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = mysqli_connect($serverDB, $usernameDB, $passwordDB, $database);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Test Koneksi Berhasil
// echo "Koneksi Berhasil";
