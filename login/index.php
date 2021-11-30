<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="login.css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>PPDB</title>
</head>

<body class="center-content">
    <div>
        <?php $jenjang = ''; ?>
        <div class="form-container">
            <div class="form-wrapper">
                <img style="width: 25%;" src="../logo/Yayasan Islam Al Kahfi Batam.png" alt="">
                <h3 style="margin: 1.2rem 0 .1rem 0;">PPDB</h3>
                <p style="margin-bottom: 2rem;">Yayasan Islam Al-Kahfi Batam</p>
                <form action="login.php" method="post">
                    <input style="width: 100%;" class="text-form-login" type="text" name="username" placeholder="Nama Ananda..."> <br>
                    <input style="width: 100%" class="text-form-login" type="password" name="password" id="myInput" placeholder="Kata Sandi...">
                    <div style="display: inline; margin-top: 10px;">
                        <input type="checkbox" onclick="myFunction()"> Tampilkan Sandi
                    </div>
                    <button style="padding-bottom: 10px; margin-bottom:20px;" class="login-button" type="submit" name="login">Masuk</button>
                    <div class="box-info">
                        <p style="font-size: .8em;"><i class='bx bx-info-circle' ></i> Kata Sandi adalah Tgl lahir Ananda. Contoh. 29 Nov 2020 ditulis 29112020</p>
                    </div>
                    <p style="max-width: 400px; margin-top: 20px; font-weight: 500;">
                        Belum mengisi formulir? <a href="../index.php#daftar" style="font-weight: 700; text-decoration: none; color: var(--dark-green)">Daftar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>