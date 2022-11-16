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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <link rel="stylesheet" href="main_css/root.css">
    <link rel="stylesheet" href="main_css/pengisian_data_daftar.css">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main_css/material_design.css">
</head>

<body>
    <div class="header-bar">
        <div class="header-bar-container">
            <div class="header-bar-properti display-none">
                <img src="assets/img/Yayasan Islam Al Kahfi Batam@2x.png" alt="al-kahfi-batam.png" class="side_logo">
                <div>
                    <h3 class="mobile-size-font-logo-h3">Yayasan Islam Al Kahfi Batam</h3>
                    <p class="mobile-size-font-logo-p">Meniti Jejak Generasi Islam Pertama</p>
                </div>
            </div>
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

    <section class="cover" id="daftar">
        <div class="cover-content">
            <div class="text-2">Pendaftaran</div>
            <div style="margin-top: 5vh;">
                <h3 style="text-align: left; margin-bottom: 1rem;">Data Orang tua</h3>
                    <div id="conten-right" class="flex-column">
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Nama Ayah</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Nama Ibu</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>                        
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin mdc-text-field--textarea"
                               style="height: 9.2rem;">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Alamat</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <span class="mdc-text-field__resizer">
                                <textarea class="mdc-text-field__input" rows="8" cols="40" aria-label="Label"></textarea>
                            </span>
                        </label>
                    </div>
                    <div class="flex-column">
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">No. HP Ayah</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <div class="mdc-text-field-helper-line">
                            <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="false">Memiliki WhatsApp</div>
                        </div>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">No. HP Ibu</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Kelurahan</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Kecamatan</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                    </div>
            </div>
            
            <div style="margin-top: 5vh;">
                <h3 style="text-align: left; margin-bottom: 1rem;">Data Calon Siswa</h3>
                    <div id="conten-right" class="flex-column">
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Nama Lengkap Ananda</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Tempat Lahir</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        
                    </div>
                    <div class="flex-column">
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Rerata Raport</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Tanggal Lahir</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                        <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="my-label-id">Prestasi</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id">
                        </label>
                    </div>
            </div>
            <div class="flex-column" id="first">
                <button class="button" id="modal-btn-1" style="margin: 6vh 0 6vh 0;">Daftar
                </button>
            </div>
        </div>
    </section>

    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'ppdb_db') or die(mysqli_error($mysqli));
    $getSchool = $mysqli->query("SELECT school_name, type, logo_unit, alamat, sisa_kuota, kuota, kapasitas, kontak FROM tbl_school") or die($mysqli->error);
    $showModal = false;
    ?>

    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script src="main_js/script.js"></script>
</body>

</html>