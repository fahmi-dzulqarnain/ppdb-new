<?php

session_start();
include_once '../includes/config.php';

if (isset($_POST['login'])){
    $username = strtoupper($_POST['username']);
    $rawPass = $_POST['password'];
    $password = md5($rawPass);

    $result = $mysqli->query("SELECT * FROM tbl_akun WHERE username = '$username' AND sandi = '$password'") or die($mysqli->error);

    if($result->num_rows){
        $row = $result->fetch_array();
        $tipeAkun = $row['tipe_akun'];
        $school = $row['school'];
        
        if ($tipeAkun == 'calon_siswa'){
            $id = $row['no_pendaftaran'];
            $tglLhr = substr($rawPass, 0, 2) . '/' . substr($rawPass, 2, 2) . '/' . substr($rawPass, 4, 4);
            if (strpos($school, 'TKIT') !== false){
                header("location: ../ppdb/dashboard_tk.php");
                sendSession($id, $username, $school, $tglLhr);
            } else if (strpos($school, 'SDIT') !== false) {
                header("location: ../ppdb/dashboard_main.php");
                sendSession($id, $username, $school, $tglLhr);
            } else if (strpos($school, 'SMPIT') !== false) {
                header("location: ../ppdb/dashboard_main.php");
                sendSession($id, $username, $school, $tglLhr);
            } else if (strpos($school, 'SMAIT') !== false) {
                header("location: ../ppdb/dashboard_main.php");
                sendSession($id, $username, $school, $tglLhr);
            } else if (strpos($school, 'Pondok') !== false) {
                header("location: ../ppdb/dashboard_main.php");
                sendSession($id, $username, $school, $tglLhr);
            }
        } else if ($tipeAkun == 'admin') {
            header("location: ../ppdb/dashboard_admin.php");
            $_SESSION['school'] = $school;
        } else if ($tipeAkun == 'panitia') {
            header("location: ../ppdb/dashboard_admin_panitia.php");
            $_SESSION['school'] = $school;
        }
    }
    else {
        echo '<script type="text/javascript">';
        echo 'alert("Akun Tidak Ditemukan, atau Kata Sandi Salah");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
    }

}

function sendSession($id, $username, $school, $tglLhr){
    $_SESSION['id'] = $id;
    $_SESSION['username'] = strtoupper($username);
    $_SESSION['school'] = $school;
    $_SESSION['tanggal_lahir'] = $tglLhr;
}

?>
