const request = new XMLHttpRequest()
const accessToken = localStorage.getItem('accessToken')
const idSekolah = localStorage.getItem('idSekolah')
const query = `?id=${idSekolah}`

if (accessToken == null) {
    signOut()
}

request.onload = function () {
    const response = JSON.parse(request.responseText)
    const statusCode = this.status

    if (statusCode == 401) {
        signOut()
    } else if (statusCode != 200) {
        const title = response.error
        const messages = response.message

        attachToView('titleDialog', title)
        attachToView('descriptionDialog', messages)
        openDialog()
    } else {
        const checkboxRegistration = document.getElementById('checkboxRegistration')
        const checkboxShown = document.getElementById('checkboxShown')
        const data = response
        console.log(data)

        setInputValue('txtNamaSekolah', data.namaSekolah)
        setInputValue('txtAlamat', data.alamat)
        setInputValue('txtNamaRekening', data.namaRekening)
        setInputValue('txtNoRekening', data.noRekening)
        setInputValue('txtBiayaAwal', numberWithSeparators(data.biayaAwal))
        setInputValue('txtBiayaSPP', numberWithSeparators(data.biayaSPP))
        setInputValue('txtBiayaPendaftaran', numberWithSeparators(data.biayaPendaftaran))
        setInputValue('txtKontak', data.kontak)
        setInputValue('txtLinkGrupWA', data.linkWAGroup)

        if (data.isRegistrationOpen) {
            checkboxRegistration.checked = true
        }

        if (data.isShowOnTheWeb) {
            checkboxShown.checked = true
        }
    }
}

request.open('GET', `${mainURL}sekolah/byID${query}`)
request.send()

function saveSettings() {
    const accessToken = localStorage.getItem('accessToken')
    const request = new XMLHttpRequest()

    const namaRekening = getValueOfInput('txtNamaRekening')
    const noRekening = getValueOfInput('txtNoRekening')
    const biayaAwal = convertToInt(getValueOfInput('txtBiayaAwal').replace(/\./g, ''))
    const biayaSPP = convertToInt(getValueOfInput('txtBiayaSPP').replace(/\./g, ''))
    const biayaPendaftaran = convertToInt(getValueOfInput('txtBiayaPendaftaran').replace(/\./g, ''))
    const kontak = getValueOfInput('txtKontak')
    const linkWAGroup = getValueOfInput('txtLinkGrupWA')
    const checkboxRegistration = document.getElementById('checkboxRegistration')
    const checkboxShown = document.getElementById('checkboxShown')
    const isRegistrationOpen = checkboxRegistration.checked
    const isShowOnTheWeb = checkboxShown.checked

    const jsonBody = JSON.stringify({
        namaRekening,
        noRekening,
        biayaAwal,
        biayaSPP,
        biayaPendaftaran,
        isRegistrationOpen,
        isShowOnTheWeb,
        kontak,
        linkWAGroup
    })

    request.onload = function () {
        const statusCode = this.status

        if (statusCode != 200) {
            if (statusCode == 401) {
                signOut()
            } else {
                const response = JSON.parse(this.responseText)
                const title = response.error
                const messages = response.message

                attachToView('titleDialog', title)
                attachToView('descriptionDialog', messages)
                openDialog()
            }
        }
    }

    request.open('PATCH', `${mainURL}sekolah/byID`)
    request.setRequestHeader('Content-Type', 'application/json')
    request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
    request.send(jsonBody)
}