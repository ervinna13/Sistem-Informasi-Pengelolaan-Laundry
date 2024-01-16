<?php
// Koneksi ke database
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan pengecekan terhadap database untuk mencocokkan informasi login
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Jika username dan password cocok, set session dan redirect ke halaman sesuai dengan peran (role)
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['role'] = $row['role'];

            // Redirect sesuai dengan peran
    if ($_SESSION['role'] === 'admin') {
        echo '<script>alert("Login Berhasil sebagai Admin!"); window.location.href = "index.php";</script>';
    } elseif ($_SESSION['role'] === 'kasir') {
        echo '<script>alert("Login Berhasil sebagai Kasir!"); window.location.href = "kasir_dashboard.php";</script>';
    } elseif ($_SESSION['role'] === 'owner') {
        echo '<script>alert("Login Berhasil sebagai Owner!"); window.location.href = "owner_dashboard.php";</script>';
    } else {
        echo '<script>alert("Login Berhasil!"); window.location.href = "dashboard.php";</script>';
    }
    exit();
        } else {
            echo '<script>alert("Username atau Password salah!"); window.location.href = "login.php";</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan!"); window.location.href = "login.php";</script>';
        
    }
}
?>
