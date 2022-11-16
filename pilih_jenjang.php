<!DOCTYPE html>
<!-- Created By Fahmi Dzulqarnain and Ahmad Fauzi -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Yayasan Al Kahfi Batam</title>
    <link rel="shortcut icon" href="assets/img/Yayasan Islam Al Kahfi Batam@2x.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    
    <link rel="stylesheet" href="main_css/style.css">
    <link rel="stylesheet" href="main_css/root.css">
    <link rel="stylesheet" href="main_css/pilih_jenjang.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="main_css/material_design.css">
</head>

<body>
    <main class="main">
        <!---------Tentang----------->
        <section class="tentang section container" id="tentang">
            <div class="tentang_opening">
                <img src="assets/img/Yayasan Islam Al Kahfi Batam@2x.png" alt="" class="tentang_img">
                <h1 class="section_title tentang_title">
                    PPDB
                </h1>

                <p class="tentang_description">
                    Silakan pilih jenjang pendidikan untuk mendaftar.
                </p>
            </div>
        </section>

        <?php
            $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));
            $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas, kontak FROM tbl_school") or die($mysqli->error);
            $showModal = false;
        ?>

        <!----------Steps----------->
        <section class="steps section container">
            <div class="steps_bg">
                <div class="steps_container grid">
                    <a href="#" class="hidden_underline" onclick="openDialog()">
                        <div class="steps_card">
                            <div class="tkit_fi_logo steps_card-number"></div>
                            <h3 class="steps_card-title">TKIT Fajar Ilahi</h3>
                        </div>
                    </a>
                    <a href="#" class="hidden_underline" onclick="openDialog()">
                        <div class="steps_card">
                            <div class="sdit_fi_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SDIT Fajar Ilahi</h3>
                        </div>
                    </a>
                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="smpit_fi_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SMPIT Fajar Ilahi</h3>
                        </div>
                    </a>
                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="smait_fi_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SMAIT Fajar Ilahi</h3>
                        </div>
                    </a>
                </div>

                <div class="steps_container grid">
                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="smp_imam_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SMP Imam Syafii</h3>
                        </div>
                    </a>

                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="sma_imam_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SMA Imam Syafii</h3>
                        </div>
                    </a>

                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="swtq_imam_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SWTQ Imam Syafii</h3>
                        </div>
                    </a>

                    <a href="#" class="hidden_underline">
                        <div class="steps_card">
                            <div class="sutq_imam_logo steps_card-number"></div>
                            <h3 class="steps_card-title">SUTQ Imam Syafii</h3>
                        </div>
                    </a>
                </div>
                
            </div>
        </section>

        <div class="modal__container <?php if ($showModal) echo 'show-modal'; ?>" id="modal-container">
            <div class="modal__content" title="Close">
                <i class="bx bx-x modal__close close-modal"></i>

                <img src="logo/FI TK.png" alt="TKIT" class="modal__img icon" id="modal-img">

                <h3 class="modal__title" id="modal-title">TKIT Fajar Ilahi</h3>
                <p>Silakan Pilih Lokasi</p>
                <div class="flex-row modal__description">
                    <div class="flex-column col-2" id="first">
                        <button class="button btn-batu-aji" id="modal-btn-1" >
                        </button>
                    </div>
                    <div class="flex-column col-2" id="second">
                        <button class="button btn-bengkong" id="modal-btn-2" >
                        </button>
                    </div>
                    <div class="flex-column col-2" id="third">
                        <button class="button btn-seibeduk" id="modal-btn-3" >
                        </button>
                    </div>
                </div>

                <button class="modal__button-link close-modal" onclick="closeDialog()">
                    Close
                </button>
            </div>
        </div>
        
    </main>

    <footer class="footer section">
        <p class="footer_copy">Yayasan Islam Al Kahfi Batam &#169; 2022</p>
    </footer>

    <!-- Required Material Web JavaScript library -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script src="main_js/open_close_dialog.js"></script>
    <script src="main_js/script.js"></script>
</body>

</html>


