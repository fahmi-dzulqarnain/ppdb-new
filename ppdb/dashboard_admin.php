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
    ?>

    <div class="d-flex mb-3 bg-success" style="padding: 5px;">
        <div class="p-2 mr-auto bg-success" style="margin-top: 15px; margin-left: 10px; margin-right: 10px">
            <p style="color: white;">Admin <?php echo str_replace('-',' ', $school) ?></p>
        </div>
        <div class="p-2">
            <input class="form-control" id="searchBox" type="text" placeholder="Cari..">
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin.php">
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
        <div class="p-2  bg-success">
            <a href="dashboard_admin_accepted.php">
                <div>
                    <i class="fas fa-table" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Cek Disetujui</p>
                </div>
            </a>
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin_other.php">
                <div>
                    <i class="fas fa-table" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Cek Lainnya</p>
                </div>
            </a>
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin_rejected.php">
                <div>
                    <i class="fas fa-table" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Cek Ditolak</p>
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
    <?php
        if(isset($_SESSION['bukti'])):
            $source = $_SESSION['bukti'];
            $name = $_SESSION['nama_siswa'];
            echo "<script type='text/javascript'>
                $(document).ready(function(){
                    $('#receiptModal').modal('show');
                });
                </script>";
            unset($_SESSION['bukti']);
            // else: unset($_SESSION['bukti']);
        endif; ?>
    <div>
        <?php
            $result = $mysqli->query("SELECT * FROM tbl_reg WHERE status_pendaf='menunggu_konfirmasi' AND sekolah_daftar='$school'") or die($mysqli->error);
            $restore = $mysqli->query("SELECT * FROM tbl_reg WHERE status_pendaf='menunggu_pembayaran' AND sekolah_daftar='$school'") or die($mysqli->error);
            
            if (strpos($school, 'TKIT') !== false) {
                $getSchoolA = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = 'TK A'");
                $getSchoolB = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = 'TK B'");
                
                $schoolDataA = $getSchoolA->fetch_array();
                $schoolDataB = $getSchoolB->fetch_array();
                $kuotaA = $schoolDataA['sisa_kuota'];
                $kuotaB = $schoolDataB['sisa_kuota'];
                $now = time();
    
                while ($row = $restore->fetch_assoc()){
                    $waktuLimit = $row['waktu_daftar'] + 24 * 60 * 60;
                    if ($now > $waktuLimit){
                        if ($row['type'] == 'TK A'){
                            $kuotaA++;
                            $id = $row['id'];
                            $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'pendaftaran_batal' WHERE id = $id") or die($mysqli->error);
                        } else if ($row['type'] == 'TK B'){
                            $kuotaB++;
                            $id = $row['id'];
                            $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'pendaftaran_batal' WHERE id = $id") or die($mysqli->error);
                        } 
                        
                    }
                }
    
                $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuotaA' WHERE school_name = '$school' AND type = 'TK A'") or die($mysqli->error);
                $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuotaB' WHERE school_name = '$school' AND type = 'TK B'") or die($mysqli->error);
            } else if (strpos($school, 'SDIT') !== false || strpos($school, 'SMPIT') !== false || strpos($school, 'SMAIT') !== false) {
                $getSchoolA = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = 'LK'");
                $getSchoolB = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = 'PR'");
                
                $schoolDataA = $getSchoolA->fetch_array();
                $schoolDataB = $getSchoolB->fetch_array();
                $kuotaA = $schoolDataA['sisa_kuota'];
                $kuotaB = $schoolDataB['sisa_kuota'];
                $now = time();
    
                while ($row = $restore->fetch_assoc()){
                    $waktuLimit = $row['waktu_daftar'] + 24 * 60 * 60;
                    if ($now > $waktuLimit){
                        if ($row['type'] == 'LK'){
                            $kuotaA++;
                            $id = $row['id'];
                            $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'pendaftaran_batal' WHERE id = $id") or die($mysqli->error);
                        } else if ($row['type'] == 'PR'){
                            $kuotaB++;
                            $id = $row['id'];
                            $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'pendaftaran_batal' WHERE id = $id") or die($mysqli->error);
                        } 
                        
                    }
                }
    
                $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuotaA' WHERE school_name = '$school' AND type = 'LK'") or die($mysqli->error);
                $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuotaB' WHERE school_name = '$school' AND type = 'PR'") or die($mysqli->error);
            } else if (strpos($school, 'Pondok') !== false) {
                $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school'");
                
                $schoolData = $getSchool->fetch_array();
                $kuota = $schoolData['sisa_kuota'];
                $now = time();
    
                while ($row = $restore->fetch_assoc()){
                    $waktuLimit = $row['waktu_daftar'] + 24 * 60 * 60;
                    if ($now > $waktuLimit){
                        $kuota++;
                        $id = $row['id'];
                        $mysqli->query("UPDATE tbl_reg SET status_pendaf = 'pendaftaran_batal' WHERE id = $id") or die($mysqli->error);
                    }
                }
    
                $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuota' WHERE school_name = '$school'") or die($mysqli->error);
            }
            ?>

            <div style="margin: 20px">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Daftar</th>
                            <th>Nama Calon Siswa</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenjang/JK</th>
                            <th>Nama Ayah</th>
                            <th>No HP Ayah</th>
                            <?php if (strpos($school, 'SDIT') !== false || strpos($school, 'SMPIT') !== false || strpos($school, 'SMAIT') !== false):?>
                                <th>Asal Sekolah</th>
                            <?php endif ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="mainTable">
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo sprintf("%'.03d\n", $row['no_pendaftaran']); ?></td>
                            <td><?php echo $row['nama_calon_siswa']; ?></td>
                            <td><?php echo $row['tempat_lahir']; ?></td>
                            <td><?php echo $row['tanggal_lahir']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <?php
                                $id_ortu = $row['id_ortu'];
                                $nama_ayah = '';
                                $no_hp_ayah = '';
                                $ortu_data = $mysqli->query("SELECT * FROM tbl_ortu WHERE id_ortu=$id_ortu") or die($mysqli->error);

                                if ($ortu_data->num_rows){
                                    $rows = $ortu_data->fetch_array();
                                    $nama_ayah = $rows['nama_ayah'];
                                    $no_hp_ayah = $rows['no_hp_ayah'];
                                }
                            ?>
                            <td><?php echo $nama_ayah; ?></td>
                            <td><?php echo $no_hp_ayah; ?></td>
                            <?php if (strpos($school, 'SDIT') !== false || strpos($school, 'SMPIT') !== false || strpos($school, 'SMAIT') !== false):?>
                                <td><?php echo $row['asal_sekolah']; ?></td>
                            <?php endif ?>
                            <td>
                                <a href="dashboard_admin.php?check=<?php echo $row['id']; ?>" class="btn btn-primary">Cek Bukti Pembayaran</a>
                                <a href="dashboard_admin.php?edit=<?php echo $row['id']; ?>" class="btn btn-success" style="margin-left: 12px;">Setujui Pembayaran</a>
                                <a href="dashboard_admin.php?reject=<?php echo $row['id']; ?>" class="btn btn-danger" style="margin-left: 12px;">Tolak Pembayaran</a>
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

        <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiptModalLabel">Bukti Pembayaran <?php echo $name; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <img id="receiptImg" class="zoom" src="receipt/<?php echo $source; ?>" style="max-width: 465px" />
                    </div>
                </div>
            </div>
        </div>
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
