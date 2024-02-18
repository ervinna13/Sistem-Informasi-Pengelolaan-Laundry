<?php
// Sertakan file koneksi
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah ID transaksi ada dalam request dan tidak kosong
    if (isset($_POST['id_transaksi']) && !empty($_POST['id_transaksi'])) {
        $id_transaksi = $_POST['id_transaksi'];
        
        // Ambil nilai status dan status bayar dari form
        $status = $_POST['status'];
        $dibayar = $_POST['dibayar'];
        
        // Buat query UPDATE untuk memperbarui status dan status bayar transaksi
        $query_update_transaksi = "UPDATE transaksi SET status = '$status', dibayar = '$dibayar' WHERE id_transaksi = '$id_transaksi'";
        
        // Lakukan update data
        if ($conn->query($query_update_transaksi) === TRUE) {
            // Redirect kembali ke halaman transaksi.php dengan pesan sukses
            echo '<script>alert("Data transaksi berhasil diperbarui!"); window.location.href = "transaksi.php";</script>';
            exit;
        } else {
            // Tampilkan pesan error jika query tidak berhasil
            echo "Error: " . $query_update_transaksi . "<br>" . $conn->error;
        }
    } else {
        // Tampilkan pesan error jika ID transaksi tidak ada dalam request
        echo "Invalid request!";
    }
} else {
    // Tampilkan pesan error jika request bukan metode POST
    echo "Invalid request method!";
}
?>
