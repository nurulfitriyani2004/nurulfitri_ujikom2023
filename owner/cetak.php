<?php

require 'functions.php';
$bulan = ambilsatubaris($conn,"SELECT SUM(total_harga) AS total FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.transaksi_id WHERE status_bayar = 'dibayar' AND MONTH(tgl_pembayaran) = MONTH(NOW())");
$tahun = ambilsatubaris($conn,"SELECT SUM(total_harga) AS total FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.transaksi_id WHERE status_bayar = 'dibayar' AND YEAR(tgl_pembayaran) = YEAR(NOW())");
$minggu = ambilsatubaris($conn,"SELECT SUM(total_harga) AS total FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.transaksi_id WHERE status_bayar = 'dibayar' AND WEEK(tgl_pembayaran) = WEEK(NOW())");


$penjualan = ambildata($conn,"SELECT SUM(detail_transaksi.total_harga) AS total,COUNT(detail_transaksi.paket_id) as jumlah_paket,paket.nama_paket,transaksi.tgl_pembayaran FROM detail_transaksi
INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.transaksi_id
INNER JOIN paket ON paket.id_paket = detail_transaksi.paket_id
WHERE transaksi.status_bayar = 'dibayar' GROUP BY detail_transaksi.paket_id");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>

    <center>

        <h2>DATA LAPORAN TRANSAKSI LAUNDRY</h2>
        <h6><?= strftime('%A %d %B %Y') ?></h6>
        <h6 class="mr-auto">Oleh : <?= $_SESSION['username']; ?></h6>
        <br>
    </center>
    <table class="table table-bordered" style="width: 100%;">
        <thead>
            <tr>
            <th style="width: 3%">#</th>
            <td><b>Nama Paket</b></td>
            <td><b>Jumlah Transaksi</b></td>
            <td><b>Tanggal Transaksi</b></td>
            <td><b>Total Hasil</b></td>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach($penjualan as $transaksi): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $transaksi['nama_paket'] ?></td>
                                    <td><?= $transaksi['jumlah_paket'] ?></td>
                                    <td><?= $transaksi['tgl_pembayaran'] ?></td>
                                    <td><?= $transaksi['total'] ?></td>                                    
                                </tr>
                            <?php endforeach;
                             ?>
            
            
        </tbody>
    </table>

    <script>
        window.print();
    </script>

</body>

</html>