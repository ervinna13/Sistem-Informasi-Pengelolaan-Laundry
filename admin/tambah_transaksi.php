<?php
session_start();
include('../koneksi/koneksi.php');

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: index.php");
	exit();
}

// Ambil nama pengguna berdasarkan ID pengguna yang disimpan dalam sesi
$id_user = $_SESSION['id_user'];
$query_user = "SELECT nama FROM user WHERE id_user = '$id_user'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
	echo "Error: " . $query_user . "<br>" . mysqli_error($conn);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id_transaksi = mysqli_real_escape_string($conn, $_POST['id_transaksi']);
	$id_outlet = mysqli_real_escape_string($conn, $_POST['outlet']);
	$kode_invoice = mysqli_real_escape_string($conn, $_POST['kode_invoice']);
	$id_member = mysqli_real_escape_string($conn, $_POST['member']);
	$tgl = mysqli_real_escape_string($conn, $_POST['tgl']);
	$batas_waktu = mysqli_real_escape_string($conn, $_POST['batas_waktu']);
	$tgl_bayar = mysqli_real_escape_string($conn, $_POST['tgl_bayar']);
	$biaya_tambahan = mysqli_real_escape_string($conn, $_POST['biaya_tambahan']);
	$diskon = mysqli_real_escape_string($conn, $_POST['diskon']);
	$pajak = mysqli_real_escape_string($conn, $_POST['pajak']);
	$status = "baru"; // tidak perlu disanitasi karena sudah tetap
	$dibayar = mysqli_real_escape_string($conn, $_POST['dibayar']);
	$nama = $id_user; // tidak perlu disanitasi karena sudah tetap
	$id_detail = mysqli_real_escape_string($conn, $_POST['id_detail']);
	$id_paket = mysqli_real_escape_string($conn, $_POST['paket']);
	$qty = mysqli_real_escape_string($conn, $_POST['jumlah']);
	$keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);


	// Query untuk transaksi
	$query_transaksi = "INSERT INTO transaksi (id_transaksi, id_outlet, kode_invoice, id_member, tgl, batas_waktu, tgl_bayar, biaya_tambahan, diskon, pajak, status, dibayar, id_user) VALUES ('$id_transaksi', '$id_outlet', '$kode_invoice', '$id_member', '$tgl', '$batas_waktu', '$tgl_bayar', '$biaya_tambahan', '$diskon', '$pajak', '$status', '$dibayar', '$nama')";

	// Query untuk detail transaksi
	$query_detail_transaksi = "INSERT INTO detail_transaksi (id, id_transaksi, id_paket, qty, keterangan) VALUES ('$id_detail', '$id_transaksi', '$id_paket', '$qty', '$keterangan')";

	if ($conn->query($query_transaksi) === TRUE && $conn->query($query_detail_transaksi) === TRUE) {
		echo '<script>alert("DATA TRANSAKSI BERHASIL DITAMBAHKAN!"); window.location.href = "transaksi.php";</script>';
	} else {
		echo "Error: " . $query_transaksi . "<br>" . $conn->error;
	}
}

?>

<?php include('../layouts/head.php'); ?>

