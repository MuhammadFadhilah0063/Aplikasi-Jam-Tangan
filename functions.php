<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "toko");

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];

	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

function tambah($data) {
	global $conn;

	// ambil data dari tiap elemen dalam form
	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$merek = htmlspecialchars($data["merek"]);
	$jenis_tali = htmlspecialchars($data["jenis_tali"]);
	$stok = htmlspecialchars($data["stok"]);
	$harga = htmlspecialchars($data["harga"]);
	
	// upload gambar
	$gambar = upload();
	if ( !$gambar ) { // !$gambar ( $gambar === false ) atau tidak ada file yg diupload
		return false; // untuk menghentikan query insert
	}

	// query insert data
	$query = "INSERT INTO  jam_tangan
				VALUES 
				('', '$kode_barang', '$merek', '$jenis_tali', '$stok', '$harga', '$gambar')
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload() {

	// untuk mengambil elemen file yang tadi di upload ke penyimpanan sementara
	// ke dalam sebuah variabel
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']["size"];
	$error = $_FILES['gambar']["error"];
	$tmpName = $_FILES['gambar']["tmp_name"];

	// cek apakah tidak ada gambar yg diupload
	if ( $error === 4 ) {
		echo "<script>
				alert('Pilih gambar terlebih dahulu!');
			</script";
		return false; // untuk menggagalkan function tambah jika function upload gagal
	}


	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png']; 
	// untuk pilhan file yg dibolehkan
	// explode untuk memecah string menjadi array dan delimiter ini bertugas memecahnya

	$ekstensiGambar = explode('.', $namaFile); // fadil.jpg = ['fadil', 'jpg']
	$ekstensiGambar = strtolower(end($ekstensiGambar)); 
	// end untuk mengambil index array terakhir
	// strtolower untuk mengubah string menjadi huruf kecil semua a.JPG = a.jpg

	// untuk mengecek adakah string di dalam array
	if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
				alert('Yang anda upload bukan gambar!');
			</script";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ( $ukuranFile > 1000000 ) {
		echo "<script>
				alert('Ukuran gambar terlalu besar!');
			</script";
		return false;
	}

	// generete nama gambar baru
	$namaFileBaru = uniqid(); // untuk membuat string angka random
	$namaFileBaru .= '.'; // .= untuk menggabung string namaFileBaru
	$namaFileBaru .= $ekstensiGambar;

	// setelah lolos pengecekan, maka gambar siap diupload
	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru; 
	// mengembalikan nama file ke fungsi tambah bagian fungsi upload dan di buat ke variabel $gambar, agar bisa dimasukkan ke database.
}

// fungsi hapus

function hapus($id) {
	global $conn;

	mysqli_query($conn, "DELETE FROM jam_tangan WHERE id = $id");
	return mysqli_affected_rows($conn);
}

function hapus_laporan_masuk($id) {
	global $conn;

	mysqli_query($conn, "DELETE FROM barang_masuk WHERE id_bm = $id");
	return mysqli_affected_rows($conn);
}

function hapus_laporan_keluar($id) {
	global $conn;

	mysqli_query($conn, "DELETE FROM barang_keluar WHERE id_bk = $id");
	return mysqli_affected_rows($conn);
}

// fungsi ubah

function ubah($data) {
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id = $data["id"];
	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$merek = htmlspecialchars($data["merek"]);
	$jenis_tali = htmlspecialchars($data["jenis_tali"]);
	$stok = htmlspecialchars($data["stok"]);
	$harga = htmlspecialchars($data["harga"]);
	$gambarLama = $data["gambarLama"];

	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}
	
	// query insert data
	$query = "UPDATE jam_tangan SET 
				kode_barang = '$kode_barang',
				merek = '$merek',
				jenis_tali = '$jenis_tali',
				stok = '$stok',
				harga = '$harga',
				gambar = '$gambar'
			WHERE id = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubah_laporan_masuk($data) {
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id = $data["id_bm"];
	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$tgl_masuk = htmlspecialchars($data["tgl_masuk"]);
	$jumlah = htmlspecialchars($data["jumlah"]);

	// query insert data
	$query = "UPDATE barang_masuk SET 
				kode_barang = '$kode_barang',
				tgl_masuk = '$tgl_masuk',
				jumlah = '$jumlah'
			WHERE id_bm = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubah_laporan_keluar($data) {
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id = $data["id_bk"];
	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$tgl_keluar = htmlspecialchars($data["tgl_keluar"]);
	$jumlah = htmlspecialchars($data["jumlah"]);

	// query insert data
	$query = "UPDATE barang_keluar SET 
				kode_barang = '$kode_barang',
				tgl_keluar = '$tgl_keluar',
				jumlah = '$jumlah'
			WHERE id_bk = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function cari($keyword) {
	// untuk menuliskan fungsi format query atau string query
	$query = "SELECT * FROM jam_tangan 
				WHERE 
			merek LIKE '%$keyword%' OR 
			kode_barang LIKE '%$keyword%' OR 
			jenis_tali LIKE '%$keyword%' OR
			harga LIKE '%$keyword%'
			";
	return query($query);
}

function cari_masuk($keyword) {
	// untuk menuliskan fungsi format query atau string query
	$query = "SELECT * FROM barang_masuk 
				WHERE 
			kode_barang LIKE '%$keyword%' OR 
			tgl_masuk LIKE '%$keyword%'
			";
	return query($query);
}

function cari_keluar($keyword) {
	// untuk menuliskan fungsi format query atau string query
	$query = "SELECT * FROM barang_keluar 
				WHERE 
			kode_barang LIKE '%$keyword%' OR 
			tgl_keluar LIKE '%$keyword%'
			";
	return query($query);
}


function registrasi($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	// stripcslashes untuk menghilangkan karakter backslash
	// agar nama yang diinputkan user menjadi huruf kecil

	$password = mysqli_real_escape_string($conn, $data["password"]);
	// mysqli_real_escape_string untuk user dapat menginput tanda kutip

	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE 	
				username = '$username'");

	if ( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('Username sudah ada!')
			</script>";

			return false;
	}

	// cek konfirmasi password
	if ( $password !== $password2 ) {
		echo "<script>
				alert('Konfirmasi password tidak sesuai!');
			</script>";
			return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user VALUES
				('', '$username', '$password')"
				);
	// untuk menghasilkan nilai 1 jika berhasil menambahkan data
	return mysqli_affected_rows($conn);
}


// ambil data (fetch) jam_tangan dari object result
// 4 cara mengambil data
// mysqli_fetch_row() // mengembalikan array numerik
// mysqli_fetch_assoc() // mengembalikan array associative
// mysqli_fetch_array() // menegmbalikan keduanya // mines datanya double
// mysqli_fetch_object()
?>