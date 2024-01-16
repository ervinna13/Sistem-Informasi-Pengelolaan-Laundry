<?php
// Pastikan session dimulai
session_start();

// Cek apakah ada sesi yang sudah terautentikasi (sesi user_id atau sesi lain yang menandakan login)
if (isset($_SESSION['user_id'])) {
    // Jika ada sesi yang sudah ada, arahkan pengguna ke halaman lain (misalnya halaman utama)
    header("Location: index.php"); // Ganti 'index.php' dengan halaman yang sesuai
    exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan pengguna
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="login_template/style.css" />
    <title>Sign in & Sign up Form</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="proses_login.php" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" />
                    </div>
                    <input type="submit" value="Login" class="btn solid" />

                </form>
                <form action="proses_registrasi.php" method="post" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" name="reg_username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="reg_password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Confirm Password" name="confirm_password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <select name="role" required>
                            <option value="" selected disabled>Select Role</option>
                            <?php
                            include 'koneksi.php';
                            $roles = getRoles($conn); // Mendapatkan data peran dari database
                            
                            foreach ($roles as $role) {
                                echo "<option value='$role'>$role</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="login_template/img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="login_template/img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="login_template/app.js"></script>
</body>

</html>