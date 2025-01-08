<?php

include 'config/koneksi.php';

// Array data kamar
$kamar_data = [
    ['101', 'Regular', 500000, 'tersedia'],
    ['102', 'Regular', 500000, 'tersedia'],
    ['103', 'Regular', 500000, 'tersedia'],
    ['201', 'Luxury', 1000000, 'tersedia'],
    ['202', 'Luxury', 1000000, 'tersedia'],
    ['203', 'Luxury', 1000000, 'tersedia'],
    ['301', 'President', 2000000, 'tersedia'],
    ['302', 'President', 2000000, 'tersedia'],
    ['104', 'Regular', 500000, 'tersedia']
];

foreach ($kamar_data as $kamar) {
    $nomor_kamar = $kamar[0];
    $tipe_kamar = $kamar[1];
    $harga = $kamar[2];
    $status = $kamar[3];

    // Cek apakah nomor kamar sudah ada
    $query_check = "SELECT * FROM kamar WHERE nomor_kamar = '$nomor_kamar'";
    $result_check = $koneksi->query($query_check);

    if ($result_check->num_rows == 0) {
        $query_insert_kamar = "INSERT INTO kamar (nomor_kamar, tipe_kamar, harga, status) VALUES ('$nomor_kamar', '$tipe_kamar', $harga, '$status')";
        if ($koneksi->query($query_insert_kamar) === TRUE) {
            echo "Data kamar nomor $nomor_kamar berhasil ditambahkan<br>";
        } else {
            echo "Error: " . $koneksi->error . "<br>";
        }
    } else {
        echo "Nomor Kamar $nomor_kamar sudah ada.<br>";
    }
}

// Tampilkan data kamar
$query_show = "SELECT * FROM kamar";
$result = $koneksi->query($query_show);

if ($result->num_rows > 0) {
    echo "<h2>Daftar Kamar:</h2>";
    echo "<table border='1'>
            <tr>
                <th>Nomor Kamar</th>
                <th>Tipe Kamar</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["nomor_kamar"] . "</td>
                <td>" . $row["tipe_kamar"] . "</td>
                <td>Rp " . number_format($row["harga"],0,',','.') . "</td>
                <td>" . $row["status"] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$koneksi->close();
?>