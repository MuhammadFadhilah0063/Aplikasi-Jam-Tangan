<?php 
session_start();

if ( !isset( $_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

// konenksi ke php
$conn = mysqli_connect("localhost", "root", "", "toko");

// cek apakah tombol submit sudah pernah ditekan
if ( isset($_POST["submit"]) ) {

	if (isset($_POST['submit']) ){
		// ambil data dari isian form
		$jumlah = $_POST['jumlah'];
		$kode_barang = $_POST['kode_barang'];
		$tgl_jual = $_POST['tgl_jual'];

		// ubah format tanggal
		$date = date_create($tgl_jual);
		$waktu = date_format($date, 'Y-m-d');

		$query = "INSERT INTO barang_keluar
				VALUES 
				('', '$kode_barang', '$jumlah', '$waktu')
			";

		mysqli_query($conn, $query);
		$pesan = mysqli_affected_rows($conn);

		// cek apakah data berhasil di tambahkan atau tidak
		if ( "$pesan" > 0 ) {
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
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Penjualan</title>
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
		<p> Penjualan</p>
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
					<div class="tgl">
						<label for="tgl_jual">Tanggal Penjualan :</label>
					</div>
					<div class="input_tgl">
						<input type="date" name="tgl_jual" id="tgl_jual" required>
					</div>
					<div class="input_data">
						<input type="text" name="kode_barang" id="kode_barang" required placeholder="Kode Barang">
					</div>
					<div class="input_data">
						<input type="text" name="jumlah" id="jumlah" required placeholder="Jumlah">
					</div>

					<div class="tmbl_submit">
						<button type="submit" name="submit">Tambah</button>
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