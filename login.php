<?php 
// menjalankan session
session_start();
require 'functions.php';

// cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];

	// ambil username berdasarkan idnya
	$result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
	$row = mysqli_fetch_assoc($result);

	// cek cookie dan username
	if( $key === hash('sha256', $row['username']) ) {
		$_SESSION['login'] = true;
	}

}

// untuk mengecek sudah login apa belum, jika sdh
// maka akan kembali ke index agar tidak login 2 kali
if ( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
} 


if ( isset($_POST["login"]) ) {

	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// cek username
	// mysqli_num_rows untuk mengecek apakah ada kembalian baris dari
	// $result, jika iya makan akan bernilai 1
	if ( mysqli_num_rows($result) === 1 ) {

		// cek password
		$row = mysqli_fetch_assoc($result);

		// password_verify() Kebalikan dari password_hash(), fungsinya untuk mengecek stringnya sama atau tidak dengan hashnya
		 if ( password_verify($password, $row["password"]) ) {
		 	// set session
		 	$_SESSION["login"] = true; // untuk variabel login

		 	// cek remember me
		 	if ( isset($_POST["remember"]) ) {
		 		// buat cookie
		 		setcookie('id', $row['id'], time() + 60);
		 		setcookie('key', hash('sha256', $row["username"]), time() + 60);
		 	}

		 	// untuk direct ke index.php
		 	header("Location: index.php");
		 	// agar code dibawah tidak dieksekusi
		 	exit;
		 	}

	}
	// jika password salah
	$error = true;
} 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body class="bdy">

<div class="isi">

	<h2>ADMIN LOGIN</h2>

	<form action="" method="post">
		<div class="input_data">
			<input type="text" name="username" id="username" autofocus placeholder="Username" autocomplete="on">
		</div>
		<div class="password">
			<input type="password" name="password" id="password" autofocus placeholder="Password" autocomplete="on">
		</div>
			
		<!-- pesan kegagalan -->
		<div class="pesan_error">
			<?php if( isset($error) ) : ?>
				<p>username / password salah</p>
			<?php endif; ?>
		</div>

		<div class="tmbl_submit">
			<button type="submit" name="login">Login</button>
		</div>
	</form>

	<form method="post" action="registrasi.php" class="daftar">
		<div class="daftar">
			<button type="submit" nama="daftar">---</button>
		</div>
	</form>

</div>

</body>
</html>