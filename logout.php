<?php 

session_start();

// agar memastikan sessionnya di hilangkan atau di destroy
$_SESSION = [];
session_unset();

session_destroy();

// hapus cookie
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

header("Location: login.php");
	exit;
	
?>