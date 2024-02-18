<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah ID transaksi ada dalam request dan tidak kosong
    if (isset($_POST['id_transaksi']) && !empty($_POST['id_transaksi'])) {
        $id_transaksi = $_POST['id_transaksi'];
        
        // Ambil nilai status dan status bayar dari form
        $status = $_POST['status'];
        $dibayar = $_POST['dibayar'];
        
        // Buat query UPDATE untuk memperbarui status dan status bayar transaksi
        $query_update_transaksi = "UPDATE transaksi SET status = '$status', dibayar = '$dibayar' WHERE id_transaksi = '$id_transaksi'";
        
        // Lakukan update data
        if ($conn->query($query_update_transaksi) === TRUE) {
            // Redirect kembali ke halaman transaksi.php dengan pesan sukses
            echo '<script>alert("Data transaksi berhasil diperbarui!"); window.location.href = "transaksi.php";</script>';
            exit;
        } else {
            // Tampilkan pesan error jika query tidak berhasil
            echo "Error: " . $query_update_transaksi . "<br>" . $conn->error;
        }
    } else {
        // Tampilkan pesan error jika ID transaksi tidak ada dalam request
        echo "Invalid request!";
    }
} else {
    // Tampilkan pesan error jika request bukan metode POST
    echo "Invalid request method!";
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
    FROM transaksi
    INNER JOIN member ON transaksi.id_member = member.id_member
    INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
    INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
    WHERE transaksi.id_transaksi = '$id_transaksi'");
    if ($query) {
        $transaksi = mysqli_fetch_assoc($query);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: transaksi.php");
    exit();
}
?>
?>
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
                            <h3 class="page-title mt-5">Edit transaksi</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit transaksi -->
                                <form method="POST" action=" ">
                                    <?php ?>
                                    <div class="form-group" style="display:none;">
                                        <label for="id_transaksi">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="id_transaksi" name="id_transaksi"
                                            value="<?= $transaksi['id_transaksi']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat_cucian">Waktu Transaksi</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['tgl']; ?> " readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="nama_member">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                                            value="<?= $transaksi['nama_member']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_outlet">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama_outlet" name="nama_outlet"
                                            value="<?= $transaksi['nama_outlet']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_paket">Berat Cucian</label>
                                        <input class="form-control" id="nama_paket" name="nama_paket"
                                            value=" <?= $transaksi['nama_paket']; ?> " readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="berat_cucian">Nama Paket</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['qty']; ?>  <?= $transaksi['jenis']; ?>" readonly>

                                    </div>
                                    <?php $harga_paket = $transaksi['harga'];
                                    $diskon = $transaksi['diskon'];
                                    $pajak = $transaksi['pajak'];
                                    $biaya_tambahan = $transaksi['biaya_tambahan'];
                                    $total_harga = $transaksi['qty'] * $harga_paket - $diskon + $biaya_tambahan + $pajak; ?>
                                    <div class="form-group">
                                        <label for="harga">Total Bayar</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($total_harga, 0, ',', '.'); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="baru" <?php if ($transaksi['status'] == 'baru')
                                                echo 'selected'; ?>>Baru</option>
                                            <option value="proses" <?php if ($transaksi['status'] == 'proses')
                                                echo 'selected'; ?>>Proses</option>
                                            <option value="selesai" <?php if ($transaksi['status'] == 'selesai')
                                                echo 'selected'; ?>>Selesai</option>
                                            <option value="diambil" <?php if ($transaksi['status'] == 'diambil')
                                                echo 'selected'; ?>>Diambil</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="dibayar">Status Bayar</label>
                                        <select class="form-control" id="dibayar" name="dibayar" required>
                                            <option value="dibayar" <?php if ($transaksi['dibayar'] == 'dibayar')
                                                echo 'selected'; ?>>Dibayar</option>
                                            <option value="belum_dibayar" <?php if ($transaksi['dibayar'] == 'belum_dibayar')
                                                echo 'selected'; ?>>Belum
                                                Dibayar</option>
                                        </select>
                                    </div>
                                    <hr>
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