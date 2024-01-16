<?php
session_start();
// Include file koneksi
include('koneksi.php');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Retrieve form data
	$id_outlet = htmlspecialchars($_POST['id_outlet']);
	$nama = htmlspecialchars($_POST['nama']);
	$alamat = $_POST['alamat'];
	$tlp = $_POST['no_telp'];


	// Insert data into the database
	$query = "INSERT INTO outlet (id_outlet, nama, alamat, tlp) VALUES ('$id_outlet', '$nama','$alamat','$tlp')";
	if ($conn->query($query) === TRUE) {
		echo '<script>alert("DATA OUTLET BERHASIL DITAMBAHKAN!"); window.location.href = "data_outlet.php";</script>';
	} else {
		echo "Error: " . $query . "<br>" . $conn->error;
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
							<h3 class="page-title mt-5">Tambah Outlet</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">
								<div class="col-md-12">
									<div class="form-group">
										<label>ID Outlet</label>
										<?php echo '<input class="form-control" type="text" readonly value="OUT' . rand(1000000000, 9999999999) . '" name="id_outlet" placeholder="id_outlet" required>'; ?>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Nama</label>
										<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Outlet" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>No. Telepon</label>
										<input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" required  >
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Alamat</label>
										<textarea class="form-control" rows="5" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
									</div>
								</div>
							</div>
				<button  type="submit" name="submit"class="btn btn-primary buttonedit1">Tambah Outlet</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
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