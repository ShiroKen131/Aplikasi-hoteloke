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
if (isset($_POST['pesan_kamar'])) {
    $username = $_SESSION['username']; // Pastikan session username sudah tersedia
    $kamar_id = $_POST['kamar_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    
    // Ambil harga per malam dari tabel kamar
    $query_harga = "SELECT harga FROM kamar WHERE id = ?";
    $stmt = $koneksi->prepare($query_harga);
    $stmt->bind_param("i", $kamar_id);
    $stmt->execute();
    $stmt->bind_result($harga_per_malam);
    $stmt->fetch();
    $stmt->close();
    
    // Hitung jumlah hari
    $tanggal_check_in = new DateTime($check_in);
    $tanggal_check_out = new DateTime($check_out);
    $jumlah_hari = $tanggal_check_in->diff($tanggal_check_out)->days;

    // Hitung total harga
    $total_harga = $jumlah_hari * $harga_per_malam;

    // Query untuk memasukkan data reservasi
    $insert_query = "INSERT INTO reservasi (username, kamar_id, tanggal_check_in, tanggal_check_out, total_harga) 
                     VALUES (?, ?, ?, ?, ?)";
    
    $stmt_insert = $koneksi->prepare($insert_query);
    $stmt_insert->bind_param("sissd", $username, $kamar_id, $check_in, $check_out, $total_harga);
    
    if ($stmt_insert->execute()) {
        // Update status kamar menjadi dipesan
        $update_kamar = "UPDATE kamar SET status = 'dipesan' WHERE id = ?";
        $stmt_update = $koneksi->prepare($update_kamar);
        $stmt_update->bind_param("i", $kamar_id);
        $stmt_update->execute();
        
        echo "Reservasi berhasil dilakukan!";
        
        // Refresh halaman untuk memperbarui daftar kamar
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $stmt_insert->error;
    }
}
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