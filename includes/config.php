<?php

$hostname = 'localhost';
$username = 'u1969925_mid'; //'fajarila_user';
$password = 'AlkahfiWeb"1443H'; //'AlK4hfi1442.';
$database = 'u1969925_ppdb';

$mysqli = mysqli_connect($hostname, $username, $password, $database) or die (mysqli_error($mysqli));
// $mysqli = new mysqli('localhost', 'ppdbalka_fahmi', 'Al-K4hfi_Batam', 'ppdbalka_ppdb_db') or die(mysqli_error($mysqli));
// $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));

?>