<?php 
session_start();

if ( !isset( $_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// cek apakah tombol submit sudah pernah ditekan
if ( isset($_POST["tambah"]) ) {

	// cek apakah data berhasil di tambahkan atau tidak
	if ( tambah($_POST) > 0 ) {
		// kode javascript
		echo "
			<script>
				alert('Data Berhasil Ditambahkan!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data Gagal Ditambahkan!');
				document.location.href = 'index.php';
			</script>
		";
	}

}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data Jam Tangan</title>
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
		<p> Tambah Data</p>
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
		<div class="wrapper">
			<div class="tambah">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="input_data">
						<input type="text" name="kode_barang" id="kode_barang" required placeholder="Kode Barang">
					</div>
					<div class="input_data">
						<input type="text" name="merek" id="merek" required placeholder="Merek">
					</div>
					<div class="pilihan">
						<select name="jenis_tali" id="jenis_tali">
							<option value="Rantai" selected>Rantai</option>
							<option value="Kulit">Kulit</option>
							<option value="Karet">Karet</option>
						</select>
					</div>
					<div class="input_data">
						<input type="text" name="stok" id="stok" required placeholder="Stok">
					</div>
					<div class="input_data">
						<input type="text" name="harga" id="harga" required placeholder="Harga">
					</div>
					<div class="label_img">
						<label for="gambar">File Image : </label>
					</div>
					<div class="input_img">
						<input type="file" name="gambar" id="gambar">
					</div>
					<div class="tmbl_submit">
						<button type="submit" name="tambah">Tambah</button>
					</div>
				</form>
			</div>	
		</div>	
	</div>

	<div class="clear"></div>

	<div class="footer">
		<p>Copyright &copy; 2020 by Muhammad Fadhilah</p>
	</div>
</div>
</body>
</html>