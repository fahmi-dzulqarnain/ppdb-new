<?php

//include_once '../includes/config.php';
$unit = "SMAIT-Fajar-Ilahi-1";
$username = "panitia-smaitfi";
$pass = md5("Sma1t_FI1");
$mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, school) VALUES ('$username', '$pass', 'panitia', '$unit')") or die($mysqli->error);
echo 'Pendaftaran Akun '.$unit.' Sukses!';

?>
