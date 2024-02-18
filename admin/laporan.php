<?php
include('../koneksi/koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
							<div class="mt-5">
								<div class="page-header">
									<div class="row align-items-center">
										<div class="col">
											<div class="mt-5">
												<h4 class="card-title float-left mt-2">Laporan</h4>
												<button class="btn btn-primary float-right veiwbutton "
													style="margin-right: 10px;" onclick="window.location.reload();">
													<i class="fas fa-sync-alt"></i>
												</button>
												<form class="float-right" id="date-form" >
													<!-- Menambahkan target="_blank" untuk membuka halaman laporan di tab baru -->
													<label for="start-date" class="mr-2">Dari Tanggal:</label>
													<input type="date" id="start-date" name="start-date">
													<label for="end-date" class="mr-2 ml-2">Sampai Tanggal:</label>
													<input type="date" id="end-date" name="end-date">
													<button type="button float-right veiwbutton "
														style="margin-right: 10px;" class="btn btn-primary ml-2"
														onclick="filterByDate()"><i class="fa fa-print"></i></button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<script>
									function filterByDate() {
										var startDate = document.getElementById('start-date').value;
										var endDate = document.getElementById('end-date').value;

										// Pengecekan apakah tanggal mulai dan tanggal selesai telah diisi
										if (startDate !== '' && endDate !== '') {
											// Redirect ke halaman laporan dengan parameter tanggal
											window.open("lapor.php?start_date=" + startDate + "&end_date=" + endDate, '_blank');
										} else {
											alert('Silakan pilih tanggal mulai dan tanggal selesai.');
											window.open("laporan.php");

										}
									}

								</script>
							</div>
						</div>
					</div>
				</div>
				<div>

					<ul class="navbar-nav mr-lg-2">
						<li class="nav-item nav-search d-none d-lg-block">
							<div class="input-group">
								<div class="input-group-prepend hover-cursor" id="navbar-search-icon">
									<span class="input-group-text" id="search">
										<i class="fas fa-search"></i>
									</span>
								</div>
								<input type="text" class="form-control" id="search-input" placeholder="Search now"
									aria-label="search" aria-describedby="search">
							</div>
						</li>
					</ul>
				</div>
				<br>
				<div class="query_d">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table id="transaksi_id"
										class="datatable table table-stripped table table-hover table-center mb-0">
										<thead>

											<tr>
												<th>No.</th>
												<th>Kode Invoice</th>
												<th>Nama Member</th>
												<th>Jenis Paket</th>
												<th>Nama Outlet</th>
												<th>Berat Cucian</th>
												<th>Total Bayar</th>
												<th>Status</th>
												<!-- <th>Ubah Status</th>
												<th>Bayar Transaksi</th> -->
												<th class="text-right">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$nomor = 1;
											$query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
											FROM transaksi
											INNER JOIN member ON transaksi.id_member = member.id_member
											INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
											INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
											INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
											WHERE transaksi.dibayar = 'dibayar'
											");

											while ($row = mysqli_fetch_assoc($query)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td>' . $row['kode_invoice'] . '</td>';
												echo '<td>' . $row['nama_member'] . '</td>';
												echo '<td>' . $row['nama_paket'] . '</td>';
												echo '<td>' . $row['nama_outlet'] . '</td>';
												echo '<td>' . $row['qty'] . ' ' . $row['jenis'] . '</td>';
												$harga_paket = $row['harga'];
												$diskon = $row['diskon'];
												$pajak = $row['pajak'];
												$biaya_tambahan = $row['biaya_tambahan'];
												$total_harga = $row['qty'] * $harga_paket - $diskon + $biaya_tambahan + $pajak;
												$total_harga_ = number_format($total_harga, 2, ',', '.');
												echo '<td> Rp. ' . $total_harga_ . '</td>';
												$status = $row['status'];
												$status_bayar = $row['dibayar'];
												echo '<td>';

												// Tombol status
												if ($status == 'baru') {
													echo '<a href="" class="btn btn-outline-secondary active">Baru</a>';
												} elseif ($status == 'diambil') {
													echo '<a href="" class="btn btn-outline-success active">Diambil</a>';
												} elseif ($status == 'proses') {
													echo '<a href="" class="btn btn-outline-warning active">Proses</a>';
												} elseif ($status == 'selesai') {
													echo '<a href="" class="btn btn-outline-info active">Selesai</a>';
												}
												echo ' ';
												if ($status_bayar == 'dibayar') {
													echo '<a href="" class="btn btn-outline-success active">Dibayar</a>';
												} elseif ($status_bayar == 'belum_dibayar') {
													echo '<a href="" class="btn btn-outline-danger active">Belum Bayar</a>';
												}

												echo '</td>';

												echo '</td>';

												echo '<td>
														<a href="print_laporan.php?id=' . $row['id_transaksi'] . '" target="_blank"
															class="btn btn-block btn-outline-primary active"><i class="fa fa-print"></i> </a>
													</td>';

												echo '</tr>';
												$nomor++;
											}
											?>
										</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="delete_asset" class="modal fade delete-modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center">
							<img src="../assets/img/sent.png" alt="" width="50" height="46">
							<h3 class="delete_class">Apakah kamu yakin ingin menghapus data transaksi atas nama <b>
								</b> ini?</h3>
							<input type="hidden" id="deletetransaksiId">
							<div class="m-t-20">
								<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="button" class="btn btn-danger" onclick="deletetransaksi()">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$('#delete_asset').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id_transaksi = button.data('id');
			document.getElementById('deletetransaksiId').value = id_transaksi;
		});

		function deletetransaksi() {
			var id_transaksi = document.getElementById('deletetransaksiId').value;
			// Lakukan penghapusan dengan menggunakan id_transaksi
			// Tambahkan kode penghapusan sesuai dengan logika bisnis Anda
			window.location.href = "hapus_transaksi.php?id=" + id_transaksi;

			// Tutup modal setelah penghapusan (sesuai kebutuhan)
			$('#delete_asset').modal('hide');
		}
	</script>
	<script>
		// Fungsi pencarian JavaScript
		document.getElementById('search-input').addEventListener('input', function () {
			let searchQuery = this.value.toLowerCase();
			let table = document.getElementById('transaksi_id');
			let query_ds = table.getElementsByTagName('tr');

			for (let i = 1; i < query_ds.length; i++) {
				let query_d = query_ds[i];
				let query_dData = query_d.innerText.toLowerCase();

				if (query_dData.includes(searchQuery)) {
					query_d.style.display = '';
				} else {
					query_d.style.display = 'none';
				}
			}
		});
	</script>

	<!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></> -->
	<script src="../assets/js/jquery-3.5.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">

	<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
	<!-- <script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../assets/plugins/datatables/datatables.min.js"></script> -->
	<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/plugins/raphael/raphael.min.js"></script>
	<script src="../assets/js/script.js"></script>
</body>