<body>
	<div class="main-wrapper">
		<?php include('../layouts/header.php'); ?>
		<?php include('../layouts/sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title mt-5">Tambah Transaksi</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">

								<div class="col-md-4" style="display:none;">
									<div class="form-group">
										<label>ID Transaksi</label>
										<?php echo '<input class="form-control" type="text" readonly value="TRX' . rand(1000000000, 9999999999) . '" name="id_transaksi" placeholder="Id Transaksi" required>'; ?>
									</div>
								</div>
								<div class="col-md-4" style="display:none;">
									<div class="form-group">
										<label>ID Detail Transaksi</label>
										<?php echo '<input class="form-control" type="text" readonly value="DTL' . rand(1000000000, 9999999999) . '" name="id_detail" placeholder="Id Detail" required>'; ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Kode Invoice</label>
										<?php
										$kode_invoice = 'INV' . date('Ymd') . rand(1000, 9999);
										echo '<input class="form-control" type="text" readonly value="' . $kode_invoice . '" name="kode_invoice" placeholder="Kode Invoice" required>';
										?>
									</div>
								</div>
								<?php
								// Query untuk mendapatkan semua data paket
								$query_paket = "SELECT * FROM paket";
								$result_paket = mysqli_query($conn, $query_paket);
								// Query untuk mendapatkan semua data outlet
								$query_outlet = "SELECT * FROM outlet";
								$result_outlet = mysqli_query($conn, $query_outlet);
								?>

								<div class="col-md-4">
									<div class="form-group">
										<label for="member">Nama Member</label>
										<select class="form-control" id="member" name="member" required>
											<option value="member"><-- Pilih Nama member --></option>
											<?php
											$query = "SELECT * FROM member";
											$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_assoc($result)) { ?>
												<option value="<?= $row['id_member'] ?>">
													<?= $row['nama'] ?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="outlet">Nama Outlet</label>
										<select class="form-control" id="outlet" name="outlet" required
											onchange="showPaketDiv()">
											<option> <-- Pilih Nama Outlet --> </option>
											<?php
											$query = "SELECT * FROM outlet";
											$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_assoc($result)) {
												?>
												<option value="<?= $row['id_outlet'] ?>">
													<?= $row['nama'] ?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div id="paketDiv" class="col-md-4" style="display:none;">
									<div class="form-group">
										<label for="paket">Nama Paket</label>
										<select class="form-control" id="paket" name="paket" required>
											<option value="paket"> <-- Pilih Nama Paket --> </option>
											<?php
											$query = "SELECT * FROM paket";
											$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_assoc($result)) {
												?>
												<option value="<?= $row['id_paket'] ?>">
													<?= $row['nama_paket'] ?> --
													<?= $row['jenis'] ?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<script>
									function showPaketDiv() {
										var outletSelect = document.getElementById("outlet");
										var paketDiv = document.getElementById("paketDiv");
										if (outletSelect.value !== "outlet") {
											paketDiv.style.display = "block"; // Menampilkan div paket
										} else {
											paketDiv.style.display = "none"; // Menyembunyikan div paket jika outlet masih placeholder
										}
									}
								</script>
								<div class="col-md-4">
									<div class="form-group">
										<label>Jumlah</label>
										<input type="number" class="form-control" id="jumlah" name="jumlah"
											placeholder="Jumlah" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Biaya Tambahan</label>
										<input type="number" class="form-control" id="biaya_tambahan"
											name="biaya_tambahan" placeholder="Biaya Tambahan" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Diskon</label>
										<input type="number" class="form-control" id="diskon" name="diskon"
											placeholder="Diskon" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Pajak</label>
										<input type="number" class="form-control" id="pajak" name="pajak"
											placeholder="Pajak" required>
									</div>
								</div>
								<div class="col-md-4" style="display:none;">
									<div class="form-group">
										<label>Batas Waktu</label>
										<input type="datetime-local" class="form-control" id="batas-waktu"
											name="batas_waktu" placeholder="Batas Waktu">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="dibayar">Status Pembayaran</label>
										<select class="form-control" id="dibayar" name="dibayar" required>
											<option value="belum_dibayar">Belum dibayar</option>
											<option value="dibayar">Dibayar</option>
										</select>
									</div>
								</div>
								<div class="col-md-4" style="display:none;">
									<div class="form-group">
										<label>Tanggal Bayar</label>
										<input type="datetime-local" class="form-control" id="tgl_bayar"
											name="tgl_bayar" placeholder="Tanggal Bayar">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" rows="5" id="keterangan" name="keterangan"
											placeholder="Keterangan"></textarea>
									</div>
								</div>
								<div class="col-md-4" style="display:none;">
									<div class="form-group">
										<label>Tanggal</label>
										<input type="datetime-local" class="form-control" id="tgl" name="tgl"
											placeholder="Tanggal" readonly required>
									</div>
								</div>

								<script>
									// Mendapatkan tanggal hari ini
									var today = new Date();

									// Mendapatkan tahun, bulan, dan hari hari ini
									var year = today.getFullYear();
									var month = String(today.getMonth() + 1).padStart(2, '0'); // Menambahkan nol jika bulan < 10
									var day = String(today.getDate()).padStart(2, '0'); // Menambahkan nol jika hari < 10
									var hours = String(today.getHours()).padStart(2, '0'); // Menambahkan nol jika jam < 10
									var minutes = String(today.getMinutes()).padStart(2, '0'); // Menambahkan nol jika menit < 10

									// Mendapatkan tanggal hari ini dalam format "YYYY-MM-DDTHH:MM" yang diperlukan untuk input type datetime-local
									var formattedDateTime = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;

									// Mengatur nilai input datetime-local ke tanggal hari ini
									document.getElementById('tgl').value = formattedDateTime;
								</script>

								<div class="col-md-4">
									<div class="form-group">
										<label for="">Total Harga</label>
										<h1 id="total_harga">Rp. 0.00</h1>
									</div>
								</div>
							</div>

							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button id="submitBtn" type="submit" name="submit"
								class="btn btn-primary buttonedit1 fas fa-plus"> &nbsp;
								Tambah
								Transaksi</button>

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
	<!-- Modal Konfirmasi Pembayaran -->
	<div class="modal fade" id="konfirmasiPembayaranModal" tabindex="-1" role="dialog"
		aria-labelledby="konfirmasiPembayaranModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="konfirmasiPembayaranModalLabel">Konfirmasi Pembayaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Total yang harus dibayar: <span id="totalHargaModal"></span></p>
					<p>Jumlah uang yang akan dibayar: <input type="number" id="jumlahUangDibayar" class="form-control"
							placeholder="Jumlah uang" name="" required></p>
					<p>Kembaliannya: <span id="kembalian"></span></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary" id="konfirmasiPembayaranButton">Konfirmasi
						Pembayaran</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		// Event listener untuk menangkap aksi ketika modal ditutup
		$('#konfirmasiPembayaranModal').on('hidden.bs.modal', function () {
			
			// Periksa apakah tombol konfirmasi pembayaran belum diklik
			var isConfirmed = document.getElementById("konfirmasiPembayaranButton").getAttribute("data-confirmed");

			// Jika tombol konfirmasi belum diklik dan modal ditutup, ubah status pembayaran kembali menjadi "belum_dibayar"
			if (!isConfirmed || isConfirmed !== "true") {
				// Ubah opsi pembayaran menjadi "belum_dibayar"
				document.getElementById("dibayar").value = "belum_dibayar";
			}

		});
		// Event listener saat tombol konfirmasi pembayaran diklik
		document.getElementById("konfirmasiPembayaranButton").addEventListener("click", function () {
			// Set nilai data-confirmed menjadi "true" saat tombol diklik
			this.setAttribute("data-confirmed", "true");

			// ... kode lain untuk menangani konfirmasi pembayaran ...
		});

	</script>

	<!-- Script untuk menampilkan modal konfirmasi -->
	<script>
		// Event listener saat opsi pembayaran dipilih
		document.getElementById("dibayar").addEventListener("change", function () {
			// Ambil nilai status pembayaran yang dipilih
			var status_pembayaran = this.value;

			// Jika status pembayaran adalah "Dibayar", tampilkan modal konfirmasi
			if (status_pembayaran === "dibayar") {
				// Ambil total harga dari elemen HTML
				var totalHarga = document.getElementById("total_harga").innerText;
				// Tampilkan total harga dalam modal
				document.getElementById("totalHargaModal").innerText = totalHarga;

				// Tampilkan modal konfirmasi
				$('#konfirmasiPembayaranModal').modal('show');
			}
		});

		// Event listener saat input jumlah uang yang akan dibayar berubah
		document.getElementById("jumlahUangDibayar").addEventListener("input", function () {
			// Ambil nilai total harga dari elemen HTML
			var totalHarga = parseFloat(document.getElementById("totalHargaModal").innerText.replace("Rp. ", ""));
			// Ambil nilai jumlah uang yang akan dibayar
			var jumlahUangDibayar = parseFloat(this.value);

			// Hitung kembalian
			var kembalian = jumlahUangDibayar - totalHarga;

			// Tampilkan kembalian
			document.getElementById("kembalian").innerText = "Rp. " + kembalian.toFixed(2);
		});

		// Event listener saat tombol konfirmasi pembayaran diklik
		document.getElementById("konfirmasiPembayaranButton").addEventListener("click", function () {
			// Ambil nilai total harga dari elemen HTML
			var totalHarga = parseFloat(document.getElementById("totalHargaModal").innerText.replace("Rp. ", ""));
			// Ambil nilai jumlah uang yang akan dibayar
			var jumlahUangDibayar = parseFloat(document.getElementById("jumlahUangDibayar").value);

			// Hitung kembalian
			var kembalian = jumlahUangDibayar - totalHarga;

			// Tampilkan kembalian dalam modal
			document.getElementById("kembalian").innerText = "Rp. " + kembalian.toFixed(2);

			// Lakukan aksi konfirmasi pembayaran di sini
			// Misalnya, mengirimkan data ke server atau menampilkan pesan konfirmasi
			alert("Pembayaran berhasil dikonfirmasi!");

			// Tutup modal setelah konfirmasi
			$('#konfirmasiPembayaranModal').modal('hide');

			// Klik tombol submit secara otomatis
			document.getElementById("submitBtn").click();

		});
	</script>

	<script>
		$(function () {
			$('#datetimepicker3').datetimepicker({
				format: 'LT'
			});
		});	</script>

	<script type="text/javascript">
		function filterPaket() {
			var outletSelect = document.getElementById("outlet");
			var paketSelect = document.getElementById("paket");

			// Menghapus semua opsi paket yang ada
			paketSelect.innerHTML = '';

			// Mendapatkan outlet yang dipilih
			var selectedOutletId = outletSelect.value;

			// Menambahkan opsi default untuk paket
			var defaultOption = document.createElement("option");
			defaultOption.text = "<-- Pilih Nama Paket -->";
			defaultOption.value = "";
			paketSelect.appendChild(defaultOption);
			// Menyaring dan menambahkan opsi paket berdasarkan outlet yang dipilih
			paketData.forEach(function (paket) {
				if (paket.id_outlet === selectedOutletId) {
					var option = document.createElement("option");
					// Menambahkan nama paket dan jenisnya ke dalam opsi
					option.text = paket.nama + ' - ' + 'Rp. ' + paket.harga + '/' + paket.jenis;
					option.value = paket.id;
					paketSelect.appendChild(option);
				}
			});
		}
		// Menambahkan event listener untuk perubahan pada outlet select
		document.getElementById("outlet").addEventListener("change", filterPaket);
	</script>
	<script type="text/javascript">
		var paketData = [
			<?php while ($row_paket = mysqli_fetch_assoc($result_paket)) { ?>
																																											{
					id: '<?php echo $row_paket['id_paket']; ?>',
					nama: '<?php echo $row_paket['nama_paket']; ?>',
					harga: '<?php echo $row_paket['harga']; ?>',
					jenis: '<?php echo $row_paket['jenis']; ?>',
					id_outlet: '<?php echo $row_paket['id_outlet']; ?>',
					estimasi_kerja: '<?php echo $row_paket['estimasi']; ?>'
				},
			<?php } ?>
		];
		var outletData = [
			<?php while ($row_outlet = mysqli_fetch_assoc($result_outlet)) { ?>
																																											{ id: '<?php echo $row_outlet['id_outlet']; ?>', nama: '<?php echo $row_outlet['nama']; ?>' },
			<?php } ?>
		];
	</script>
	<script>
		// Event listener untuk memperbarui total harga saat pemilihan paket berubah
		document.getElementById("paket").addEventListener("change", function () {
			// Ambil id_paket yang dipilih oleh pengguna
			var id_paket = this.value;

			// Cari harga paket berdasarkan id_paket yang dipilih
			var harga_paket;
			var paketDataLength = paketData.length;
			for (var i = 0; i < paketDataLength; i++) {
				if (paketData[i].id === id_paket) {
					harga_paket = parseFloat(paketData[i].harga);
					break;
				}
			}

			// Tampilkan harga paket ke dalam total harga
			document.getElementById("total_harga").innerText = "Rp. " + harga_paket.toFixed(2);
		});

		// Event listener untuk memperbarui total harga saat perubahan pada jumlah
		document.getElementById("jumlah").addEventListener("input", function () {
			// Ambil nilai jumlah yang dimasukkan oleh pengguna
			var jumlah = parseInt(this.value);

			// Ambil harga paket yang telah dipilih
			var id_paket = document.getElementById("paket").value;
			var harga_paket;
			var paketDataLength = paketData.length;
			for (var i = 0; i < paketDataLength; i++) {
				if (paketData[i].id === id_paket) {
					harga_paket = parseFloat(paketData[i].harga);
					break;
				}
			}

			// Jika nilai jumlah kosong, tampilkan harga paket saja
			if (!jumlah) {
				document.getElementById("total_harga").innerText = "Rp. " + harga_paket.toFixed(2);

			} else if (!harga_paket) {
				document.getElementById("total_harga").innerText = "Rp. " + jumlah.toFixed(2);
			} else {
				// Pastikan harga_paket terdefinisi sebelum melakukan perkalian
				if (!isNaN(harga_paket)) {
					// Hitung total harga berdasarkan harga paket dan jumlah
					var total_harga = harga_paket * jumlah;

					// Tampilkan total harga dengan format mata uang
					document.getElementById("total_harga").innerText = "Rp. " + total_harga.toFixed(2);
				}
			}
		});
	</script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			// Dapatkan elemen-elemen yang diperlukan
			var status_pembayaran = document.getElementById("dibayar");
			var tgl_bayar_field = document.getElementById("tgl_bayar");

			// Tambahkan event listener untuk memantau perubahan pada status pembayaran
			status_pembayaran.addEventListener("change", function () {
				if (status_pembayaran.value === "dibayar") {
					// Jika status pembayaran adalah "Dibayar", tampilkan dan isi tanggal bayar
					tgl_bayar_field.style.display = "block";

					// Isi tanggal bayar dengan tanggal dan waktu saat ini
					var now = new Date();
					var year = now.getFullYear();
					var month = String(now.getMonth() + 1).padStart(2, '0');
					var day = String(now.getDate()).padStart(2, '0');
					var hours = String(now.getHours()).padStart(2, '0');
					var minutes = String(now.getMinutes()).padStart(2, '0');
					var formattedDateTime = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
					tgl_bayar_field.value = formattedDateTime;
				} else {
					tgl_bayar_field.value = "";
				}
			});
		});
	</script>

</body>