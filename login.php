<?php
// Pastikan session dimulai
session_start();

// Include file koneksi
include('koneksi.php');
// Tambahkan pemeriksaan sesi di sini
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/stylee.css" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/laundry2.png">
  <title>Log In</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="post" action="proses_login.php" class="sign-in-form">
          <h2 class="title">Log In</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required/>
          </div>
          <input type="submit" value="Login" class="btn solid" />
          
        </form>
        
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Log In Tersedia!</h3>
          <p>
            Silahkan Log In dengan username dan passwword yang terdaftar!
          </p>
         
        </div>
        <img src="assets/img/register.svg" class="image" alt="" />
      </div>

    </div>
  </div>
</body>

</html>