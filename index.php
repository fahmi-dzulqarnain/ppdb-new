<!DOCTYPE html>
<!-- Created By Fahmi Dzulqarnain -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Yayasan Al Kahfi Batam</title>
    <link rel="stylesheet" href="style.css?v=2">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="header-bar">
        <a href="#" class="header-text">
            <h1>PPDB</h1>
            <h3>Yayasan Islam Al Kahfi Batam</h3>
        </a>
        <img src="images/logo_alkahfi-300x300.png" alt="al-kahfi-batam.png" class="logo">
    </div>

    <!-- home section start -->

    <section class="cover" id="home">
        <div class="cover-content">
            <div class="text-2"><span class="typing-1"></span></div>
            <div class="flex-column" style="margin-top: 12vh;">
                <a href="#daftar">Daftar</a>
                <a href="login/">Login</a>
            </div>
        </div>
    </section>

    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));
    $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas FROM tbl_school") or die($mysqli->error);
    $showModal = false;
    ?>

    <section class="chooseUnit" id="daftar">
        <div class="max-width">
            <h2 class="title">Silakan Pilih Jenjang</h2>

            <div class="owl-carousel daftar-carousel">
                <?php

                $arrayResult = $getSchool->fetch_all();
                $arrayUnit = array();
                $i = 0;

                for ($i = 0; $i < count($arrayResult); $i++) :
                    $item = $arrayResult[$i];
                    $schoolName = str_replace(['-1', '-2', '-3'], '', $item[0]);
                    if (isset($arrayUnit[$schoolName]) == false) {
                        $arrayUnit[$schoolName] = array();
                        $arrayUnit[$schoolName]['logo_unit'] = $item[2];
                    }

                    $type = str_replace(' ', '_', $item[1]);
                    if (isset($arrayUnit[$schoolName][$item[3]][$type]) == false) {
                        $arrayUnit[$schoolName][$item[3]][$type]['query_name'] = $item[0];
                        $arrayUnit[$schoolName][$item[3]][$type]['sisa_kuota'] = $item[4];
                        $arrayUnit[$schoolName][$item[3]][$type]['kuota'] = $item[5];
                        $arrayUnit[$schoolName][$item[3]][$type]['kapasitas'] = $item[6];
                    }
                endfor;

                while ($school = current($arrayUnit)) :
                    $schoolName = str_replace('-', ' ', key($arrayUnit));

                    $logoUnit = $school['logo_unit'];
                ?>
                    <div class="daftar-item">
                        <img src="logo/<?php echo $logoUnit; ?>" style="width: 100px;" alt="<?php echo $schoolName; ?>" class="icon">
                        <h3><?php echo str_replace(['-1', '-2', '-3'], '', $schoolName); ?></h3>
                        <?php

                        unset($school['logo_unit']);
                        foreach ($school as $alamat => $value) {
                            $js_array = str_replace('"', '@', json_encode($value));
                        ?>
                            <button class="button modal__button" onclick="openModal('<?php echo $schoolName; ?>', '<?php echo $logoUnit; ?>', '<?php echo $alamat; ?>', '<?php print_r($js_array); ?>')">
                                <?php echo $alamat; ?>
                            </button>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                    next($arrayUnit);
                endwhile;
                ?>
            </div>
        </div>
    </section>

    <div class="modal__container <?php if ($showModal) echo 'show-modal'; ?>" id="modal-container">
        <div class="modal__content" title="Close">
            <i class="bx bx-x modal__close close-modal"></i>

            <img src="logo/FI TK.png" alt="TKIT" class="modal__img icon" id="modal-img">

            <h3 class="modal__title" id="modal-title">TKIT Fajar Ilahi</h3>
            <p class="modal__description" id="modal-description">Click the button to close</p>
            <div class="flex-row modal__description">
                <div class="flex-column col-2" id="first">
                    <h3 class="with-background" id="modal-type-1"></h3>
                    <div class="flex-column">
                        <p><i class='bx bxs-school' style="align-self: center; margin: 0.2rem;"></i> Kapasitas</p>
                        <h4 id="modal-capacity">Click the button to close</h4>
                    </div>
                    <div class="flex-column">
                        <p><i class='bx bxs-user-pin' style="align-self: center; margin: 0.2rem;"></i> Sisa Formulir</p>
                        <h4 id="modal-kuota">Click the button to close</h4>
                    </div>
                    <button class="modal__button modal__button-width" id="modal-btn-1">
                        Daftar
                    </button>
                </div>
                <div class="flex-column col-2" id="second">
                    <h3 class="with-background" id="modal-type-2"></h3>
                    <div class="flex-column">
                        <p><i class='bx bxs-school' style="align-self: center; margin: 0.2rem;"></i> Kapasitas</p>
                        <h4 id="modal-capacity-2">Click the button to close</h4>
                    </div>
                    <div class="flex-column">
                        <p><i class='bx bxs-user-pin' style="align-self: center; margin: 0.2rem;"></i> Sisa Formulir</p>
                        <h4 id="modal-kuota-2">Click the button to close</h4>
                    </div>
                    <button class="modal__button modal__button-width" id="modal-btn-2">
                        Daftar
                    </button>
                </div>
            </div>

            <button class="modal__button-link close-modal">
                Close
            </button>
        </div>
    </div>

    <!-- Informasi pendaftaran -->
    <section class="services" id="informasi">
        <div class="max-width">
            <h2 class="title"><i class='bx bx-info-circle'></i> Informasi</h2>
            <div class="serv-content">
                <div class="card">
                    <div class="box">
                        <div class="text"><i class='bx bx-money'></i> Biaya Pendaftaran </div>
                        <br>
                        <p>Biaya Pendaftaran Semua Jenjang dan Unit Yayasan Islam Al Kahfi Adalah Rp220.000,-<br>Biaya Masuk Klik <a href="#uangmasuk" style="color: #DCE775; font-weight:600;">Disini</a> </p><br>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <div class="text"><i class='bx bxs-file'></i> Berkas saat Tes</div>
                        <br>
                        <ul>
                            <li>Alat tulis</li>
                            <li>Fotocopy KK 2 lembar</li>
                            <li>Fotocopy Akta Lahir 2 lembar</li>
                            <li>Mengisi & menyerahkan surat pernyataan wali</li>
                            <li>Quran untuk membaca dan menghafal (SMP/SMA)</li>
                            <li>Fotocopy kartu NISN (SMP/SMA)</li>
                            <li>Fotocopy rapor Sem ganjil kelas 6 (SMP) / kelas 9 (SMA) </li>
                            <li>Alat tulis</li>
                        </ul><br>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- jadwal -->
    <section class="timeline" id="jadwal">
        <div class="max-width">
            <h1 class="title">Timeline PPDB</h1>
            <div class="container left">
                <div class="content">
                    <h4>Pembukaan Pendaftaran PPDB 2022/2023</h4>
                    <p><i class='bx bxs-calendar'></i> 13 Des - 9 Jan</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>2016</h4>
                    <p><i class='bx bxs-calendar'></i></p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>2015</h4>
                    <p><i class='bx bxs-calendar'></i></p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>2014</h4>
                    <p><i class='bx bxs-calendar'></i></p>
                </div>
            </div>
        </div>
    </section>

    <!-- uang masuk -->
    <section class="jadwal2" id="uangmasuk">
        <div class="max-width">

            <h1 class="title">Biaya Daftar Ulang</h1>
            <div>
                <table class="jadwal">
                    <tr>
                        <th>UNIT</th>
                        <th>BIAYA</th>
                        <th>SPP</th>
                    </tr>
                    <tr>
                        <td>TKIT Fajar Ilahi</td>
                        <td>3.490.000,-</td>
                        <td>350.000,-</td>
                    </tr>
                    <tr>
                        <td>SDIT Fajar Ilahi</td>
                        <td>5.120.000,-</td>
                        <td>375.000,-</td>
                    </tr>
                    <tr>
                        <td>SMPIT Fajar Ilahi Batu Aji</td>
                        <td>6.675.000,-</td>
                        <td>450.000,-</td>
                    </tr>
                    <tr>
                        <td>SMPIT Fajar Ilahi Sei Beduk</td>
                        <td>6.900.000,-</td>
                        <td>400.000,-</td>
                    </tr>
                    <tr>
                        <td>SMAIT Fajar Ilahi Sei Beduk</td>
                        <td>8.050.000,-</td>
                        <td>450.000,-</td>
                    </tr>
                    <tr>
                        <td>Ma'had Khodijah (Mukim)</td>
                        <td>2.250.000,-</td>
                        <td>300.000,-</td>
                    </tr>
                    <tr>
                        <td>Ma'had Khodijah (Non Mukim)</td>
                        <td>2.050.000,-</td>
                        <td>300.000,-</td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin-top: 35px;">* Termasuk SPP Juli, Buku, Kegiatan, Uang Pangkal, Seragam, dan Gedung</p>
        </div>
    </section>

    <!-- about section start -->
    <section class="about" id="about">
        <div class="max-width">
            <h2 class="title">Tentang Yayasan</h2>
            <div class="about-content">
                <div class="column left">
                    <img src="images/logo_alkahfi-300x300.png" alt="Yayasan Islam Al Kahfi">
                </div>
                <div class="column right">
                    <div class="text">Al Kahfi Batam, Berkhidmat Untuk <span class="typing-2"></span></div>
                    <p>Yayasan Islam Al Kahfi Batam didirikan sebagai sarana untuk mengelola dan mengembangkan da’wah Islam berdasarkan Al Qur’an dan Assunnah dengan pemahaman Salaful Ummah di Kota Batam dan propinsi Kepulauan Riau.</p>
                    <a href="https://alkahfi.or.id/">Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <script src="script.js"></script>
</body>

</html>