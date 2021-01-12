<?php

require_once __DIR__ . '/vendor/autoload.php';

// memanggil function.php
require 'functions.php';

// variabel untuk meyimpan data tabel (lemari)
$jamTangan = query("SELECT * FROM jam_tangan ");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html>
<head>
    <title>Cetak Daftar Jam Tangan</title>
    <link rel="stylesheet" href="css/cetak.css?v=1.0">
</head>
<body>

	<p>Daftar Jam Tangan</p>
	<hr align="right" width="60%" height="1px" color="red" size="3">

	<table class="table1" border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Merek</th>
            <th>Jenis Tali</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Gambar</th>
        </tr>'; // dipisah dulu agar bisa memasukkan logic php

        // logicnya
        $i = 1;
        foreach ($jamTangan as $row) {
        	$html .= '<tr>
        		<td>'. $i++ .'</td>
        		<td>'. $row["kode_barang"] .'</td>
        		<td>'. $row["merek"] .'</td>
        		<td>'. $row["jenis_tali"] .'</td>
        		<td>'. $row["stok"] .'</td>
        		<td>'. $row["harga"] .'</td>
        		<td><img src="img/'. $row["gambar"] .'" width="100px" ></td>
        	</tr>';
        }

// menggabungkan string dengan sebelumnya
$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Daftar-Jam_tangan.pdf', 'I');

