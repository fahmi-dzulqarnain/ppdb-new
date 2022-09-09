<?php

session_start();
include_once '../includes/config.php';
if (isset($_GET['unit'])) {
  $unit = $_GET['unit'];
  $type = $_GET['type'];
  if (strpos($unit, 'TKIT') !== false) {
    header("Location: formulir_tk.php?unit2=$unit&type=$type");
  } elseif (strpos($unit, 'SDIT') !== false) header("Location: formulir_sd.php?unit2=$unit&type=$type");
  elseif (strpos($unit, 'SMPIT') !== false) header("Location: formulir_smp.php?unit2=$unit&type=$type");
  elseif (strpos($unit, 'SMAIT') !== false) header("Location: formulir_sma.php?unit2=$unit&type=$type");
  elseif (strpos($unit, 'Pondok') !== false) header("Location: formulir_pondok.php?unit2=$unit&type=$type");
}

if (isset($_POST['send']) && isset($_POST['tgl-lahir'])) {
  if ($_POST['tgl-lahir'] != ''){
  $unit = $_POST['unit-lokasi'];
  $type = str_replace("_", " ", $_POST['type']);
  $nSiswa = str_replace("'", "\'", strtoupper($_POST['nama-siswa']));
  $tmptLhr = strtoupper($_POST['tempat-lahir']);
  $tglLhrRaw = $_POST['tgl-lahir'];
  $tglLhr = date_create_from_format("Y-m-d", $tglLhrRaw)->format("d/m/Y");
  $nAyah = str_replace("'", "\'", strtoupper($_POST['nama-ayah']));
  $nIbu = str_replace("'", "\'", strtoupper($_POST['nama-ibu']));
  $hpAyah = $_POST['hp-ayah'];
  $hpIbu = $_POST['hp-ibu'];
  $alamat = str_replace("'", "", strtoupper($_POST['alamat']));
  $kelurahan = strtoupper($_POST['kelurahan']);
  $kecamatan = strtoupper($_POST['kecamatan']);

  $checkIfExists = $mysqli->query("SELECT * FROM tbl_reg WHERE nama_calon_siswa = '$nSiswa' AND tanggal_lahir = '$tglLhr' AND sekolah_daftar = '$unit' AND type = '$type'") or die($mysqli->error);

  if ($checkIfExists->num_rows) {
      
    $isPermitted = false;
    while ($row = $checkIfExists->fetch_assoc()) {
      $id = $row['id'];
      $name = $row['nama_calon_siswa'];
      $school = $row['sekolah_daftar'];
      $noPend = $row['no_pendaftaran'];
      $status = $row['status_pendaf'];
      $type = $row['type'];
      
      $statusList = array("dibayar", "lulus", "lulus_bersyarat", "belum_diterima", "cadangan");

      if (in_array($status, $statusList) == false) {
        $mysqli->query("DELETE FROM tbl_reg WHERE id=$id") or die(mysqli_error($mysqli));
        $mysqli->query("DELETE FROM tbl_akun WHERE username='$name' AND school='$school' AND no_pendaftaran='$noPend'") or die(mysqli_error($mysqli));
        $isPermitted = true;
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Anda telah memiliki Akun dan Statusnya Sudah Dibayar, Silakan Login menggunakan akun Anda");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
      }
    }
    
    if ($status != "pendaftaran_batal" && $status != "dibayar") {
        $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$school' AND type = '$type'");

        $schoolData = $getSchool->fetch_array();
        $kuota = $schoolData['sisa_kuota'] + 1;
        $mysqli->query("UPDATE tbl_school SET sisa_kuota = '$kuota' WHERE school_name = '$school' AND type = '$type'") or die($mysqli->error);
    }

    if ($isPermitted = true) {
      if (strpos($unit, 'TKIT') !== false) {
        if (
          $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
          and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
        ) {
          $tglLhr = $_POST['tgl-lahir'];
          if ($tglLhr != '') {
            $birthday = new DateTime($tglLhr);
            $diff = $birthday->diff(date_create_from_format("Y-m-d", '2022-07-01'));
            $months = $diff->format('%m') + 12 * $diff->format('%y');

            if ($type == 'TK A' and $months >= 49) {
              $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
              $schoolData = $getSchool->fetch_array();
              $no_pendf = $schoolData['no_pend_terakhir'] + 1;
              $kuota = $schoolData['sisa_kuota'] - 1;
              $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
              $timestamp = time();

              $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                          VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
              $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
              $row = $id_ortu->fetch_array();
              $id = $row['id_ortu'];
              $pass = md5(str_replace("/", "", $tglLhr));
              $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar, type, id_ortu, nominal_trf, status_pendaf)
                                          VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit', '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
              $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

              $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

              header("location: ../login/");
            } elseif ($type == 'TK B' and $months >= 61) {
              $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
              $schoolData = $getSchool->fetch_array();
              $no_pendf = $schoolData['no_pend_terakhir'] + 1;
              $kuota = $schoolData['sisa_kuota'] - 1;
              $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
              $timestamp = time();

              $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                          VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
              $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
              $row = $id_ortu->fetch_array();
              $id = $row['id_ortu'];
              $pass = md5(str_replace("/", "", $tglLhr));
              $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar, type, id_ortu, nominal_trf, status_pendaf)
                                          VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit', '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
              $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

              $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

              header("location: ../login/");
            } else {
              echo '<script type="text/javascript">';
              echo 'alert("Ananda belum memenuhi batas minimal Umur untuk' . $type . '! Silakan coba tahun berikutnya.");';
              echo 'window.location.href = "../login/";';
              echo '</script>';
            }
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } elseif (strpos($unit, 'SDIT') !== false) {

        if (
          $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
          and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
        ) {
          $tglLhr = $_POST['tgl-lahir'];
          if ($tglLhr != '') {
            $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
            $birthday = new DateTime($tglLhr);
            $diff = $birthday->diff(date_create_from_format("Y-m-d", '2022-07-01'));
            $months = $diff->format('%m') + 12 * $diff->format('%y');

            if ($months >= 73) {
              $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
              $schoolData = $getSchool->fetch_array();
              $no_pendf = $schoolData['no_pend_terakhir'] + 1;
              $kuota = $schoolData['sisa_kuota'] - 1;
              $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
              $timestamp = time();

              $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                          VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
              $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
              $row = $id_ortu->fetch_array();
              $id = $row['id_ortu'];
              $pass = md5(str_replace("/", "", $tglLhr));
              $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                          type, id_ortu, nominal_trf, status_pendaf, asal_sekolah)
                                          VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                            '$type', '$id', '$nominalTrf', 'dibayar', '$asalSekolah')") or die($mysqli->error);

              $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);
              $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

              header("location: ../login/");
            } else {
              echo '<script type="text/javascript">';
              echo 'alert("Ananda belum memenuhi batas minimal Umur untuk masuk SD! Silakan coba tahun berikutnya.");';
              echo 'window.location.href = "../login/";';
              echo '</script>';
            }
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } elseif (strpos($unit, 'SMPIT') !== false || strpos($unit, 'SMAIT') !== false) {
        $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
        $rataRapor1 = 0;//$_POST['rataRapor1'];
        $rataRapor2 = 0;//$_POST['rataRapor2'];
        $rataRapor3 = 0;// $_POST['rataRapor3'];
        $rataRapor4 = 0;//$_POST['rataRapor4'];
        $rataRapor5 = $_POST['rataRapor5'];
        $prestasi = $_POST['prestasi'];

        if (
          $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != '' and $asalSekolah != ''
          and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
        ) {

          if ($tglLhr != '') {

            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
            $no_pendf = $schoolData['no_pend_terakhir'] + 1;
            $kuota = $schoolData['sisa_kuota'] - 1;
            $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
            $timestamp = time();

            if ($unit == 'SMPIT-Fajar-Ilahi-1') {
              $statusPendaftaran = 'dibayar';
            } else {
              $statusPendaftaran = 'menunggu_pembayaran';
            }

            $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                      VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                      rata_rapor_4_1, rata_rapor_4_2, rata_rapor_5_1, rata_rapor_5_2, rata_rapor_6_1, asal_sekolah,
                                      type, id_ortu, nominal_trf, status_pendaf)
                                      VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                        '$rataRapor1', '$rataRapor2', '$rataRapor3', '$rataRapor4', '$rataRapor5', '$asalSekolah',
                                        '$type', '$id', '$nominalTrf', '$statusPendaftaran')") or die($mysqli->error);
            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

            $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

            header("location: ../login/");
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } elseif (strpos($unit, 'Pondok') !== false) {
        $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
        $rataRapor1 = $_POST['rataRapor1'];
        $rataRapor1 = 0;//$_POST['rataRapor1'];
        $rataRapor2 = 0;//$_POST['rataRapor2'];
        $rataRapor3 = 0;// $_POST['rataRapor3'];
        $rataRapor4 = 0;//$_POST['rataRapor4'];
        $prestasi = $_POST['prestasi'];

        if (
          $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
          and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
        ) {

          if ($tglLhr != '') {

            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
            $no_pendf = $schoolData['no_pend_terakhir'] + 1;
            $kuota = $schoolData['sisa_kuota'] - 1;
            $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
            $timestamp = time();

            $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                      VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                      rata_rapor_4_1, rata_rapor_4_2, rata_rapor_5_1, rata_rapor_5_2, rata_rapor_6_1, asal_sekolah,
                                      type, id_ortu, nominal_trf, status_pendaf)
                                      VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                        '$rataRapor1', '$rataRapor2', '$rataRapor3', '$rataRapor4', '$rataRapor5', '$asalSekolah',
                                        '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

            $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

            header("location: ../login/");
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      }
    }
  } else {
    if (strpos($unit, 'TKIT') !== false) {
      if (
        $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
        and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
      ) {

        $tglLhr = $_POST['tgl-lahir'];

        if ($tglLhr != '') {
          $birthday = new DateTime($tglLhr);
          $diff = $birthday->diff(date_create_from_format("Y-m-d", '2022-07-01'));
          $tglLhr = date_create_from_format("Y-m-d", $tglLhr)->format("d/m/Y");
          $months = $diff->format('%m') + 12 * $diff->format('%y');

          if ($type == 'TK A' and $months >= 49) {
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
            $no_pendf = $schoolData['no_pend_terakhir'] + 1;
            $kuota = $schoolData['sisa_kuota'] - 1;
            $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
            $timestamp = time();

            $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                      VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar, type, id_ortu, nominal_trf, status_pendaf)
                                      VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit', '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

            $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

            header("location: ../login/");
          } elseif ($type == 'TK B' and $months >= 61) {
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
            $no_pendf = $schoolData['no_pend_terakhir'] + 1;
            $kuota = $schoolData['sisa_kuota'] - 1;
            $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
            $timestamp = time();

            $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                      VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar, type, id_ortu, nominal_trf, status_pendaf)
                                      VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit', '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

            $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

            header("location: ../login/");
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Ananda belum memenuhi batas minimal Umur untuk' . $type . '! Silakan coba tahun berikutnya.");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
      }
    } elseif (strpos($unit, 'SDIT') !== false) {

      if (
        $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
        and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
      ) {
        $tglLhr = $_POST['tgl-lahir'];

        if ($tglLhr != '') {
          $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
          $birthday = new DateTime($tglLhr);
          $tglLhr = date_create_from_format("Y-m-d", $tglLhr)->format("d/m/Y");
          $diff = $birthday->diff(date_create_from_format("Y-m-d", '2022-07-01'));
          $months = $diff->format('%m') + 12 * $diff->format('%y');

          if ($months >= 73) {
            $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
            $schoolData = $getSchool->fetch_array();
            $no_pendf = $schoolData['no_pend_terakhir'] + 1;
            $kuota = $schoolData['sisa_kuota'] - 1;
            $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
            $timestamp = time();

            $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                      VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
            $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
            $row = $id_ortu->fetch_array();
            $id = $row['id_ortu'];
            $pass = md5(str_replace("/", "", $tglLhr));
            $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                      type, id_ortu, nominal_trf, status_pendaf, asal_sekolah)
                                      VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                        '$type', '$id', '$nominalTrf', 'dibayar', '$asalSekolah')") or die($mysqli->error);

            $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);
            $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

            header("location: ../login/");
          } else {
            echo '<script type="text/javascript">';
            echo 'alert("Ananda belum memenuhi batas minimal Umur untuk masuk SD! Silakan coba tahun berikutnya.");';
            echo 'window.location.href = "../login/";';
            echo '</script>';
          }
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
      }
    } elseif (strpos($unit, 'SMPIT') !== false || strpos($unit, 'SMAIT') !== false) {
      $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
      $rataRapor1 = $_POST['rataRapor1'];
      $rataRapor1 = 0;//$_POST['rataRapor1'];
      $rataRapor2 = 0;//$_POST['rataRapor2'];
      $rataRapor3 = 0;// $_POST['rataRapor3'];
      $rataRapor4 = 0;//$_POST['rataRapor4'];
      $prestasi = $_POST['prestasi'];

      if (
        $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != '' and $asalSekolah != ''
        and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
      ) {
        $tglLhr = $_POST['tgl-lahir'];

        if ($tglLhr != '') {
          $tglLhr = date_create_from_format("Y-m-d", $tglLhr)->format("d/m/Y");

          $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
          $schoolData = $getSchool->fetch_array();
          $no_pendf = $schoolData['no_pend_terakhir'] + 1;
          $kuota = $schoolData['sisa_kuota'] - 1;
          $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
          $timestamp = time();

            if ($unit == 'SMPIT-Fajar-Ilahi-1') {
              $statusPendaftaran = 'dibayar';
            } else {
              $statusPendaftaran = 'menunggu_pembayaran';
            }

          $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                  VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
          $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
          $row = $id_ortu->fetch_array();
          $id = $row['id_ortu'];
          $pass = md5(str_replace("/", "", $tglLhr));
          $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                  rata_rapor_4_1, rata_rapor_4_2, rata_rapor_5_1, rata_rapor_5_2, rata_rapor_6_1, asal_sekolah,
                                  type, id_ortu, nominal_trf, status_pendaf)
                                  VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                    '$rataRapor1', '$rataRapor2', '$rataRapor3', '$rataRapor4', '$rataRapor5', '$asalSekolah',
                                    '$type', '$id', '$nominalTrf', '$statusPendaftaran')") or die($mysqli->error);
          $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

          $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

          header("location: ../login/");
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
      }
    } elseif (strpos($unit, 'Pondok') !== false) {
      $asalSekolah = str_replace("'", "\'", strtoupper($_POST['asal-sekolah']));
      $rataRapor1 = $_POST['rataRapor1'];
      $rataRapor1 = 0;//$_POST['rataRapor1'];
        $rataRapor2 = 0;//$_POST['rataRapor2'];
        $rataRapor3 = 0;// $_POST['rataRapor3'];
        $rataRapor4 = 0;//$_POST['rataRapor4'];
      $prestasi = $_POST['prestasi'];

      if (
        $nSiswa != '' and $tmptLhr != '' and $nAyah != '' and $nIbu != ''
        and $hpAyah != '' and $hpIbu != '' and $alamat != '' and $kelurahan != '' and $kecamatan != ''
      ) {
        $tglLhr = $_POST['tgl-lahir'];

        if ($tglLhr != '') {
          $tglLhr = date_create_from_format("Y-m-d", $tglLhr)->format("d/m/Y");

          $getSchool = $mysqli->query("SELECT * FROM tbl_school WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);
          $schoolData = $getSchool->fetch_array();
          $no_pendf = $schoolData['no_pend_terakhir'] + 1;
          $kuota = $schoolData['sisa_kuota'] - 1;
          $nominalTrf = number_format(strval(219000 + $no_pendf), 0, ",", ".");
          $timestamp = time();

          $mysqli->query("INSERT INTO tbl_ortu (nama_ayah, nama_ibu, no_hp_ayah, no_hp_ibu, alamat, kelurahan, kecamatan)
                                  VALUES ('$nAyah', '$nIbu', '$hpAyah', '$hpIbu', '$alamat', '$kelurahan', '$kecamatan')") or die($mysqli->error);
          $id_ortu = $mysqli->query("SELECT * FROM tbl_ortu WHERE nama_ayah='$nAyah' AND nama_ibu='$nIbu'") or die($mysqli->error);
          $row = $id_ortu->fetch_array();
          $id = $row['id_ortu'];
          $pass = md5(str_replace("/", "", $tglLhr));
          $mysqli->query("INSERT INTO tbl_reg (no_pendaftaran, waktu_daftar, nama_calon_siswa, tempat_lahir, tanggal_lahir, sekolah_daftar,
                                  rata_rapor_4_1, rata_rapor_4_2, rata_rapor_5_1, rata_rapor_5_2, rata_rapor_6_1, asal_sekolah,
                                  type, id_ortu, nominal_trf, status_pendaf)
                                  VALUES ('$no_pendf', '$timestamp', '$nSiswa', '$tmptLhr', '$tglLhr', '$unit',
                                    '$rataRapor1', '$rataRapor2', '$rataRapor3', '$rataRapor4', '$rataRapor5', '$asalSekolah',
                                    '$type', '$id', '$nominalTrf', 'menunggu_pembayaran')") or die($mysqli->error);
          $mysqli->query("INSERT INTO tbl_akun (username, sandi, tipe_akun, no_pendaftaran, school) VALUES ('$nSiswa', '$pass', 'calon_siswa', '$no_pendf', '$unit')") or die($mysqli->error);

          $mysqli->query("UPDATE tbl_school SET no_pend_terakhir = '$no_pendf', sisa_kuota = '$kuota' WHERE school_name = '$unit' AND type = '$type'") or die($mysqli->error);

          header("location: ../login/");
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
          echo 'window.location.href = "../login/";';
          echo '</script>';
        }
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Ada Kolom Yang Belum Diisi! Pastikan semua kolom telah terisi");';
        echo 'window.location.href = "../login/";';
        echo '</script>';
      }
    }
  }
} else {
  echo '<script type="text/javascript">';
  echo 'alert("Kolom Tanggal Lahir Belum Diisi! Pastikan semua kolom telah terisi");';
  echo 'window.location.href = "../index.php#daftar";';
  echo '</script>';
}
}
