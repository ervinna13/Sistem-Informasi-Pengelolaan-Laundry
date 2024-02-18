
<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Check jika pengguna belum ../index, redirect ke halaman ../index
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header('Location: ../index.php');
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
		echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "outlet.php";</script>';
		exit;
	} else {
        die("Error: " . mysqli_error($conn));
		// echo "Error: " . $query . "<br>" . $conn->error;
	}
}

// Ambil ID customer dari parameter URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
	$id_outlet = $_GET['id'];

	// Ambil data customer dari database berdasarkan ID
	$query = "SELECT * FROM outlet WHERE id_outlet = '$id_outlet'";
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		$outlet = $result->fetch_assoc();
	} else {
		echo "Data customer tidak ditemukan.";
		exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../layouts/head.php');
?>

<body>
    <div class="main-wrapper">
        <?php include('../layouts/header.php'); ?>
        <?php include('../layouts/sidebar.php'); ?>
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
                                            value="<?= $outlet['tlp']; ?>" required maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                    </div>
                                    <a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
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

    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/plugins/raphael/raphael.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>