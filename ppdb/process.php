<?php

session_start();
include_once '../includes/config.php';

$update = false;
$id = 0;
$name = '';
$birth_place = '';
$source = '';

if (isset($_POST['save'])){
    $name = $_POST['name'];
    $birth_place = $_POST['birth_place'];

    $mysqli->query("INSERT INTO tbl_reg (nama_calon_siswa, tempat_lahir) VALUES ('$name', '$birth_place')") or die($mysqli->error);

    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    header("location: dashboard_admin.php");
}

else if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $name = $row['nama_calon_siswa'];
        $school = $row['sekolah_daftar'];
        $noPend = $row['no_pendaftaran'];
        $type = $row['type'];
        //$id_ortu = $row['id_ortu'];
        $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = '$type'");
                
        $schoolData = $getSchool->fetch_array();
        $kuota = $schoolData['sisa_kuota'] + 1;
        
        $mysqli->query("DELETE FROM tbl_reg WHERE id=$id") or die($mysqli->error);
        $mysqli->query("DELETE FROM tbl_akun WHERE username='$name' AND school='$school' AND no_pendaftaran='$noPend'") or die($mysqli->error);
        //$mysqli->query("DELETE FROM tbl_ortu WHERE id_ortu='$id_ortu'") or die($mysqli->error);
        $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuota' WHERE school_name = '$school' AND type = '$type'") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran Siswa $name Dihapus! Dan Kuota Dikembalikan";
        $_SESSION['msg_type'] = "danger";
    }
}

else if (isset($_GET['deleteNoReturn'])){
    $id = $_GET['deleteNoReturn'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $name = $row['nama_calon_siswa'];
        $school = $row['sekolah_daftar'];
        $type = $row['type'];
        $noPend = $row['no_pendaftaran'];
        //$id_ortu = $row['id_ortu'];
        
        $mysqli->query("DELETE FROM tbl_reg WHERE id=$id") or die($mysqli->error);
        $mysqli->query("DELETE FROM tbl_akun WHERE username='$name' AND school='$school' AND no_pendaftaran='$noPend'") or die($mysqli->error);
        //$mysqli->query("DELETE FROM tbl_ortu WHERE id_ortu='$id_ortu'") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran Siswa $name Dihapus! Tanpa Mengembalikan Kuota";
        $_SESSION['msg_type'] = "danger";
    }
}

else if(isset($_GET['edit']))
{
    $id = $_GET['edit'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'dibayar' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pembayaran $name Diterima";
        $_SESSION['msg_type'] = "success";

        // header("location: dashboard_admin.php?school=$school");
    }
}

else if(isset($_GET['reject']))
{
    $id = $_GET['reject'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'bukti_bayar_ditolak' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pembayaran $name Ditolak";
        $_SESSION['msg_type'] = "danger";

        //header("location: dashboard_admin.php?school=$school");
    }
}

else if(isset($_GET['check']))
{
    $id = $_GET['check'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->errors);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $school = $row['sekolah_daftar'];

        $_SESSION['nama_siswa'] = $row['nama_calon_siswa'];
        $_SESSION['bukti'] = $row['bukti_transaksi'];

        // header("location: dashboard_admin.php?school=$school");
    }
}

else if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $birth_place = $_POST['birth_place'];

    $mysqli->query("UPDATE tbl_reg SET nama_calon_siswa = '$name', tempat_lahir = '$birth_place' WHERE id = $id") or die($mysqli->error);

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['msg_type'] = "warning";

    header('location: dashboard_admin.php');
}

else if(isset($_GET['lulus']))
{
    $id = $_GET['lulus'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'lulus' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran $name Diluluskan";
        $_SESSION['msg_type'] = "success";
    }
}

else if(isset($_GET['lulus_syarat']))
{
    $id = $_GET['lulus_syarat'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'lulus_bersyarat' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran $name Diluluskan Bersyarat";
        $_SESSION['msg_type'] = "primary";
    }
}

else if(isset($_GET['cadangan']))
{
    $id = $_GET['cadangan'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'cadangan' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran $name Diubah Statusnya Menjadi Cadangan";
        $_SESSION['msg_type'] = "danger";
    }
}

else if(isset($_GET['belum_diterima']))
{
    $id = $_GET['belum_diterima'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $update = true;
        $name = $row['nama_calon_siswa'];
        $birth_place = $row['tempat_lahir'];
        $school = $row['sekolah_daftar'];
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'belum_diterima' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Pendaftaran $name Belum Diterima";
        $_SESSION['msg_type'] = "danger";
    }
}

else if (isset($_GET['return'])){
    $id = $_GET['return'];
    $result = $mysqli->query("SELECT * FROM tbl_reg WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows){
        $row = $result->fetch_array();
        $name = $row['nama_calon_siswa'];
        $school = $row['sekolah_daftar'];
        $noPend = $row['no_pendaftaran'];
        $type = $row['type'];
        
        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'dibayar' WHERE id = $id") or die($mysqli->error);

        $_SESSION['message'] = "Status Pendaftaran Siswa $name Dikembalikan!";
        $_SESSION['msg_type'] = "primary";
    }
}

?>
