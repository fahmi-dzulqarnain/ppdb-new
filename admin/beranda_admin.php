<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="../assets/img/Yayasan Islam Al Kahfi Batam@2x.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>

    <link rel="stylesheet" href="../main_css/root.css">
    <link rel="stylesheet" href="beranda_admin.css">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../main_css/material_design.css">
</head>

<body>

    <nav class="sidebar close display-none">
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='smp_imam_logo icon'></i>
                </li>
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#beranda" class="icon" onclick="munculBeranda()">
                            <i class="fa-solid fa-house side-bar-active" id="berandaClick"></i>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#pendaftar" class="icon" onclick="munculPendaftar()">
                            <i class="fa-solid fa-user-group " id="#pedaftarClick"></i>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#pengaturan" class="icon" onclick="munculPengaturan()">
                            <i class="fa-solid fa-gear" id="pengaturanClick"></i>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="bottom-content ">
                <li class="">
                    <a href="#">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                    </a>
                </li>
            </div>
        </div>
    </nav>
    <section class="beranda display-none" id="beranda">
        <div class="kurung">
            <div class="text" style="margin-left: 30px;">Beranda</div>
            <div>
                <div class="flex-row padding-card-botton">
                    <div class="card">
                        <div class="box">
                            <div class="text-number" style="margin-right: 2rem;">110</div>
                            <div class="text-card">
                                <i class="fa-solid fa-user-group" style="margin-bottom: 10px;"></i><br>Pendaftar
                            </div>
                        </div>
                    </div>
                    <div class="card card-color-lulus">
                        <div class="box">
                            <div class="text-number" style="margin-right: 2rem;flex-wrap: initial;display: inherit;">28<p style="font-size: 20px;">/30</p>
                            </div>
                            <div class="text-card">
                                <i class="fa-solid fa-square-check" style="margin-bottom: 10px;"></i><br>Lulus
                            </div>
                        </div>
                    </div>
                    <div class="card card-color-perlu-aksi">
                        <div class="box">
                            <div class="text-number" style="margin-right: 2rem;">60</div>
                            <div class="text-card">
                                <i class="fa-solid fa-triangle-exclamation" style="margin-bottom: 10px;"></i><br>Perlu Aksi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="beranda display-none disappeared" id="pendaftar">
        <div class="kurung">
            <div class="text" style="margin-left: 30px;">Pendaftar
            </div>
            <!--div class="wrapper">
                <div id="search-container">
                    <input type="search" id="search-input" placeholder="Cari nama pendaftar disini...">
                    <button id="search">Search</button>
                </div>
            </div>
            <div class="buttons">
                <button class="button-value active">Menunggu Pembayaran</button>
                <button class="button-value">Menunggu Konfirmasi</button>
                <button class="button-value">Dibayar</button>
            </div-->

            <div>
                <p style="margin-left: 30px;">Filter Status Pendaftaran</p>
                <div class="flex-row padding-card-botton">
                    <div class="card-text-filter">
                        <div class="text-card-filter">Menunggu Pembayaran</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Menunggu Konfirmasi</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Bukti Bayar Ditolak</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Pendaftaran Batal</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Dibayar</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Lulus Tahap Pertama</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Lulus</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Lulus Bersyarat</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Cadangan</div>
                    </div>
                    <div class="card-text-filter">
                        <div class="text-card-filter">Belum Diterima</div>
                    </div>
                </div>
            </div>

            <div class="card-menunggu-pembayaran">
                <div class="box-menunggu-pembayaran">
                    <div class="no-pendaftaran" style="margin: 2rem;">
                        No. Pendaftaran<p style="font-size: 20px; font-weight: var(--font-bold); margin-top: 5px;">025</p>
                    </div>
                    <div class="nama-pendaftaran" style="margin: 2rem;">
                        Nama Pendaftar<p style="font-size: 14px; font-weight: var(--font-medium); margin-top: 5px;">Tipe Sekolah</p>
                    </div>
                    <div class="tempat-button flex-row">
                        <div class="line-tempat-button"></div>
                        <div class="card-wa"><i class="fa-brands fa-whatsapp"></i></div>
                    </div>
                    <div class="no-pendaftaran" style="margin: 2rem;">
                        Nominal Bayar<p style="font-size: 20px; font-weight: var(--font-bold); margin-top: 5px;">Rp219.025,-</p>
                    </div>
                </div>
            </div>
            <div class="card-menunggu-konfirmasi">
                <div class="box-menunggu-konfirmasi">
                    <div class="flex-row">
                        <div class="no-pendaftaran" style="margin: 2rem;">
                            No. Pendaftaran<p style="font-size: 20px; font-weight: var(--font-bold); margin-top: 5px;">025</p>
                        </div>
                        <div class="nama-pendaftaran" style="margin: 2rem;">
                            Nama Pendaftar<p style="font-size: 14px; font-weight: var(--font-medium); margin-top: 5px;">Tipe Sekolah</p>
                        </div>
                    </div>

                    <div class="tempat-button-konfirmasi flex-row">
                        <div style="display: contents;">
                            <div class="line-tempat-button"></div>
                            <div class="card-bukti-bayar"><i class="fa-solid fa-file-invoice-dollar"></i>
                                <p style="font-size: 16px; display: contents;">Bukti Bayar</p>
                            </div>
                            <div class="card-wa-konfirmasi"><i class="fa-brands fa-whatsapp"></i></div>
                        </div>
                    </div>

                    <div class="flex-row">
                        <div class="no-pendaftaran" style="margin: 3rem 0 0 2rem;">
                            Nominal Bayar<p style="font-size: 20px; font-weight: var(--font-bold); margin-top: 5px;">Rp219.025,-</p>
                        </div>
                        <div class="button-konfirmasi flex-column" style="margin: 2rem;">
                            <button class="button-setujui">Setujui</button>
                            <button class="button-tolak">Tolak</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-menunggu-konfirmasi">
                <div class="box-menunggu-konfirmasi">
                    <div class="flex-row">
                        <div class="no-pendaftaran" style="margin: 2rem;">
                            No. Pendaftaran<p style="font-size: 20px; font-weight: var(--font-bold); margin-top: 5px;">025</p>
                        </div>
                        <div class="nama-pendaftaran" style="margin: 2rem;">
                            Nama Pendaftar<p style="font-size: 14px; font-weight: var(--font-medium); margin-top: 5px;">Tipe Sekolah</p>
                        </div>
                    </div>

                    <div class="tempat-button-dibayar flex-row">
                        <div style="display: contents;">
                            <div class="line-tempat-button-banyak"></div>
                            <div class="card-dibayar card-color-leaf">Lulus Tahap Pertama</div>
                            <div class="card-dibayar card-color-leaf">Lulus</div>
                            <div class="card-dibayar card-color-Dandelion">Lulus Bersyarat</div>
                            <div class="card-dibayar card-color-Dandelion">Cadangan</div>
                            <div class="card-dibayar card-color-rose">Belum Diterima</div>
                            <div class="card-wa-konfirmasi"><i class="fa-brands fa-whatsapp"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="beranda display-none disappeared" id="pengaturan">
        <div class="kurung">
            <div class="text" style="margin-left: 30px;">Pengaturan</div>
            <div>
                <div class="flex-row padding-card-botton">

                </div>
            </div>
        </div>
    </section>

    <section class="fokus-sisi-tengah display-mobile disappeared">
        <div style="text-align: -webkit-center;">
            <div class="akses_lewat_laptop"></div>
            <h1>Mohon Maaf</h1>
            <p>Halaman ini hanya mendukung akses melalui komputer/laptop</p>
        </div>
    </section>

    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script src="../main_js/admin_script.js"></script>
    <script src="../main_js/admin_pendaftar.js"></script>
    <script src="../main_js/script.js"></script>
</body>

</html>