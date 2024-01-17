﻿<?php
include('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: login.php"); // Redirect ke halaman login jika tidak memenuhi syarat
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
	<div class="main-wrapper">
		<?php include('header.php'); ?>
		<?php include('sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">Data Pelanggan</h4>
								<a href="tambah_pelanggan.php" class="btn btn-primary float-right veiwbutton">Tambah
									Pelanggan</a>
								<button class="btn btn-primary float-right veiwbutton " style="margin-right: 10px;"
									onclick="refreshPage()"><i class="fa fa-refresh"></i> Refresh</button>
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
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table id="member_id"
										class="datatable table table-stripped table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>No.</th>
												<th>ID Member</th>
												<th>Nama</th>
												<th>Jenis Kelamin</th>
												<th>Alamat</th>
												<th>No. Telepon</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody>

											<?php

											$query = "SELECT * FROM member ";
											$result = mysqli_query($conn, $query);

											$nomor = 1;
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td >' . $row['id_member'] . '</td>';
												echo '<td >' . $row['nama'] . '</td>';
												echo '<td >' . $row['jenis_kelamin'] . '</td>';
												echo '<td >' . $row['alamat'] . '</td>';
												echo '<td >' . $row['tlp'] . '</td>';
												echo
													'<td class="text-right">
													<div class="dropdown dropdown-action"> <a href="#"
															class="action-icon dropdown-toggle" data-toggle="dropdown"
															aria-expanded="false"><i
																class="fas fa-ellipsis-v ellipse_color"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> 
														<a class="dropdown-item" href="detail_member.php?id=' . $row['id_member'] . '"><i class="fas fa-info-circle m-r-5"></i> Detail</a> 
														<a class="dropdown-item" href="edit_member.php?id=' . $row['id_member'] . '"><i class="fas fa-pencil-alt m-r-5"></i> Edit</a> 
														<a class="dropdown-item" href="hapus_member.php?id=' . $row['id_member'] . '"><i class="fas fa-trash-alt m-r-5"></i> Delete</a> 
														</div>
													</div>
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
			<!-- <a class="dropdown-item" data-toggle="modal" data-target="#delete_asset"><i class="fas fa-trash-alt m-r-5"></i> Delete</a> -->
			<div id="delete_asset" class="modal fade delete-modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center"> <img src="assets/img/sent.png" alt="" width="50"
								height="46">
							<h3 class="delete_class">Apakah kamu yakin ingin menghapus data ini?</h3>
							<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="button" class="btn btn-danger"
									onclick="deletemember(<?= $row['id_member'] ?>)">Delete</button>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>	function refreshPage() {
			location.reload(); // Fungsi ini memuat ulang halaman
		}
// 		function deletemember(id) {
//     if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
//         window.location.href = "hapus_member.php?id=" + id;
//     }
// }
	</script>
	<!-- <script>
		function deletemember(id_member) {
			window.location.href = "hapus_member.php?id=" + id_member;
		}
	</script> -->
	<script>
		// Fungsi pencarian JavaScript
		document.getElementById('search-input').addEventListener('input', function () {
			let searchQuery = this.value.toLowerCase();
			let table = document.getElementById('member_id');
			let rows = table.getElementsByTagName('tr');

			for (let i = 1; i < rows.length; i++) {
				let row = rows[i];
				let rowData = row.innerText.toLowerCase();

				if (rowData.includes(searchQuery)) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			}
		});
	</script>
	<!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">

	<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
	<!-- <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/datatables.min.js"></script> -->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/script.js"></script>
</body>

</html>