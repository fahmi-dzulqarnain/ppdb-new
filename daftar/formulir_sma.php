<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="form.css" />
    <link rel="stylesheet" href="../ppdb/css/codebeautify.css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>PPDB Yayasan Islam Al Kahfi</title>
</head>

<body>
    <?php
    require_once 'register.php';
    $unit = $_GET['unit2'];
    $type = str_replace("_", " ", $_GET['type']);
    $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'");
    $schoolData = $getSchool->fetch_array();
    $kuota = $schoolData['sisa_kuota'];
    ?>
    <div class="container">
        <div class="header-bar">
            <h3 class="header-text">Daftar SMAIT</h3>
        </div>

        <div class="forms-container">
            <form action="register.php" method="POST">

                <div class="flex-row">
                    <div class="col-2">
                        <h4 class="quicksand">Data Orang Tua</h4>
                        <div class="kurung" style="margin-top: 5px;">
                            <div><input name="nama-ayah" type="text" placeholder="Nama Ayah" class="input-text"> </div>
                            <div><input name="hp-ayah" type="tel" placeholder="No. HP Ayah (Wajib WA)" class="input-text"> </div>
                            <div><input name="nama-ibu" type="text" placeholder="Nama Ibu" class="input-text"> </div>
                            <div><input name="hp-ibu" type="tel" placeholder="No. HP Ibu" class="input-text"> </div>
                            <div><input name="alamat" type="text" placeholder="Alamat" class="input-text"> </div>
                            <div><input name="kelurahan" type="text" placeholder="Kelurahan" class="input-text"> </div>
                            <div><input name="kecamatan" type="text" placeholder="Kecamatan" class="input-text"> </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <h4 class="quicksand">Data Calon Siswa</h4>
                        <div><input name="unit-lokasi" type="hidden" value="<?php echo $_GET['unit2']; ?>"> </div>
                        <div><input name="type" type="hidden" value="<?php echo $_GET['type']; ?>"> </div>
                        <div class="kurung" style="margin-top: 5px;">
                            <div><input name="nama-siswa" type="text" placeholder="Nama Calon Siswa" class="input-text"> </div>
                            <div><input name="tempat-lahir" type="text" placeholder="Tempat Lahir" class="input-text"> </div>
                            <div><input name="tgl-lahir" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Tanggal Lahir" class="input-text"> </div>
                            <div><input name="asal-sekolah" type="text" placeholder="Asal Sekolah" class="input-text"> </div>
                        </div>

                        <h4 class="quicksand" style="margin-top: 1.5em;">Rerata Nilai Rapor</h4>
                        <div class="flex-row-wrap-fixed">
                            <!--<input name="rataRapor1" type="tel" placeholder="Kelas 4 Sem 1 *" class="input-text" style="width: 48%;" maxlength="5">-->
                            <!--<input name="rataRapor2" type="tel" placeholder="Kelas 4 Sem 2 *" class="input-text" style="width: 48%; margin-left: 4%" maxlength="5">-->
                            <!--<input name="rataRapor3" type="tel" placeholder="Kelas 5 Sem 1 *" class="input-text" style="width: 48%;" maxlength="5">-->
                            <!--<input name="rataRapor4" type="tel" placeholder="Kelas 5 Sem 2 *" class="input-text" style="width: 48%; margin-left: 4%" maxlength="5">-->
                            <input name="rataRapor5" type="tel" placeholder="Kelas 6 Sem 1 *" class="input-text" style="width: 48%;" maxlength="5">
                            <input name="prestasi" type="tel" placeholder="Prestasi" class="input-text" style="width: 48%; margin-left: 4%">
                        </div>

                        <div class="box-info" style="flex-direction: row; display: flex;">
                            <i class='bx bx-info-circle'></i>
                            <div class="flex-column" style="margin-left: 12px;">
                                <h5>Informasi</h5>
                                <p style="font-size: .8em;">
                                    Setelah mengisi Formulir, Anda akan diarahkan ke halaman login. Login menggunakan Nama Ananda dengan Password Tanggal Lahir dan Segera lakukan Pembayaran agar formulir tidak hangus.
                                </p>
                            </div>
                        </div>

                        <button name="send" type="submit" class="button" style="margin-top: 25px;">Daftar</button>
                    </div>

                </div>
            </form>
        </div>

        <?php if ($kuota < 1) :
            echo '<script type="text/javascript">';
            echo 'alert("Mohon Maaf, kuota formulir saat ini telah terpenuhi, silakan periksa kembali hari berikutnya (apabila ada yang membatalkan formulir).");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
        endif; ?>

        <div id="id01" class="w3-modal" style="z-index:99; min-height: 600px;">
            <div class="w3-modal-content w3-animate-zoom">
                <header class="w3-container w3-teal">
                    <h4 style="font-family: 'Poppins', sans-serif;">Kuota Formulir Sudah Habis!</h4>
                </header>
                <div class="w3-container">
                    <p style="margin: 20px;">Mohon Maaf, kuota formulir saat ini telah terpenuhi, silakan periksa kembali hari berikutnya (apabila ada yang membatalkan formulir).</p>
                </div>
                <div class="kurung">
                    <div><a href="../login/" class="modal-content">Kembali Ke Halaman Utama</a> </div>
                </div>
            </div>
        </div>
</body>

</html>