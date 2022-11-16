function daftar() {
    const request = new XMLHttpRequest()
    const idTipeSekolah = localStorage.getItem('idTipeSekolah')
    const chkBoxNISN = document.getElementById('checkboxNISN')
    const nisn = getValueOfInput('txtNISN')
    const isUseNISN = chkBoxNISN.checked && nisn != ""
    const hpAyah = getValueOfInput('txtNoHPAyah')
    var username = hpAyah

    if(isUseNISN && nisn != null) {
        username = nisn
    }

    const jsonBody = JSON.stringify({
        username: username,
        sandi: getValueOfInput('txtTanggalLahir'),
        tipeAkun: 'pendaftar',
        idTipeSekolah,
        namaAyah: getValueOfInput('txtNamaAyah'),
        hpAyah,
        namaIbu: getValueOfInput('txtNamaIbu'),
        hpIbu: getValueOfInput('txtNoHPIbu'),
        alamat: getValueOfInput('txtAlamat'),
        kelurahan: getValueOfInput('txtKelurahan'),
        kecamatan: getValueOfInput('txtKecamatan'),
        namaLengkap: getValueOfInput('txtNamaLengkap'),
        tempatLahir: getValueOfInput('txtTempatLahir'),
        tanggalLahir: getValueOfInput('txtTanggalLahir'),
        asalSekolah: getValueOfInput('txtAsalSekolah'),
        rerataRapor: getValueOfInput('txtRerataRapor'),
        prestasi: getValueOfInput('txtPrestasi'),
        nisn
    })

    console.log(JSON.parse(jsonBody))

    request.onload = function() {
        const response = JSON.parse(request.responseText)
        const statusCode = response.statusCode
        
        if (statusCode != 200) {
            var title = response.error
            const messages = response.message
            var message = ""
            
            for (let i = 0; i < messages.length; i++) {
                message += `${translate(messages[i])}. `
            }

            if(title == "Bad Request") {
                title = "Mohon Tinjau!"
            }

            attachToView('titleDialog', title)
            attachToView('descriptionDialog', message)
            openDialog()
        } else {
            window.location.replace(`${viewURL}login`);
        }
    }

    request.open('POST', `${mainURL}auth/register`)
    request.setRequestHeader('Content-Type', 'application/json')
    request.send(jsonBody)
}

function getValueOfInput(id) {
    const viewElement = document.getElementById(id)
    return viewElement.value
}

function translate(string) {
    switch (string) {
        case "username should not be empty":
            return "No HP ayah / NISN perlu diisi untuk username"
        case "sandi should not be empty":
            return "Tanggal lahir Ananda perlu diisi"
        case "namaAyah should not be empty":
            return "Nama ayah perlu diisi"
        case "hpAyah must be a phone number":
            return "No HP ayah harus nomor telefon"
        case "hpIbu must be a phone number":
            return "No HP ibu harus nomor telefon"
        case "namaIbu should not be empty":
            return "Nama ibu perlu diisi"
        case "alamat should not be empty":
            return "Alamat perlu diisi"
        case "kelurahan should not be empty":
            return "Kelurahan perlu diisi"
        case "kecamatan should not be empty":
            return "Kecamatan perlu diisi"
        case "namaLengkap should not be empty":
            return "Nama lengkap Ananda perlu diisi"
        case "tempatLahir should not be empty":
            return "Tempat lahir perlu diisi"
        case "tanggalLahir must be formatted as dd-MM-yyyy":
            return "Tanggal lahir harus sesuai format tt-BB-TTTT"
        case "rerataRapor must be a number string":
            return "Rerata rapor harus dalam bentuk angka, masukkan 0 jika tidak ada"
        case "namaAyah must be shorter than or equal to 48 characters":
            return "Nama ayah maksimal 48 karakter"
        case "namaIbu must be shorter than or equal to 48 characters":
            return "Nama ibu maksimal 48 karakter"
        case "namaLengkap must be shorter than or equal to 48 characters":
            return "Nama lengkap Ananda maksimal 48 karakter"
        case "alamat must be shorter than or equal to 64 characters":
            return "Alamat maksimal 64 karakter"
        default:
            return string
    }
}