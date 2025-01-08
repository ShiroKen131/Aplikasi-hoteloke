<?php
session_start();
include 'config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data kamar yang tersedia
$query_kamar = "SELECT * FROM kamar WHERE status = 'tersedia'";
$result_kamar = $koneksi->query($query_kamar);

// Proses reservasi
if (isset($_POST['pesan_kamar'])) {
    $user_id = $_SESSION['user_id'];
    $kamar_id = $_POST['kamar_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $jumlah_hari = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
    
    // Ambil harga kamar
    $query_harga = "SELECT harga FROM kamar WHERE id = ?";
    $stmt = $koneksi->prepare($query_harga);
    $stmt->bind_param("i", $kamar_id);
    $stmt->execute();
    $result_harga = $stmt->get_result();
    $harga_kamar = $result_harga->fetch_assoc()['harga'];
    
    // Hitung total harga
    $total_harga = $harga_kamar * $jumlah_hari;
    
    // Insert data reservasi
    $query_reservasi = "INSERT INTO reservasi (user_id, kamar_id, tanggal_check_in, tanggal_check_out, total_harga) 
                       VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query_reservasi);
    $stmt->bind_param("iissd", $user_id, $kamar_id, $check_in, $check_out, $total_harga);
    
    if ($stmt->execute()) {
        // Update status kamar
        $update_kamar = "UPDATE kamar SET status = 'dipesan' WHERE id = ?";
        $stmt = $koneksi->prepare($update_kamar);
        $stmt->bind_param("i", $kamar_id);
        $stmt->execute();
        
        $sukses = "Reservasi berhasil dilakukan!";
    } else {
        $error = "Gagal melakukan reservasi";
    }
}

// Ambil riwayat reservasi user
$user_id = $_SESSION['user_id'];
$query_riwayat = "SELECT r.*, k.nomor_kamar, k.tipe_kamar, k.harga 
                  FROM reservasi r 
                  JOIN kamar k ON r.kamar_id = k.id 
                  WHERE r.user_id = ?
                  ORDER BY r.id DESC";
$stmt = $koneksi->prepare($query_riwayat);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_riwayat = $stmt->get_result();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Kamar</title>
    <style>
        .container { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; }
        .success { color: green; }
        .error { color: red; }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .button:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Reservasi Kamar</h2>
        
        <?php if (isset($sukses)) echo "<p class='success'>$sukses</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="post" action="">
        <div class="form-group">
            <label>Pilih Kamar:</label>
            <select name="kamar_id" required>
                <option value="">Pilih Kamar</option>
                <?php 
                // Reset pointer query ke awal
                if($result_kamar->num_rows > 0){
                    while ($kamar = $result_kamar->fetch_assoc()): 
                ?>
                    <option value="<?php echo $kamar['id']; ?>">
                        <?php echo "No. " . $kamar['nomor_kamar'] . 
                                  " - " . $kamar['tipe_kamar'] . 
                                  " (Rp " . number_format($kamar['harga'], 0, ',', '.') . "/malam)"; ?>
                    </option>
                <?php 
                    endwhile; 
                } else {
                    echo "<option disabled>Tidak ada kamar tersedia</option>";
                }
                ?>
            </select>
        </div>
            
            <div class="form-group">
                <label>Tanggal Check-in:</label>
                <input type="date" name="check_in" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label>Tanggal Check-out:</label>
                <input type="date" name="check_out" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            
            <button type="submit" name="pesan_kamar" class="button">Pesan Kamar</button>
        </form>
        
        <h2>Riwayat Reservasi</h2>
        <table>
            <tr>
                <th>No. Kamar</th>
                <th>Tipe Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
            <?php while ($reservasi = $result_riwayat->fetch_assoc()): ?>
            <tr>
                <td><?php echo $reservasi['nomor_kamar']; ?></td>
                <td><?php echo $reservasi['tipe_kamar']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($reservasi['tanggal_check_in'])); ?></td>
                <td><?php echo date('d/m/Y', strtotime($reservasi['tanggal_check_out'])); ?></td>
                <td>Rp <?php echo number_format($reservasi['total_harga'], 0, ',', '.'); ?></td>
                <td><?php echo $reservasi['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <br>
        <a href="dashboard.php" class="button">Kembali ke Dashboard</a>
    </div>
</body>
</html>