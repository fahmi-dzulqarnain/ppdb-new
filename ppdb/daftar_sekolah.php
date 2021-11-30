<?php

$mysqli = new mysqli('localhost', 'ppdbalka_fahmi', 'Al-K4hfi_Batam', 'ppdbalka_ppdb_db') or die(mysqli_error($mysqli));
$unit = "Pondok-Khadijah";
$username = "panitia-khodijah";
$pass = md5("pKhodiJAH");
$mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, school) VALUES ('$username', '$pass', 'panitia', '$unit')") or die($mysqli->error);
echo 'Pendaftaran Akun '.$unit.' Sukses!';

?>
