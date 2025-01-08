<?php
include 'config/koneksi.php';

// Query untuk memasukkan data kamar
$query_insert_kamar = "INSERT INTO kamar (nomor_kamar, tipe_kamar, harga, status) VALUES 
    ('101', 'Regular', 500000, 'tersedia'),
    ('102', 'Regular', 500000, 'tersedia'),
    ('103', 'Regular', 500000, 'tersedia'),
    ('201', 'Luxury', 1000000, 'tersedia'),
    ('202', 'Luxury', 1000000, 'tersedia'),
    ('203', 'Luxury', 1000000, 'tersedia'),
    ('301', 'President', 2000000, 'tersedia'),
    ('302', 'President', 2000000, 'tersedia')";

// Eksekusi query
if ($koneksi->query($query_insert_kamar) === TRUE) {
    echo "Data kamar berhasil ditambahkan";
} else {
    echo "Error: " . $query_insert_kamar . "<br>" . $koneksi->error;
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