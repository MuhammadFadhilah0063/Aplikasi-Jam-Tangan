<?php 
session_start();

if ( !isset( $_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// ambil data di url
$id = $_GET["id"];

// query data jam tangan berdasarkan id // [0] untuk mengambil array index ke-0
// karena ini menggunakan function query yg terdapat array rows sebagai
// kotaknya dan array row sebagai datanya... // array [0]["id"]
$jam = query("SELECT * FROM jam_tangan WHERE id = $id")[0];

// cek apakah tombol submit sudah pernah ditekan
if ( isset($_POST["submit"]) ) {

	// cek apakah data berhasil di diubah atau tidak
	if ( ubah($_POST) > 0 ) {
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
	<title>Ubah Data Jam Tangan</title>
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
		<p> Ubah Data Jam Tangan</p>
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
		<div class="wrapperUbah">
			<div class="ubah">
				<form action="" method="post" enctype="multipart/form-data">
					<!-- Input hidden -->
					<input type="hidden" name="id" value="<?= $jam["id"]; ?>">
					<input type="hidden" name="stok" value="<?= $jam["stok"]; ?>">
					<!-- untuk mengirimkan gambar lama, jika user tidak mengupload gambar baru -->
					<input type="hidden" name="gambarLama" value="<?= $jam["gambar"]; ?>">
					
					<div class="input_data">
						<input type="text" name="kode_barang" id="kode_barang" required placeholder="Kode Barang" value="<?= $jam["kode_barang"]; ?>">
					</div>
					<div class="input_data">
						<input type="text" name="merek" id="merek" required placeholder="Merek"
							value="<?= $jam["merek"]; ?>">
					</div>
					<div class="pilihan">
						<select name="jenis_tali" id="jenis_tali" required>
							<option value="<?= $jam["jenis_tali"]; ?>" selected><?= $jam["jenis_tali"]; ?></option>
							<option value="Rantai">Rantai</option>
							<option value="Kulit">Kulit</option>
							<option value="Karet">Karet</option>
						</select>
						<!-- <input type="text" name="jenis_tali" id="jenis_tali" required placeholder="Jenis Tali" value="<?= $jam["jenis_tali"]; ?>"> -->
					<div class="input_data"> 
						<input type="text" name="harga" id="harga" required placeholder="Harga"
							value="<?= $jam["harga"]; ?>">
					</div>

					<div class="label_img">
						<label for="gambar">Gambar : </label><br>
					</div>
					<div class="img">
						<img src="img/<?= $jam['gambar']; ?>" width="100"><br>
					</div>
					<div class="input_img">
						<input type="file" name="gambar" id="gambar">
					</div>

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