<?php
session_start(); // Untuk Memulai sesi

// Koneksi kan pada database
require 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $semester = $_POST['semester'];
    $ipk = $_POST['ipk'];
    $pilihan_beasiswa = $_POST['pilihan_beasiswa'];

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { // Fungsi untuk memeriksa directory
        mkdir($target_dir, 0777, true); // Membuka akses keseluruhanya
    }
    
    $target_file = $target_dir . basename($_FILES["berkas"]["name"]);
    $uploadOk = 1; 
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($fileType != "pdf") {
        echo "<div class='alert'>Sorry, only PDF files are allowed.</div>";
        $uploadOk = 0; 
    }

    // Mengupload file/berkas
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["berkas"]["tmp_name"], $target_file)) {
            // Pre-existing conn, upload
            $stmt = $conn->prepare("INSERT INTO mahasiswa (nama, email, no_hp, semester, ipk, pilihan_beasiswa, berkas) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nama, $email, $no_hp, $semester, $ipk, $pilihan_beasiswa, $target_file); // Parameter

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Form submitted successfully.";
            } else {
                echo "<div class='alert'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

// Menampilkan data hasil pendaftaran
$stmt = $conn->prepare("SELECT * FROM mahasiswa ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

// Array kosong
$beasiswa_counts = [];
$nama_data = [];

while ($row = $result->fetch_assoc()) { // Array assosiatif dg key = row
    $pilihan_beasiswa = $row['pilihan_beasiswa'];
    if (isset($beasiswa_counts[$pilihan_beasiswa])) { // Mengecekan jika sudah ada pada array tidak
        $beasiswa_counts[$pilihan_beasiswa]++;
    } else {
        $beasiswa_counts[$pilihan_beasiswa] = 1; // Inisialisasi pertama kali muncul
    }
    
    $nama_data[] = $row['nama'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Beasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7fc;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .content {
        max-width: 1200px;
        margin: 40px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    h1 {
        font-size: 24px;
        color:rgb(255, 0, 0);
        text-align: center;
        margin-bottom: 30px;
    }
    .alert {
        background-color: #d4edda;
        color:rgb(224, 60, 60);
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid rgb(230, 195, 195);
        border-radius: 5px;
        font-size: 14px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    th {
        background-color:rgb(255, 0, 0); 
        color: white;
        font-weight: 500;
    }
    tr:nth-child(even) {
        background-color: #ecf6fc;
    }
    .chart-container {
        margin: 20px 0;
        text-align: center;
    }
    .back-button {
        margin-top: 20px;
        text-align: center;
    }
    .back-button a {
        text-decoration: none;
    }
    .back-button button {
        background-color:rgb(255, 0, 0); 
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.3s ease;
    }
    .back-button button i {
        margin-right: 8px;
    }
    .back-button button:hover {
        background-color:rgb(255, 0, 0); 
    }
    canvas {
        max-width: 80%;
        height: auto;
    }
</style>
</head>
<body>
<div class="content">
    <h1>Hasil Beasiswa</h1>
    
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='alert'>" . $_SESSION['success_message'] . "</div>";
        unset($_SESSION['success_message']);
    }
    ?>

    <!-- Grafik jumlah pendaftar per beasiswa -->
    <div class="chart-container">
        <canvas id="beasiswaChart"></canvas>
    </div>

    <?php

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Nama</th><th>Email</th><th>No HP</th><th>Semester</th><th>IPK</th><th>Pilihan Beasiswa</th><th>Status Ajuan</th><th>Berkas</th></tr>";

        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {


            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
            echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ipk']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pilihan_beasiswa']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status_ajuan']) . "</td>";
            echo "<td><a href='" . htmlspecialchars($row['berkas']) . "' target='_blank'>Download Berkas</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='alert'>No applications found.</div>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <!-- Tombol Kembali ke Halaman Home -->
    <div class="back-button">
        <a href="index.php">
            <button><i class="fas fa-home"></i> Kembali ke Halaman Home</button>
        </a>
    </div>
</div>

<script>
    // Mengambil data php ke js
    var beasiswaLabels = <?php echo json_encode(array_keys($beasiswa_counts)); ?>;
    var beasiswaCounts = <?php echo json_encode(array_values($beasiswa_counts)); ?>;

    var ctx = document.getElementById('beasiswaChart').getContext('2d');
    var beasiswaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: beasiswaLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: beasiswaCounts,
                backgroundColor: '#ccff00', 
                borderColor: '#2980b9', 
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // Diawali dari titik 0
                    ticks: {
                        stepSize: 1, // Sumbu y meningkat tiap 1 unit (bilangan bulat)
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
