<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="../assets/img/Yayasan Islam Al Kahfi Batam@2x.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

    <link rel="stylesheet" href="../main_css/root.css">
    <link rel="stylesheet" href="status_pendaftaran.css">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="../main_css/material_design.css">
</head>
<body>
    
    <nav class="sidebar close display-none-laptop">
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='smp_imam_logo icon'></i>
                </li>            
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                    </a>
                </li>
            </div>
        </div>
    </nav>
    <section class="home">
        <div class="kurung">
            <div class="text" style="margin-left: 30px;">Status Pembayaran</div>
            <div>
                <div id="conten-right" class="flex-column padding-card-botton">
                    <div class="card">
                        <div class="box">
                            <div class="text"><i class='bx bxs-file'>
                            </i><br>Menunggu Pembayaran</div>
                            <br>
                            <ul>
                                <li><i class="fa-solid fa-hourglass-half"></i> dalam 23 Jam 59 Menit</li>
                                <li>Nominal Transfer Rp219.059,-</li>
                                <li>Bank BSI a.n. SMPS Imam Syafii</li>
                                <li>1002 3089 287</li>
                                <li style="margin-top: 1rem;">No. Pendaftaran</li>
                                <li style="font-weight: var(--font-bold);">012-059</li>
                            </ul><br>
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <div class="text">
                                <img src="" alt="">
                                <i class='bx bxs-file'> 
                                </i><br>Pilih Bukti Pembayaran
                            </div>
                        </div>
                    </div>
                    <div class="flex-column" id="first">
                        <button class="button" id="modal-btn-1" style="margin: 2.5vh 0vh 0;">Unggah
                        </button>
                    </div> 
                </div>
                <div  class="flex-column margin-mobile">


                    <div style="margin-top: 2.5vh;">
                        <h3 style="text-align: left; margin-bottom: 1rem;">Data Calon Siswa</h3>
                        <div id="conten-right" class="flex-column">
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Nama Lengkap Ananda</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input text-disabled" value="Fahmi Dzulqarnain" aria-labelledby="my-label-id" disabled>
                            </label>
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Tempat & Tanggal Lahir</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="Bandung, 13 Januari 2002" aria-labelledby="my-label-id" disabled>
                            </label>  
                        </div>
                        <div class="flex-column">
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Asal Sekolah</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="SDIT Fajar Ilahi Batu Aji" aria-labelledby="my-label-id" disabled>
                            </label>
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Prestasi</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="Juara 1 kelas 5 kali" aria-labelledby="my-label-id" disabled>
                            </label>
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Rerata Raport</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="98,99" aria-labelledby="my-label-id" disabled>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h3 class="margin-h3-orangtua" style="text-align: left;">Data Orang tua</h3>
                        <div id="conten-right" class="flex-column">
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Nama Ayah</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="Deden Abdul Aziz" aria-labelledby="my-label-id" disabled>
                            </label>
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">Nama Ibu</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="Santi Sukmawati Yusup" aria-labelledby="my-label-id" disabled>
                            </label>                        
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin mdc-text-field--textarea" style="height: 9.2rem;">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="my-label-id">Alamat</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <span class="mdc-text-field__resizer">
                                    <textarea class="mdc-text-field__input" rows="8" cols="40" aria-label="Label" disabled>INi adalah Alamat</textarea>
                                </span>
                            </label>
                        </div>
                        <div class="flex-column">
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">No. HP Ayahanda</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="+62-813-7286-6233" aria-labelledby="my-label-id" disabled>
                            </label>
                            <label class="mdc-text-field mdc-text-field--outlined text-field-margin">
                                <span class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="my-label-id">No. HP Ibunda</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                                <input type="text" class="mdc-text-field__input" value="+62-812-7050-1535" aria-labelledby="my-label-id" disabled>
                            </label>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!--section class="fokus-sisi-tengah">
        <div class="display-none-laptop" style="text-align: center; display: inline-block;">
            <img class="akses_lewat_laptop">
            <h1>Mohon Maaf</h1>
            <p>Halaman ini hanya mendukung akses melalui komputer/laptop</p>
        </div>
    </section-->    

    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script src="../main_js/script.js"></script>
</body>
</html>