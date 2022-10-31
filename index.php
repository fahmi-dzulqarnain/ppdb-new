<!DOCTYPE html>
<!-- Created By Fahmi Dzulqarnain and Ahmad Fauzi -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Yayasan Al Kahfi Batam</title>
    <link rel="stylesheet" href="main_css/root.css">
    <link rel="stylesheet" href="main_css/style.css">    
    <link rel="shortcut icon" href="assets/img/Yayasan Islam Al Kahfi Batam@2x.png" type="image/x-icon">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="header-bar">
        <div class="header-bar-container">
            
            <div class="header-bar-properti">
                <img src="assets/img/PPIT SMP@2x.png" alt="al-kahfi-batam.png" class="side_logo">
                <div>
                    <h3 class="mobile-size-font-logo-h3">SMPIT Imam Syafii</h3>
                    <p class="mobile-size-font-logo-p">Jl. Hang Lekiu, Sambau, Nongsa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- home section start -->

    <section class="cover" id="home">
        <div class="cover-content">
            <div class="lottie-size"><lottie-player src="https://assets6.lottiefiles.com/packages/lf20_9cyyl8i4.json" background="transparent" speed="1"  loop autoplay></lottie-player></div>
            <div class="text-2">Penerimaan Peserta<br> Didik Baru</div>
            <div class="flex-column" style="margin-top: 5vh;">
                <div class="flex-column">
                    <a class="button" href="#daftar">Daftar</a>
                </div>
                <p style="margin-top: 5vh;">Sudah Mendaftar?</p>
                <div class="flex-column">
                    <a class="button" href="login/">Masuk Akun</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));
    $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas, kontak FROM tbl_school") or die($mysqli->error);
    $showModal = false;
    ?>


    <!--div class="modal__container <?php if ($showModal) echo 'show-modal'; ?>" id="modal-container">
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
                Close
            </button>
        </div>
    </div-->

    <!-- Informasi pendaftaran -->
    <section class="services" id="informasi">
        <div class="max-width">
            <h2 class="title"><i class='info_logo'></i><br> Informasi</h2>
            <div class="serv-content">
                <div class="card">
                    <div class="box">
                        <div class="text"><i class='bx bx-money'></i> Biaya Pendaftaran </div>
                        <br>
                        <p>Rp220.000,-</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <div class="text"><i class='bx bxs-file'></i> Berkas saat Tes</div>
                        <br>
                        <ul>
                            <li>Alat tulis</li>
                            <li>Fotocopy akta kelahiran</li>
                            <li>Fotocopy kartu keluarga</li>
                            <li>Mengisi dan menyerahkan surat pernyataan</li>
                            <li>Surat hasil kesehatan (laboratorium)</li>
                            <li>Dan lain-lain</li>
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
            <h1 class="title">Line Masa</h1>
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
                    <div class="flex-column col-2">
                        <a class="button" href="https://alkahfi.or.id/">Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <script src="main_js/script.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>