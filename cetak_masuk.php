<?php

require_once __DIR__ . '/vendor/autoload.php';

// memanggil function.php
require 'functions.php';

// variabel untuk meyimpan data tabel (lemari)
$barang_masuk = query("SELECT * FROM barang_masuk ");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Barang Masuk</title>
    <link rel="stylesheet" href="css/cetak.css?v=1.0">
</head>
<body>

	<p>Laporan Barang Masuk</p>
	<hr align="right" width="60%" height="1px" color="red" size="3">

	<table class="table1" border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Masuk</th>
        </tr>'; // dipisah dulu agar bisa memasukkan logic php

        // logicnya
        $i = 1;
        foreach ($barang_masuk as $row) {
        	$html .= '<tr>
        		<td>'. $i++ .'</td>
        		<td>'. $row["kode_barang"] .'</td>
        		<td>'. $row["jumlah"] .'</td>
        		<td>'. $row["tgl_masuk"] .'</td>
        	</tr>';
        }

// menggabungkan string dengan sebelumnya
$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_barang_masuk.pdf', 'I');

