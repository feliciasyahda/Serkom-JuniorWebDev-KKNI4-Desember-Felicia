<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beasiswa";

// Membuat Koneksi pada database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek apabila koneksi pada database gagal
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>