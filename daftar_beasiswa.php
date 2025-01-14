<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Beasiswa</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Asumsi IPK default
        const defaultIPK = 3.40; 

        // Fungsi yang akan dijalankan ketika halaman selesai dimuat
        window.onload = function () {
            // Mengambil elemen input IPK dan menetapkan nilai default
            const ipkInput = document.getElementById('ipk');
            ipkInput.value = defaultIPK.toFixed(2); // pembulatan 2 angka dibelakang koma
            validateIPK(); // Panggil fungsi validasi IPK saat halaman dimuat
        };

        // Fungsi validasi IPK
        function validateIPK() {
            const ipkInput = document.getElementById('ipk');
            const ipkValue = parseFloat(ipkInput.value);
            const message = document.getElementById('message');

            message.textContent = ''; // Reset pesan

            // Jika IPK kurang dari 3.00, tampilkan pesan dan nonaktifkan form
            if (ipkValue < 3.00) {
                message.textContent = 'IPK harus minimal 3.00 untuk mendaftar.';
                disableForm(); // Nonaktifkan form
            } else {
                enableForm(); // Aktifkan form
                message.textContent = ''; // Hapus pesan
            }
        }

        // Fungsi untuk menonaktifkan form jika IPK tidak memenuhi syarat
        function disableForm() {
            document.getElementById('pilihan_beasiswa').disabled = true;
            document.getElementById('berkas').disabled = true;
            document.querySelector('input[type="submit"]').disabled = true;
        }

        // Fungsi untuk mengaktifkan form jika IPK memenuhi syarat
        function enableForm() {
            document.getElementById('pilihan_beasiswa').disabled = false;
            document.getElementById('berkas').disabled = false;
            document.querySelector('input[type="submit"]').disabled = false;
        }

        // Fungsi untuk memperbarui persyaratan dokumen berdasarkan pilihan beasiswa
        function updateDocumentRequirement() {
            const pilihanBeasiswa = document.getElementById('pilihan_beasiswa');
            const berkasLabel = document.getElementById('berkas_label');
            const documentRequirement = document.getElementById('document_requirement');

            documentRequirement.textContent = ''; // Reset persyaratan dokumen

            // Mengubah label dan persyaratan dokumen sesuai pilihan beasiswa
            switch (pilihanBeasiswa.value) {
                case 'Beasiswa Akademik':
                    berkasLabel.textContent = 'Upload Transkrip Nilai (PDF only):';
                    documentRequirement.textContent = 'Dokumen yang diperlukan: Transkrip Nilai';
                    break;
                case 'Beasiswa Non-Akademik':
                    berkasLabel.textContent = 'Upload Sertifikat Penghargaan (PDF only):';
                    documentRequirement.textContent = 'Dokumen yang diperlukan: Sertifikat Penghargaan';
                    break;
                case 'Beasiswa Internal':
                    berkasLabel.textContent = 'Upload Kartu Keluarga (PDF only):';
                    documentRequirement.textContent = 'Dokumen yang diperlukan: Kartu Keluarga';
                    break;
                default:
                    berkasLabel.textContent = 'Upload Berkas (PDF only):';
                    break;
            }
        }
    </script>
    <style>
        /* Gaya umum untuk halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        /* Gaya untuk konten form */
        .content {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        /* Gaya untuk judul */
        h1 {
            text-align: center;
            color: #b30000;
        }
        /* Gaya untuk label input */
        label {
            display: block;
            margin: 10px 0 5px;
        }
        /* Gaya untuk input dan select */
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        /* Gaya untuk input file */
        input[type="file"] {
            padding: 5px;
        }
        /* Gaya untuk tombol submit dan button */
        input[type="submit"], input[type="button"] {
            background-color: #b30000;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }
        /* Efek hover pada tombol submit dan button */
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #a10000;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Daftar Beasiswa</h1>
        <form action="hasil_beasiswa.php" method="post" enctype="multipart/form-data" onsubmit="return validateIPK()">
            <!-- Form input Nama -->
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <!-- Form input Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <!-- Form input No HP -->
            <label for="no_hp">No HP:</label>
            <input type="number" id="no_hp" name="no_hp" pattern="[0-9]+" title="Hanya angka yang diperbolehkan." required>


            <!-- Form input Semester -->
            <label for="semester">Semester:</label>
            <select id="semester" name="semester" required onchange="setIPKBasedOnSemester()">
                <option value="" disabled selected>Pilih Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>


            <!-- Form input IPK -->
            <label for="ipk">IPK:</label>
            <input type="number" step="0.01" id="ipk" name="ipk" oninput="validateIPK()" readonly required>

            <!-- Form input Pilihan Beasiswa -->
            <label for="pilihan_beasiswa">Pilihan Beasiswa:</label>
            <select id="pilihan_beasiswa" name="pilihan_beasiswa" required onchange="updateDocumentRequirement()">
                <option value="" disabled selected>Pilih Beasiswa</option>
                <option value="Beasiswa Akademik">Beasiswa Akademik</option>
                <option value="Beasiswa Non-Akademik">Beasiswa Non&nbsp;-&nbsp;Akademik</option>
                <option value="Beasiswa Internal">Beasiswa Internal</option>
            </select>

            <!-- Label untuk Berkas yang harus diupload -->
            <label id="berkas_label" for="berkas">Upload Berkas (PDF only):</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf" required>
            
            <!-- Menampilkan persyaratan dokumen berdasarkan pilihan beasiswa -->
            <div id="document_requirement" style="font-weight: bold; margin-bottom: 15px;"></div>

            <!-- Form input untuk tombol Daftar dan Batal -->
            <div class="row text-center">
                    <div class="col">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary" style="background-color: #4CAF50;">Daftar</button>
                    </div>
                    <div class="col">
                        <button type="reset" name="reset" id="reset" class="btn btn-danger" style="background-color:  #b30000;">Batal</button>
                    </div>
            </div>
            <div id="message"></div>
        </form>
    </div>
</body>
</html>

<script>
    // Fungsi untuk mengatur IPK berdasarkan semester
function setIPKBasedOnSemester() {
    const semesterInput = document.getElementById('semester');
    const ipkInput = document.getElementById('ipk');

    // Daftar IPK berdasarkan semester
    const ipkValues = {
        1: 3.4,
        2: 4.0,
        3: 2.0,
        4: 1.0,
        5: 3.6,
        6: 3.8,
        7: 3.0,
        8: 2.9
    };

    // Perbarui nilai IPK sesuai semester yang dipilih
    const selectedSemester = semesterInput.value;
    if (ipkValues[selectedSemester]) {
        ipkInput.value = ipkValues[selectedSemester].toFixed(2);
        validateIPK(); // Validasi IPK
    }
}

</script>