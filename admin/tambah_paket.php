<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: ../index.php");
	exit();
}


// Proses form tambah paket
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Ambil data dari form
	$outlet = $_POST['outlet'];
	$id_paket = $_POST['id_paket'];
	$jenis = $_POST['jenis'];
	$nama_paket = $_POST['nama_paket'];
	$harga = $_POST['harga'];
	$estimasi = $_POST['estimasi'];
	$satuan = $_POST['satuan'];
	
	// Gabungkan estimasi dan satuan menjadi satu nilai
	$estimasi_lengkap = $estimasi . ' ' . $satuan;
	
	// Tambahkan paket ke database
	$insert_query = "INSERT INTO paket (id_paket, id_outlet, jenis, nama_paket, harga, estimasi) VALUES ('$id_paket', '$outlet', '$jenis', '$nama_paket', '$harga', '$estimasi_lengkap')";
	$insert_result = mysqli_query($conn, $insert_query);

	if ($insert_result) {
		echo '<script>alert("DATA PAKET BERHASIL DITAMBAHKAN!"); window.location.href = "paket.php";</script>';
		// header("Location: data_paket.php");
		exit();
	} else {
		// Handle error jika query insert tidak berhasil
		die("Error: " . mysqli_error($conn));
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
							<h3 class="page-title mt-5">Tambah Paket</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">
                            <div class="col-md-12">
									<div class="form-group" id="id_paket" >
										<label for="id_paket">ID Paket</label>
										<?php echo '<input class="form-control" type="text" readonly value="PAK' . rand(1000000000, 9999999999) . '" name="id_paket" placeholder="id_paket" required>'; ?>
                                    </div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="outlet">Nama Outlet</label>
										<select class="form-control" id="outlet" name="outlet" required>
                                            <option value="outlet"><-- Pilih Nama Outlet --></option>
											<?php

											$query = "SELECT * FROM outlet";
											$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_assoc($result)) { ?>
												<option value="<?=$row['id_outlet']?>"><?=$row['nama']?></option>
<?php
											}
											?>

										</select>
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label for="jenis">Jenis</label>
										<select class="form-control" id="jenis" name="jenis" required>
                                            <option ><--- Silahkan Pilih Jenis Paket ---> </option>
                                            <option value="kiloan">Kiloan</option>
                                            <option value="selimut">Selimut</option>
                                            <option value="bed_cover">Bed Cover</option>
                                            <option value="kaos">Kaos</option>
                                            <option value="lain">Lain-lain</option>
										</select>
                                    </div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama_paket">Nama Paket</label>
										<input type="text" class="form-control" id="nama_paket" name="nama_paket" placeholder="Isi Nama Paket" required>
									</div>
								</div>
								<div class="col-md-12">

									<div class="form-group">
										<label for="harga">Harga</label>
										<input type="number" class="form-control" id="harga" name="harga" placeholder="Isi Harga" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="estimasi">Estimasi Pengerjaan:</label>
										<div style="display: flex; align-items: center;">
											<input class="form-control" type="number" id="estimasi" name="estimasi" min="1"
												required placeholder="Estimasi">
											<select class="form-control col-md-4" id="satuan" name="satuan" required>
												<!-- <option value="menit">Menit</option> -->
												<option value="jam">Jam</option>
												<option value="hari">Hari</option>
											</select>
										</div>
									</div>
								</div>

							</div>
							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button type="submit" name="submit" class="btn btn-primary buttonedit1">Tambah
								Paket</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
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