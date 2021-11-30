<?php

session_start();
include_once '../includes/config.php';

if (isset($_POST['send'])) {
    $id_akun = $_GET['id'];
    $no_pendaftaran = $_GET['no_pendaftaran'];
    $nSiswa = htmlspecialchars($_GET['username']);
    $data = $mysqli->query("SELECT * FROM tbl_reg WHERE nama_calon_siswa='$nSiswa' AND no_pendaftaran='$no_pendaftaran'") or die(mysqli_error($mysqli));
    if ($data->num_rows){
        $row = $data->fetch_array();
        $update = true;
        $id = $row['id'];
        $username = $row['nama_calon_siswa'];
        $school = $row['sekolah_daftar'];

        $filename = rand(0,99999)."_".$_FILES['receiptFile']['name'];
        $target_dir = "receipt/";
        $urlLink = 'dashboard_tk.php';
        
        if (strpos($school, 'SDIT') !== false){
            $urlLink = 'dashboard_main.php';
        }

        if ($filename != '') {
            $target_file = $target_dir.basename($filename);
            // File extension
            $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extension
            $extension_arr = array("jpg", "png", "jpeg");
            $ukuran = $_FILES['receiptFile']['size'];

            // Check extension
            if (in_array($extension, $extension_arr)) {
                if ($ukuran < 3145728) {
                    // Convert to base64
                    $image_base64 = base64_encode(file_get_contents($_FILES['receiptFile']['tmp_name']));
                    $image = "data::image/".$extension.";base64,".$image_base64;

                    // Store image to 'upload' folder
                    if (move_uploaded_file($_FILES['receiptFile']['tmp_name'], $target_file)) {
                        // Insert record
                        $sql = "UPDATE tbl_reg SET status_pendaf = 'menunggu_konfirmasi', bukti_transaksi = '$filename' WHERE id = '$id' AND no_pendaftaran = '$no_pendaftaran'";

                        $link = "location: dashboard_main.php";
                        if (strpos($school, 'TKIT') !== false) {
                          $link = "location: dashboard_tk.php";
                        }

                        if ($mysqli->query($sql) === TRUE):
                            header($link);
                        else:
                            echo '<script type="text/javascript">';
                            echo 'alert("Gagal mengunggah, silakan coba lagi");';
                            echo "window.location.href = '$urlLink';";
                            echo '</script>';
                        endif;

                        exit;
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("Ukuran file terlalu besar");';
                    echo "window.location.href = '$urlLink';";
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Hanya Support File JPG, PNG, dan JPEG");';
                echo "window.location.href = '$urlLink';";
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Tidak Ada File Dipilih!");';
            echo "window.location.href = '$urlLink';";
            echo '</script>';
        }
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Tidak Ada File Dipilih!");';
    echo "window.location.href = '$urlLink';";
    echo '</script>';
}

?>
