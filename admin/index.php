<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: ../index.php");
	exit();
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
					<div class="row">
						<div class="col-sm-12 mt-5">
							<h3 class="page-title mt-3">Selamat Datang Admin!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>

										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Pelanggan dari database
											$queryPelanggan = "SELECT COUNT(*) AS totalPelanggan FROM member";
											$resultPelanggan = $conn->query($queryPelanggan);

											if ($resultPelanggan) {
												$rowPelanggan = $resultPelanggan->fetch_assoc();
												$totalPelanggan = $rowPelanggan['totalPelanggan'];

												// Menampilkan jumlah Pelanggan dalam HTML
												echo '<h3>' . $totalPelanggan . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Pelanggan</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-user-plus">
												<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
												<circle cx="8.5" cy="7" r="4"></circle>
												<line x1="20" y1="8" x2="20" y2="14"></line>
												<line x1="23" y1="11" x2="17" y2="11"></line>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Transaksi dari database
											$queryTransaksi = "SELECT COUNT(*) AS totalTransaksi FROM transaksi";
											$resultTransaksi = $conn->query($queryTransaksi);

											if ($resultTransaksi) {
												$rowTransaksi = $resultTransaksi->fetch_assoc();
												$totalTransaksi = $rowTransaksi['totalTransaksi'];

												// Menampilkan jumlah Transaksi dalam HTML
												echo '<h3>' . $totalTransaksi . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Transaksi</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-dollar-sign">
												<line x1="12" y1="1" x2="12" y2="23"></line>
												<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Paket dari database
											$queryPaket = "SELECT COUNT(*) AS totalPaket FROM paket";
											$resultPaket = $conn->query($queryPaket);

											if ($resultPaket) {
												$rowPaket = $resultPaket->fetch_assoc();
												$totalPaket = $rowPaket['totalPaket'];

												// Menampilkan jumlah Paket dalam HTML
												echo '<h3>' . $totalPaket . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Produk</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-file-plus">
												<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
												</path>
												<polyline points="14 2 14 8 20 8"></polyline>
												<line x1="12" y1="18" x2="12" y2="12"></line>
												<line x1="9" y1="15" x2="15" y2="15"></line>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Outlet dari database
											$queryOutlet = "SELECT COUNT(*) AS totalOutlet FROM outlet";
											$resultOutlet = $conn->query($queryOutlet);

											if ($resultOutlet) {
												$rowOutlet = $resultOutlet->fetch_assoc();
												$totalOutlet = $rowOutlet['totalOutlet'];

												// Menampilkan jumlah Outlet dalam HTML
												echo '<h3>' . $totalOutlet . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Outlet</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-globe">
												<circle cx="12" cy="12" r="10"></circle>
												<line x1="2" y1="12" x2="22" y2="12"></line>
												<path
													d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
												</path>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-12 col-lg-6">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title">Transaksi Perbulan</h4>
							</div>
							<div class="card-body">
								<div id="line-chart"></div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-6">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title">ROOMS BOOKED</h4>
							</div>
							<div class="card-body">
								<div id="donut-chart"></div>
							</div>
						</div>
					</div>
				</div> -->

			</div>
		</div>

	</div>
	
	<?php include('../layouts/footer.php'); ?>
</body>

</html>