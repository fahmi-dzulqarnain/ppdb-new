<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Import Excel Santri</title>

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    session_start();
    require("includes/config.php");
    require 'iexcel/vendor/autoload.php';

    if (isset($_GET['berhasil'])) {
        echo "<p>" . $_GET['berhasil'] . " Data berhasil di import.</p>";
    }

    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if (isset($_FILES['fileimport']['name']) && in_array($_FILES['fileimport']['type'], $file_mimes)) {

        $arr_file = explode('.', $_FILES['fileimport']['name']);
        $extension = end($arr_file);

        if ('csv' == $extension) $reader = new Csv();
        else $reader = new Xlsx();

        $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        
        $unit = 'TKIT-Fajar-Ilahi-2';
        $type = 'TK A';
        
        for ($i = 1; $i < count($sheetData); $i++) {
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
        
            $noPend = $sheetData[$i]['1'];
            $nSiswa = str_replace("'", "\'", strtoupper($sheetData[$i]['2']));
            $tmptLhr = strtoupper($sheetData[$i]['3']);
            $tglLhr = $sheetData[$i]['4'];
            $nAyah = str_replace("'", "\'", strtoupper($sheetData[$i]['5']));
            $nIbu = str_replace("'", "\'", strtoupper($sheetData[$i]['6']));
            $timestamp = time();


            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar, type, id_ortu, nominal_trf, status_pendaf)
                            VALUES ('$noPend', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit', '$type', '$id', '$nominalTrf', 'dibayar')") or die($mysqli->error);
            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

            $kuota = $schoolData['sisa_kuota'] - 1;
            $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);   
        }

        header( "Location:manual.php?berhasil=".count($sheetData));
        exit;
    }
    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Import Excel Data Santri
                    </div>
                    <div class="card-content">
                        <p class="card-title"><b>Import Excel</b></p>
                        <form enctype="multipart/form-data" method="post">
                            <div class="row">
                                <label for="default-btn" class="custom-file-upload col file-name">
                                    Pilih Berkas
                                </label>
                                <input id="default-btn" type="file" onchange="preview()" name="fileimport">
                                <button type="submit" class="custom-file-upload col-bigger" style="padding-bottom:10px;" name="btnSubmit"> <i class="fas fa-file-import"></i> Import</button>
                            </div>
                        </form>
                        <table style="margin-top: 2%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">Hafalan Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $data = $mysqli->query("SELECT * FROM tbl_santri");
                                while ($d = $data->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $d['nama_lengkap']; ?></td>
                                        <td><?php echo $d['nis']; ?></td>
                                        <td><?php echo $d['hafalan_terakhir']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="index.js"></script>
    <script src="includes/file_upload.js"></script>
</body>

</html>