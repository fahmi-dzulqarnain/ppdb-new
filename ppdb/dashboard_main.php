<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../daftar/form.css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <?php
        session_start();
        include_once '../includes/config.php';
        if (isset($_GET['logout'])) {
            session_destroy();
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../login/";';
            echo '</script>';
        }

        if (isset($_SESSION['school'])) {

            $id = $_SESSION['id'];
            $nSiswa = htmlspecialchars($_SESSION['username']);
            $school = $_SESSION['school'];
            $tglLhr = $_SESSION['tanggal_lahir'];
            $result = $mysqli->query("SELECT * FROM tbl_reg WHERE sekolah_daftar='$school' AND nama_calon_siswa='$nSiswa' AND tanggal_lahir = '$tglLhr'") or die($mysqli->error);
            $row = $result->fetch_array();
            $id_ortu = $row['id_ortu'];
            $no_pendf = $row['no_pendaftaran'];
            $imgReceipt = $row['bukti_transaksi'];
            $ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE id_ortu='$id_ortu'") or die($mysqli->error);
            $row_ot = $ortu->fetch_array();

            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school'");
            $school_data = $getSchool->fetch_array();

            $status = $row['status_pendaf'];
            $tipe = $row['type'];
            $message = "Ada masalah dengan status!";
            $noRek = $school_data['no_rekening'];
            $namaRek = $school_data['nama_rekening'];
            $kontak = $school_data['kontak'];
            $schoolName = str_replace("-", " ", $school_data['school_name']);
            $noPendDisp = "<br><br>No. Pendaftaran: " . sprintf("%'.03d\n", $no_pendf);

            if ($status == "menunggu_pembayaran") :
                $nominalBayar = $row['nominal_trf'];
                $message = "Ayah Bunda memiliki waktu 24 Jam untuk melakukan pembayaran. Silakan Transfer ke <br>Bank BSI Kode. Bank (451) No. Rek. <b>$noRek</b><br> a.n. $namaRek <br><br>Nominal Pembayaran adalah <b>$nominalBayar</b> <br>(Wajib Transfer Sesuai Nominal)<br><br>Unggah Bukti Pembayaran di Bawah Ini!";
            elseif ($status == "menunggu_konfirmasi") :
                $message = "Panitia akan meninjau bukti pembayaran dari Ayah Bunda. Apabila bukti tidak sesuai, akan diminta mengunggah bukti yang baru. <b>$noPendDisp</b>";
            elseif ($status == "bukti_bayar_ditolak") :
                $nominalBayar = $row['nominal_trf'];
                $message = "Bukti pembayaran tidak jelas atau tidak sesuai. Mohon mengunggah file yang benar. <br>Bank BSI Kode. Bank (451) <b>($noRek)</b><br> a.n. $namaRek <br><br>Nominal Pembayaran : <b>$nominalBayar</b><br><br>Unggah Bukti Pembayaran di Bawah Ini!";
            elseif ($status == "pendaftaran_batal") :
                $message = "Ayah Bunda tidak mengunggah pembayaran dalam waktu 24 jam. Pendaftaran dibatalkan. Silakan mengantri kuota formulir baru.";
            elseif ($status == "dibayar") :
                $message = "Alhamdulillah! Pembayaran telah diterima, silakan untuk datang pada test yang akan dilaksanakan sesuai jadwal. <b>$noPendDisp</b>";
            elseif ($status == "lulus") :
                $message = "Alhamdulillah! Ananda telah lulus test dan dinyatakan diterima sebagai siswa di $schoolName, jangan lupa untuk melakukan pendaftaran ulang sesuai jadwal. Hubungi Panitia Apabila Ada Pertanyaan di $kontak. <b>$noPendDisp</b>";
            elseif ($status == "lulus_bersyarat") :
                $message = "Alhamdulillah! Ananda dinyatakan lulus bersyarat, artinya ada syarat yang harus dilakukan agar dapat diterima sepenuhnya di $schoolName. Informasi lebih lanjut silakan Hubungi Panitia di $kontak. <b>$noPendDisp</b>";
            elseif ($status == "cadangan") :
                $message = "Ananda dinyatakan sebagai cadangan, artinya Ananda memiliki nilai cukup dalam test dan apabila ada yang membatalkan pendaftaran, ananda akan dihubungi oleh pihak $schoolName. Informasi lebih lanjut silakan Hubungi Panitia di $kontak. <b>$noPendDisp</b>";
            elseif ($status == "belum_diterima") :
                $message = "Mohon maaf untuk saat ini Ananda belum diterima di $schoolName karena belum lulus test. Terima Kasih telah mendaftar, Semoga Allah mengganti dengan yang lebih baik.";
            endif;
        } else {
            session_destroy();
            echo '<script type="text/javascript">';
            echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
        }

        ?>
        <div class="header-bar">
            <h3 class="header-text">Assalamualaikum Ayah Bunda!</h3>
            <p class="header-description">Halaman ini berfungsi untuk memonitor status penerimaan Ananda di <?php echo $schoolName; ?> Batam</p>
        </div>
        <div class="forms-container">

            <div class="forms-container">
                <div class="flex-row" style="margin-bottom: 2em;">
                    <div class="col-2">

                        <div class="box-status" style="flex-direction: row; display: flex;">
                            <i class='bx bx-info-circle'></i>
                            <div class="flex-column" style="margin-left: 12px;">
                                <h5>Status: "<?php echo ucwords(str_replace('_', ' ', $status)) ?>"</h5>
                                <p style="font-size: .8em;"><?php echo '<br>' . $message; ?></p>
                            </div>
                        </div>

                        <div class="content">
                            <?php if ($status == "menunggu_pembayaran" || $status == "bukti_bayar_ditolak") : ?>
                                <form action="account_process_.php?id=<?php echo $id; ?>&username=<?php echo $nSiswa; ?>&no_pendaftaran=<?php echo $no_pendf; ?>" method="POST" enctype="multipart/form-data">
                                    <div class="img-container" style="margin-top: 1.5em">
                                        <div class="img-wrapper">
                                            <div class="image">
                                                <img id="gambar" src="

                                                <?php if ($imgReceipt != '') :
                                                    echo 'receipt/' . $imgReceipt; ?>
                                                <?php else : ?>
                                                    data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7
                                                <?php endif; ?>

                                                ">
                                            </div>
                                            <div class="content">
                                                <div class="icon"> <i class='bx bx-cloud-upload'></i> </div>
                                                <div class="text"> Belum Ada Gambar Dipilih! </div>
                                            </div>
                                            <div id="cancel-btn"> <i class='bx bx-x'></i> </div>
                                            <div class="file-name"> Nama Gambar Disini </div>
                                        </div>
                                        <label for="receiptFile" class="button" id="custom-btn">
                                            Pilih Bukti Transaksi
                                        </label>
                                    </div>
                                    <input id="receiptFile" type="file" onchange="preview()" name="receiptFile" class="hide-file-input">
                                    <button name="send" type="submit" class="button">
                                        Unggah
                                    </button>
                                </form>
                            <?php else : ?>
                                <div class="flex-row-fixed" style="margin-bottom: -1em;">
                                    <a href="../index.php#jadwal" style="margin-right: .3em;" class="button">Info dan Jadwal</a>
                                    <a href="?logout=true" style="margin-left: .3em;" class="button"><i class="fas fa-sign-out-alt"></i> Keluar Akun</a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h3 class="quicksand">Data Ananda</h3>
                        <div class="kurung" style="margin-top: 5px;">
                            <div><input name="nama-siswa" value="<?php echo strtolower($row['nama_calon_siswa']); ?>" type="text" placeholder="Nama Calon Siswa" class="input-text" disabled> </div>
                            <div><input name="tempat-lahir" value="<?php echo strtolower($row['tempat_lahir']); ?>" type="text" placeholder="Tempat Lahir" class="input-text" disabled> </div>
                        </div>
                        <div class="kurung">
                            <div><input name="tgl-lahir" value="<?php echo $row['tanggal_lahir']; ?>" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Tanggal Lahir" class="input-text" disabled> </div>
                        </div>

                    </div>
                    <div class="col-2" style="margin-bottom: 3em;">
                        <h3 class="quicksand">Data Wali</h3>
                        <div style="margin-top: 5px;">
                            <div><input name="nama-ayah" value="<?php echo strtolower($row_ot['nama_ayah']); ?>" type="text" placeholder="Nama Ayah" class="input-text" disabled> </div>
                            <div><input name="hp-ayah" value="<?php echo $row_ot['no_hp_ayah']; ?>" type="tel" placeholder="No. HP Ayah (Wajib WA)" class="input-text" disabled></div>
                            <div><input name="nama-ibu" value="<?php echo strtolower($row_ot['nama_ibu']); ?>" type="text" placeholder="Nama Ibu" class="input-text" disabled> </div>
                            <div><input name="hp-ibu" value="<?php echo $row_ot['no_hp_ibu']; ?>" type="tel" placeholder="No. HP Ibu" class="input-text" disabled> </div>
                            <div><input name="alamat" value="<?php echo strtolower($row_ot['alamat']); ?>" type="text" placeholder="Alamat" class="input-text" disabled> </div>
                            <div><input name="kelurahan" value="<?php echo strtolower($row_ot['kelurahan']); ?>" type="text" placeholder="Kelurahan" class="input-text" disabled> </div>
                            <div><input name="kecamatan" value="<?php echo strtolower($row_ot['kecamatan']); ?>" type="text" placeholder="Kecamatan" class="input-text" disabled> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../includes/img_upload.js"></script>
</body>

</html>