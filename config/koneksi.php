<?php
// Koneksi Database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hotel_management';

// Membuat koneksi
$koneksi = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>