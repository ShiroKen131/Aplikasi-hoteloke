<?php
session_start();
include 'config/koneksi.php';

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data kamar yang tersedia
$query_kamar = "SELECT * FROM kamar WHERE status = 'tersedia' ORDER BY tipe_kamar";
$result_kamar = $koneksi->query($query_kamar);

// Proses form jika ada POST request
if(isset($_POST['pesan_kamar'])) {
    $kamar_id = $_POST['kamar_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    
    // Proses reservasi disini
    // ...
}

$query_kamar = "SELECT * FROM kamar WHERE status = 'tersedia'";
$result_kamar = $koneksi->query($query_kamar);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Kamar Hotel</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        select, input {
            padding: 8px;
            width: 200px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Form Reservasi Kamar</h2>
    
    <form method="post" action="">
        <div class="form-group">
            <label>Pilih Kamar:</label><br>
            <select name="kamar_id" required>
                <option value="">-- Pilih Kamar --</option>
                <?php
                if ($result_kamar->num_rows > 0) {
                    while($kamar = $result_kamar->fetch_assoc()) {
                        echo "<option value='" . $kamar['id'] . "'>";
                        echo "No. " . $kamar['nomor_kamar'] . 
                             " - " . $kamar['tipe_kamar'] . 
                             " (Rp " . number_format($kamar['harga'], 0, ',', '.') . "/malam)";
                        echo "</option>";
                    }
                } else {
                    echo "<option disabled>Tidak ada kamar tersedia</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Check-in:</label><br>
            <input type="date" name="check_in" required min="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="form-group">
            <label>Tanggal Check-out:</label><br>
            <input type="date" name="check_out" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>

        <button type="submit" name="pesan_kamar">Pesan Kamar</button>
    </form>

    <!-- Tampilkan daftar kamar yang tersedia -->
    <h3>Daftar Kamar Tersedia</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nomor Kamar</th>
            <th>Tipe Kamar</th>
            <th>Harga per Malam</th>
            <th>Status</th>
        </tr>
        <?php
        // Reset pointer hasil query
        $result_kamar->data_seek(0);
        while($kamar = $result_kamar->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $kamar['nomor_kamar'] . "</td>";
            echo "<td>" . $kamar['tipe_kamar'] . "</td>";
            echo "<td>Rp " . number_format($kamar['harga'], 0, ',', '.') . "</td>";
            echo "<td>" . $kamar['status'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>