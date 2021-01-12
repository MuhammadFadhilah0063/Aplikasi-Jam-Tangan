<?php 
session_start();

if ( !isset( $_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// ambil data di url
$id = $_GET["id_bm"];

// query data jam tangan berdasarkan id // [0] untuk mengambil array index ke-0
// karena ini menggunakan function query yg terdapat array rows sebagai
// kotaknya dan array row sebagai datanya... // array [0]["id"]
$jam = query("SELECT * FROM barang_masuk WHERE id_bm = $id")[0];

// cek apakah tombol submit sudah pernah ditekan
if ( isset($_POST["submit"]) ) {

	// cek apakah data berhasil di diubah atau tidak
	if ( ubah_laporan_masuk($_POST) > 0 ) {
		// kode javascript
		echo "
			<script>
				alert('Data Berhasil Diubah!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data Gagal Diubah!');
				document.location.href = 'index.php';
			</script>
		";
	}

}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubah Laporan Barang Masuk</title>
	<link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
	<div class="header">
		<p>Jam Tangan</p>
	</div>

	<div class="page">
		<i class="fa fa-arrow-right"> </i>
		<p>Ubah Data Laporan Barang Masuk</p>
	</div>

	<!-- Navigasi -->

	<div class="sidebar">
		<a href="index.php">Home</a>
		<a href="tambah.php">Tambah Data</a>
		<a href="penjualan.php">Penjualan</a>
		<a href="barang_masuk.php">Barang Masuk</a>
		<a href="laporan_jual.php">Laporan Penjualan</a>
		<a href="laporan_masuk.php">Laporan Barang Masuk</a>
		<a href="logout.php">Logout</a>
	</div>

	<div class="content">
		<div class="wrapper_ubah">
			<div class="transaksi">
				<form action="" method="post">
					<!-- Input hidden -->
					<input type="hidden" name="id_bm" value="<?= $jam["id_bm"]; ?>">

					<div class="tgl">
						<label for="tgl_masuk">Tanggal Masuk :</label>
					</div>
					<div class="input_tgl">
						<input type="date" name="tgl_masuk" id="tgl_masuk" value="<?= $jam["tgl_masuk"]; ?>">
					</div>
					<div class="input_data">
						<input type="text" name="kode_barang" id="kode_barang" required placeholder="Kode Barang"
							value="<?= $jam["kode_barang"]; ?>">
					</div>
					<div class="input_data">
						<input type="text" name="jumlah" id="jumlah" required placeholder="Jumlah" value="<?= $jam["jumlah"]; ?>">

					<div class="tmbl_submit">
						<button type="submit" name="submit">Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="clear"></div>

	<div class="footer_ubah">
		<p>Copyright &copy; 2020 by Muhammad Fadhilah</p>
	</div>
</div>

</body>
</html>