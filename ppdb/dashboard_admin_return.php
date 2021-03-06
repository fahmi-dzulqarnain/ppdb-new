<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pendaftaran</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <style>
        .zoom {
            padding: 50px;
            background-color: transparent;
            transition: transform .2s;
            margin: 0 auto;
        }

        .zoom:hover {
            -ms-transform: scale(1.5); /* IE 9 */
            -webkit-transform: scale(1.5); /* Safari 3-8 */
            transform: scale(1.5);
        }
    </style>
</head>
<body>
    <?php
        require_once 'process.php';
        $school = '';

        if (isset($_GET['school'])) {
            session_destroy();
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../login/";';
            echo '</script>';
        }

        if (isset($_SESSION['school'])){
            $school = $_SESSION['school'];
        } else {
            session_destroy();
            echo '<script type="text/javascript">';
            echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
        }
                    
        $count = $mysqli->query("SELECT * FROM tbl_reg WHERE sekolah_daftar='$school' AND status_pendaf != 'pendaftaran_batal' AND status_pendaf != 'bukti_bayar_ditolak'") or die($mysqli->error);
    ?>

    <div class="d-flex mb-3 bg-success" style="padding: 5px;">
        <div class="p-2 mr-auto bg-success" style="margin-top: 15px; margin-left: 10px; margin-right: 10px">
            <p style="color: white;">Status Kelulusan <?php echo str_replace('-',' ', $school) ?> (Jumlah Pendaftar <?php echo mysqli_num_rows($count) ?>) </p>
        </div>
        <div class="p-2">
            <input class="form-control" id="searchBox" type="text" placeholder="Cari..">
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin_panitia.php">
                <div>
                    <i class="fas fa-arrow-left" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Kembali</p>
                </div>
            </a>
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin_return.php">
                <div>
                    <i class="fas fa-redo" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Refresh</p>
                </div>
            </a>
        </div>
        <div class="p-2  bg-success">
            <a href="?school=logout">
                <div>
                    <i class="fas fa-sign-out-alt" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Keluar</p>
                </div>
            </a>
        </div>
        
    </div>

    <?php
        if(isset($_SESSION['message'])): ?>

        <div class="alert alert-<?=$_SESSION['msg_type']?>">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
    <div>
        <?php
            $result = $mysqli->query("SELECT * FROM tbl_reg WHERE sekolah_daftar='$school' AND status_pendaf != 'pendaftaran_batal' AND status_pendaf != 'bukti_bayar_ditolak' ORDER BY no_pendaftaran") or die($mysqli->error);
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school'");
            $schoolData = $getSchool->fetch_array();
        ?>
            <div style="margin: 20px">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Daftar</th>
                            <th>Nama Calon Siswa</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Jenjang/JK</th>
                            <th>Nama Ayah</th>
                            <th>Nama Ibu</th>
                            <th>No HP Ayah</th>
                            <th>No HP Ibu</th>
                            <th>Alamat</th>
                            <?php if (strpos($school, 'SDIT') !== false):?>
                                <th>Asal</th>
                            <?php elseif (strpos($school, 'SMPIT') !== false):?>
                                <th>Asal</th>
                                <th>R41</th>
                                <th>R42</th>
                                <th>R51</th>
                                <th>R52</th>
                                <th>R61</th>
                                <th>Prestasi</th>
                            <?php elseif (strpos($school, 'SMAIT') !== false || strpos($school, 'Pondok') !== false):?>
                                <th>Asal</th>
                                <th>R71</th>
                                <th>R72</th>
                                <th>R81</th>
                                <th>R82</th>
                                <th>R91</th>
                                <th>Prestasi</th>
                            <?php endif ?>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mainTable">
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php $ttl = $row['tempat_lahir'].', '.$row['tanggal_lahir']; ?>
                            <td><?php echo sprintf("%'.03d\n", $row['no_pendaftaran']); ?></td>
                            <td><?php echo $row['nama_calon_siswa']; ?></td>
                            <td><?php echo $ttl; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <?php
                                $id_ortu = $row['id_ortu'];
                                $nama_ayah = '';
                                $nama_ibu = '';
                                $no_hp_ayah = '';
                                $no_hp_ibu = '';
                                $alamat = '';
                                $ortu_data = $mysqli->query("SELECT * FROM tbl_ortu WHERE id_ortu=$id_ortu") or die($mysqli->error);

                                if ($ortu_data->num_rows){
                                    $rows = $ortu_data->fetch_array();
                                    $nama_ayah = $rows['nama_ayah'];
                                    $nama_ibu = $rows['nama_ibu'];
                                    $no_hp_ayah = $rows['no_hp_ayah'];
                                    $no_hp_ibu = $rows['no_hp_ibu'];
                                    $alamat = $rows['alamat'].', '.$rows['kelurahan'].', '.$rows['kecamatan'];
                                }
                            ?>
                            <td><?php echo $nama_ayah; ?></td>
                            <td><?php echo $nama_ibu; ?></td>
                            <td><?php echo $no_hp_ayah; ?></td>
                            <td><?php echo $no_hp_ibu; ?></td>
                            <td><?php echo $alamat; ?></td>
                            <?php if (strpos($school, 'SDIT') !== false):?>
                                <th><?php echo $row['asal_sekolah']; ?></th>
                            <?php elseif (strpos($school, 'SMPIT') !== false):?>
                                <th><?php echo $row['asal_sekolah']; ?></th>
                                <th><?php echo $row['rata_rapor_4_1']; ?></th>
                                <th><?php echo $row['rata_rapor_4_2']; ?></th>
                                <th><?php echo $row['rata_rapor_5_1']; ?></th>
                                <th><?php echo $row['rata_rapor_5_2']; ?></th>
                                <th><?php echo $row['rata_rapor_6_1']; ?></th>
                                <th><?php echo $row['prestasi']; ?></th>
                            <?php elseif (strpos($school, 'SMAIT') !== false || strpos($school, 'Pondok') !== false):?>
                                <th><?php echo $row['asal_sekolah']; ?></th>
                                <th><?php echo $row['rata_rapor_4_1']; ?></th>
                                <th><?php echo $row['rata_rapor_4_2']; ?></th>
                                <th><?php echo $row['rata_rapor_5_1']; ?></th>
                                <th><?php echo $row['rata_rapor_5_2']; ?></th>
                                <th><?php echo $row['rata_rapor_6_1']; ?></th>
                                <th><?php echo $row['prestasi']; ?></th>
                            <?php endif ?>
                            <td><?php echo ucwords(str_replace('_',' ', $row['status_pendaf'])); ?></td>
                            <td>
                                <?php if ($row['status_pendaf'] == "lulus" || $row['status_pendaf'] == "belum_diterima" || $row['status_pendaf'] == "lulus_bersyarat" || $row['status_pendaf'] == "cadangan"): ?>
                                    <a href="dashboard_admin_return.php?return=<?php echo $row['id']; ?>" class="btn btn-success">Kembalikan</a>
                                <?php else: ?>
                                    <a href="dashboard_admin_return.php?return=<?php echo $row['id']; ?>" class="btn btn-danger disabled">Kembalikan</a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php
            
            function pre_r( $array ){
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
        ?>
    </div>

    <script>
        $(document).ready(function(){
            $("#searchBox").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#mainTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
