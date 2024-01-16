
<?php
session_start();
// Sertakan file koneksi
include('koneksi.php');

// Check jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header('Location: login.php');
	exit;
}

// Proses edit data customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id_outlet = $_POST['id_outlet'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

	// Update data customer dalam database
	$query = "UPDATE outlet SET 
                nama = '$nama',
                alamat = '$alamat',
                tlp = '$tlp'
                WHERE id_outlet = '$id_outlet'";

	if ($conn->query($query) === TRUE) {
		echo '<script>alert("Perubahan berhasil disimpan!"); window.location.href = "index_customer.php";</script>';
		exit;
	} else {
		echo "Error: " . $query . "<br>" . $conn->error;
	}
}

// Ambil ID customer dari parameter URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
	$id_outlet = $_GET['id'];

	// Ambil data customer dari database berdasarkan ID
	$query = "SELECT * FROM data_customer WHERE id_outlet = '$id_outlet'";
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		$customer_data = $result->fetch_assoc();
	} else {
		echo "Data customer tidak ditemukan.";
		exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');
?>

<body>
    <div class="main-wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title mt-5">Edit Outlet</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit outlet -->
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="id_outlet">Id Outlet</label>
                                        <input type="text" class="form-control" id="id_outlet" name="id_outlet"
                                            value="<?= $outlet['id_outlet']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $outlet['nama']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat"
                                            required><?= $outlet['alamat']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tlp">No. Telepon</label>
                                        <input type="text" class="form-control" id="tlp" name="tlp"
                                            value="<?= $outlet['tlp']; ?>" required>
                                    </div>
                                    <a href="data_outlet.php" class="btn btn-primary"><i class="fa fa-backward"></i>
                                        KEMBALI
                                    </a>
                                    <button type="submit" name="submit" class="btn btn-info">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Sisipkan Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>