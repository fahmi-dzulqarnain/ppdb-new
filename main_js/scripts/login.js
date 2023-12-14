const namaSekolah = localStorage.getItem('namaSekolah')
const alamat = localStorage.getItem('alamat')
const logoSekolah = localStorage.getItem('logoSekolah')

attachToView('namaSekolah', namaSekolah)
attachToView('alamat', alamat)
setToImage('imgLogo', logoSekolah)

if (namaSekolah.toLowerCase().includes("khadijah")) {
    attachToView("labelUsername", "No HP Ayah / No HP Pribadi")
}

function signIn() {
    const request = new XMLHttpRequest()
    const txtUsername = document.getElementById('txtUsername')
    const txtPassword = document.getElementById('txtPassword')
    const username = txtUsername.value
    const password = txtPassword.value
    const jsonBody = JSON.stringify({
        noHP: username,
        tanggalLahir: password
    })

    request.onload = function () {
        const response = JSON.parse(request.responseText)
        const responseCode = response.statusCode
        const title = response.error
        const messages = response.message

        if (responseCode != 200) {
            attachToView('titleDialog', title)
            attachToView('descriptionDialog', messages)
            openDialog()
        } else {
            const token = response.accessToken
            const tipeAkun = response.tipeAkun
            const sekolah = response.sekolah
            const idSekolah = sekolah.idSekolah
            const namaSekolah = sekolah.namaSekolah
            const alamat = sekolah.alamat
            const logoSekolah = sekolah.logoSekolah

            localStorage.setItem('idSekolah', idSekolah)
            localStorage.setItem('accessToken', token)
            localStorage.setItem('namaSekolah', namaSekolah)
            localStorage.setItem('alamat', alamat)
            localStorage.setItem('logoSekolah', logoSekolah)

            if (tipeAkun == "pendaftar") {
                window.location.replace(`${viewURL}parent`)
            } else {
                window.location.replace(`${viewURL}admin`)
            }
        }
    }

    request.open('POST', `${mainURL}auth/signIn`)
    request.setRequestHeader('Content-Type', 'application/json')
    request.send(jsonBody)
}