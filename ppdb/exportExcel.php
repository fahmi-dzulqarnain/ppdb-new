// <?php

// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $htmlString = '<table>
//                   <tr>
//                       <td>Hello World</td>
//                   </tr>
//                   <tr>
//                       <td>Hello<br />World</td>
//                   </tr>
//                   <tr>
//                       <td>Hello<br>World</td>
//                   </tr>
//               </table>';

// $reader = new PhpOffice\PhpSpreadsheet\Reader\Html();
// $spreadsheet = $reader->loadFromString($htmlString);

// $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('write.xlsx'); 

// ?>

<?php

if (isset($_SESSION['school'])){
    $school = $_SESSION['school'];
} else {
    session_destroy();
    echo '<script type="text/javascript">';
    echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
    echo 'window.location.href = "login_daftar.php";';
    echo '</script>';
}

$mysqli = new mysqli('localhost', 'ppdbalka_fahmi', 'Al-K4hfi_Batam', 'ppdbalka_ppdb_db') or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT * FROM tbl_reg WHERE status_pendaf='dibayar' AND sekolah_daftar='$school'") or die($mysqli->error);
$getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school'");
$schoolData = $getSchool->fetch_array();

$htmlString = '<table border="1">
        <thead>
            <tr>
                <th>No. Daftar</th>
                <th>Nama Calon Siswa</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenjang/JK</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th>No HP Ayah</th>
                <th>No HP Ibu</th>
            </tr>
        </thead>
        <tbody id="mainTable">';
            while ($row = $result->fetch_assoc()):
                $htmlString = $htmlString.'<tr>
                              <td>'.$row["no_pendaftaran"].'</td>
                              <td>'.$row["nama_calon_siswa"].'</td>
                              <td>'.$row["tempat_lahir"].'</td>
                              <td>'.$row["tanggal_lahir"].'</td>
                              <td>'.$row["type"].'</td>';
                $id_ortu = $row["id_ortu"];
                $nama_ayah = "";
                $nama_ibu = "";
                $no_hp_ayah = "";
                $ortu_data = $mysqli->query("SELECT * FROM tbl_ortu WHERE id_ortu=$id_ortu") or die($mysqli->error);

                if ($ortu_data->num_rows){
                    $rows = $ortu_data->fetch_array();
                    $nama_ayah = $rows["nama_ayah"];
                    $nama_ibu = $rows["nama_ibu"];
                    $no_hp_ayah = $rows["no_hp_ayah"];
                    $no_hp_ibu = $rows["no_hp_ibu"];
                }
                
                $htmlString = $htmlString.'<td>'.$nama_ayah.'</td>
                            <td>'.$nama_ibu.'</td>
                            <td>'.$no_hp_ayah.'</td>
                            <td>'.$no_hp_ibu.'</td>
                        </tr>';
            endwhile;
$htmlString = $htmlString.'</tbody></table>';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Pendaftaran.xls");

?>
	
	<?php
            echo $htmlString;
            // function pre_r( $array ){
            //     echo '<pre>';
            //     print_r($array);
            //     echo '</pre>';
            // }
            echo '<script type="text/javascript">';
            echo 'window.location.href = "dashboard_admin_accepted.php";';
            echo '</script>';
        ?>