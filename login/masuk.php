<!DOCTYPE html>
<!-- Created By Fahmi Dzulqarnain and Ahmad Fauzi -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Yayasan Al Kahfi Batam</title>    
    <link rel="shortcut icon" href="../assets/img/Yayasan Islam Al Kahfi Batam@2x.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <link rel="stylesheet" href="../main_css/root.css">
    <link rel="stylesheet" href="masuk.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../main_css/material_design.css">
</head>

<body>

    <!-- home section start -->

    <section class="cover" id="daftar">
        <div class="cover-content">
            <div class="header-bar-properti">
                <img src="../assets/img/PPIT SMP@2x.png" alt="al-kahfi-batam.png" class="side_logo">
                <div>
                    <h3 class="mobile-size-font-logo-h3">SMPIT Imam Syafii</h3>
                    <p class="mobile-size-font-logo-p">Jl. Hang Lekiu, Sambau, Nongsa</p>
                </div>
            </div>
            <div class="text-2">Masuk Akun</div>
            
            <div style="margin-top: 5vh;">
                    <div id="conten-right" class="flex-column">
                        
                        <label class="mdc-text-field mdc-text-field--filled mdc-text-field--with-leading-icon text-field-margin">
                            <span class="mdc-text-field__ripple"></span>
                            <span class="mdc-floating-label" id="my-label-id">No HP Ayahanda / Ibunda</span>
                            <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading" tabindex="0" role="button">phone</i>
                            <input class="mdc-text-field__input" type="text" aria-labelledby="my-label-id">
                            <span class="mdc-line-ripple"></span>
                        </label>
                        <label class="mdc-text-field mdc-text-field--filled mdc-text-field--with-leading-icon text-field-margin">
                            <span class="mdc-text-field__ripple"></span>
                            <span class="mdc-floating-label" id="my-label-id">Tanggal Lahir Ananda</span>
                            <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading" tabindex="0" role="button">cake</i>
                            <input class="mdc-text-field__input" type="text" aria-labelledby="my-label-id">
                            <span class="mdc-line-ripple"></span>
                        </label>
                        <div class="mdc-text-field-helper-line">
                            <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Contoh: 13-01-2010</div>
                        </div>
                        <div class="flex-column" id="first">
                            <button class="button" id="modal-btn-1" style="margin: 2.5vh 0vh 0;">Masuk
                            </button>
                        </div> 
                    </div>
                    
            </div>
            <div class="footer-bar-properti">
                <img src="../assets/img/Yayasan Islam Al Kahfi Batam@2x.png" alt="al-kahfi-batam.png" class="footer_logo">
                <div>
                    <h3 class="mobile-size-font-logo-h3-footer" style="font-size: smaller;">Yayasan Islam Al Kahfi Batam</h3>
                    <p class="mobile-size-font-logo-p-footer" style="font-size: smaller;">Meniti Jejak Generasi Islam Pertama</p>
                </div>
            </div>
        </div>
    </section>

    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));
    $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas, kontak FROM tbl_school") or die($mysqli->error);
    $showModal = false;
    ?>

    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script src="../main_js/script.js"></script>
</body>

</html>