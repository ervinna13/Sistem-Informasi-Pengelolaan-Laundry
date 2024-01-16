<?php
// Koneksi ke database
session_start();
include 'koneksi.php';
// Memproses data yang dikirim dari form registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan validasi input
    $username = $_POST['reg_username'];
    $password = $_POST['reg_password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Menghasilkan ID user
$id_prefix = substr($role, 0, 3); // Mengambil 3 huruf pertama dari peran
$id_random_numbers = mt_rand(1000000, 9999999); // Menghasilkan angka random 7 digit
$user_id = strtoupper($id_prefix) . $id_random_numbers; // Menggabungkan prefix dan angka random

    
    // Validasi password
    if ($password !== $confirm_password) {
        echo '<script>alert("Password tidak sesuai!"); window.location.href = "regis.php";</script>';
    } else {
        // Lakukan pengecekan apakah username sudah ada di database
        // Jika belum, simpan data pengguna baru ke database
        // Pastikan untuk menyimpan password yang dienkripsi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (id_user, username, password, role) VALUES ('$user_id','$username', '$hashed_password', '$role')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Registrasi Berhasil!"); window.location.href = "login.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
