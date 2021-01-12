<?php 
require 'functions.php';

// mengecek tombol register
if ( isset($_POST["regis"]) ) {
	
	if ( registrasi($_POST) > 0 ) {
		echo "<script>
				alert('user baru berhasil ditambahkan!');
				document.location.href = 'login.php';
			</script>";
	} else {
		echo mysqli_error($conn);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Pendaftaran</title>
	<link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body class="bdy">

<div class="isi">

	<h2>ADMIN REGISTER</h2>

	<form action="" method="post">
		<div class="input_data">
			<input type="text" name="username" id="username" autofocus placeholder="Username">
		</div>
		<div class="password">
			<input type="password" name="password" id="password" autofocus placeholder="Password">
		</div>
		<div class="password">
			<input type="password" name="password2" id="password2"
			autofocus placeholder="Konfirmasi Password">
		</div>

		<div class="tmbl_submit">
			<button type="submit" name="regis">Daftar</button>
		</div>
	</form>
</div>

</body>
</html>
