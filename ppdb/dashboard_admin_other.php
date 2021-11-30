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
        
        $count = $mysqli->query("SELECT * FROM tbl_reg WHERE sekolah_daftar='$school'") or die($mysqli->error);
    ?>

    <div class="d-flex mb-3 bg-success" style="padding: 5px;">
        <div class="p-2 mr-auto bg-success" style="margin-top: 15px; margin-left: 10px; margin-right: 10px">
            <p style="color: white;">Status Pendaftar Lain  <?php echo str_replace('-',' ', $school) ?> (Jumlah Pendaftar <?php echo mysqli_num_rows($count) ?>) </p>
        </div>
        <div class="p-2">
            <input class="form-control" id="searchBox" type="text" placeholder="Cari..">
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin.php">
                <div>
                    <i class="fas fa-arrow-left" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Kembali</p>
                </div>
            </a>
        </div>
        <div class="p-2  bg-success">
            <a href="dashboard_admin_other.php">
                <div>
                    <i class="fas fa-redo" style="color: white;"></i>
                    <p style="color: white; font-size: 12px">Refresh</p>
                </div>
            </a>
        </div>
        <!--<div class="p-2  bg-success">-->
        <!--    <a href="exportExcel.php">-->
        <!--        <div>-->
        <!--            <i class="fas fa-file-excel" style="color: white;"></i>-->
        <!--            <p style="color: white; font-size: 12px">Ekspor</p>-->
        <!--        </div>-->
        <!--    </a>-->
        <!--</div>-->
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
            $result = $mysqli->query("SELECT * FROM tbl_reg WHERE sekolah_daftar='$school' ORDER BY no_pendaftaran") or die($mysqli->error);
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school'");
            $schoolData = $getSchool->fetch_array();
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
                            <th>Nama Ibu</th>
                            <th>No HP Ayah</th>
                            <th>Status Daftar</th>
                            <th>Aksi</th>
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
                                $nama_ibu = '';
                                $no_hp_ayah = '';
                                $ortu_data = $mysqli->query("SELECT * FROM tbl_ortu WHERE id_ortu=$id_ortu") or die($mysqli->error);

                                if ($ortu_data->num_rows){
                                    $rows = $ortu_data->fetch_array();
                                    $nama_ayah = $rows['nama_ayah'];
                                    $nama_ibu = $rows['nama_ibu'];
                                    $no_hp_ayah = $rows['no_hp_ayah'];
                                }
                            ?>
                            <td><?php echo $nama_ayah; ?></td>
                            <td><?php echo $nama_ibu; ?></td>
                            <td><?php echo $no_hp_ayah; ?></td>
                            <td><?php echo ucwords(str_replace('_',' ', $row['status_pendaf'])); ?></td>
                            <td>
                                <?php if ($row['status_pendaf'] == "menunggu_konfirmasi" || $row['status_pendaf'] == "menunggu_pembayaran" || $row['status_pendaf'] == "bukti_bayar_ditolak"): ?>
                                    <a href="dashboard_admin_other.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                                <?php elseif ($row['status_pendaf'] == "pendaftaran_batal"): ?>
                                    <a href="dashboard_admin_other.php?deleteNoReturn=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                                <?php else: ?>
                                    <a href="dashboard_admin_other.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger disabled">Hapus</a>
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
