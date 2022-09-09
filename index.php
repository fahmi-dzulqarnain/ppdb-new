<!DOCTYPE html>
<!-- Created By Fahmi Dzulqarnain -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Yayasan Al Kahfi Batam</title>
    <link rel="stylesheet" href="style.css?v=2">
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
    include_once 'includes/config.php';
    $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas, kontak FROM tbl_school") or die($mysqli->error);
    $showModal = false;
    ?>

    <section class="chooseUnit" id="daftar">
        <div class="max-width">
            <h2 class="title">Silakan Pilih <br>Jenjang dan Alamat</h2>

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
                        $arrayUnit[$schoolName][$item[3]][$type]['kontak'] = $item[7];
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
            <p class="modal__description" id="modal-contact">Click the button to close</p>
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
                Tutup
            </button>
        </div>
    </div>

    <div class="modal__container show-modal" id="modal-announcement-container">
        <div class="modal__content" title="Close">
            <i class="bx bx-x modal__close close-modal-btn"></i>

            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_i0zh5psb.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin: 12px auto;"  loop autoplay></lottie-player>

            <h4>Pendaftaran TA 2022/2023 Telah ditutup</h4>

            <button class="modal__button-link close-modal-btn">
                Tutup
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
                        <p>Biaya Pendaftaran Adalah Rp220.000,- Kecuali untuk SDIT FI (1, 2, 3), dan SMPIT FI 1<br>Biaya Masuk Klik <a href="#uangmasuk" style="color: #DCE775; font-weight:600;">Disini</a> </p><br>
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
                    <h4>Pendaftaran PPDB 2022/2023</h4>
                    <p><i class='bx bxs-calendar'></i> 18 Des - 22 Jan</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Tes TKIT</h4>
                    <p><i class='bx bxs-calendar'></i> 8 Jan 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Tes SDIT</h4>
                    <p><i class='bx bxs-calendar'></i> 15 Jan 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Tes SMPIT</h4>
                    <p><i class='bx bxs-calendar'></i> 22 Jan 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Tes SMAIT & Khadijah</h4>
                    <p><i class='bx bxs-calendar'></i> 29 Jan 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Pengumuman, Daftar Ulang dan Ukur Seragam (TKIT)</h4>
                    <p><i class='bx bxs-calendar'></i> 22 Jan 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Pengumuman, Daftar Ulang dan Ukur Seragam (SDIT)</h4>
                    <p><i class='bx bxs-calendar'></i> 29 Jan 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Pengumuman, Daftar Ulang dan Ukur Seragam (SMPIT)</h4>
                    <p><i class='bx bxs-calendar'></i> 05 Feb 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Pengumuman, Daftar Ulang dan Ukur Seragam (SMAIT/Khadijah)</h4>
                    <p><i class='bx bxs-calendar'></i> 12 Feb 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Cicilan 2 TKIT & Cicilan 3 TKIT</h4>
                    <p><i class='bx bxs-calendar'></i> 19 Feb 2022 & 19 Mar 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Cicilan 2 SDIT & Cicilan 3 SDIT</h4>
                    <p><i class='bx bxs-calendar'></i> 26 Feb 2022 & 26 Mar 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Cicilan 2 SMPIT & Cicilan 3 SMPIT</h4>
                    <p><i class='bx bxs-calendar'></i> 05 Mar 2022 & 02 Apr 2022</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h4>Cicilan 2 SMAIT/Khadijah & Cicilan 3</h4>
                    <p><i class='bx bxs-calendar'></i> 12 Mar 2022 & 9 Apr 2022</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h4>Pembagian Buku & Seragam</h4>
                    <p><i class='bx bxs-calendar'></i> 02 Jul 2022</p>
                </div>
            </div>
        </div>
    </section>

    <!-- uang masuk -->
    <section class="jadwal2" id="uangmasuk">
        <div class="max-width">

            <h1 class="title">Biaya Masuk</h1>
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
                        <td>6.650.000,-</td>
                        <td>450.000,-</td>
                    </tr>
                    <tr>
                        <td>SMPIT Fajar Ilahi Sei Beduk</td>
                        <td>6.900.000,-</td>
                        <td>400.000,-</td>
                    </tr>
                    <tr>
                        <td>SMAIT Fajar Ilahi Sei Beduk</td>
                        <td>8.100.000,-</td>
                        <td>450.000,-</td>
                    </tr>
                    <tr>
                        <td>Ma'had Khodijah (I'dad)</td>
                        <td>2.700.000,-</td>
                        <td>300.000,-</td>
                    </tr>
                    <tr>
                        <td>Ma'had Khodijah (Tarbiyah)</td>
                        <td>1.500.000,-</td>
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

    <script src="script.js?v=2"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</body>

</html>