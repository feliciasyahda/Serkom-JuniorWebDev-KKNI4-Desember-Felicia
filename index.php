<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beasiswa Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #A71C1C; /* Warna utama Universitas Telkom */
        }
        .navbar a {
            color: #FFFFFF !important;
            margin-right: 15px;
            font-size: 18px;
        }
        .navbar .form-control {
            max-width: 300px;
        }
        .main-content {
            flex-grow: 1;
            background-color: #F4F4F9; /* Warna background yang lebih lembut */
            padding: 40px;
            box-sizing: border-box;
        }
        .main-content h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #A71C1C; /* Warna teks utama */
        }
        .main-content p {
            font-size: 18px;
        }
        footer {
            background-color: #A71C1C;
            color: #FFFFFF;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Beasiswa Universitas Telkom Purwokerto</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="index.php?page=home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=pilihan_beasiswa">Pilihan Beasiswa</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=daftar_beasiswa">Daftar Beasiswa</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=hasil_beasiswa">Hasil Beasiswa</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            
            switch ($page) {
                case 'home':
                    include 'home.php';
                    break;
                case 'pilihan_beasiswa':
                    include 'pilihan_beasiswa.php';
                    break;
                case 'beasiswa_akademik':
                    include 'beasiswa_akademik.php';
                    break;
                case 'beasiswa_non-akademik':
                    include 'beasiswa_non-akademik.php';
                    break;
                case 'beasiswa_internal':
                    include 'beasiswa_internal.php';
                    break;
                case 'daftar_beasiswa':
                    include 'daftar_beasiswa.php';
                    break;
                case 'hasil_beasiswa':
                    include 'hasil_beasiswa.php';
                    break;
                default:
                    echo "<h1>Page Not Found</h1>";
            }
        } else {
            include 'home.php';
        }
        ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Beasiswa Application</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>