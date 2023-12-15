const request = new XMLHttpRequest()
const idSekolah = localStorage.getItem("idSekolah")
const query = `?id=${idSekolah}`

request.onload = function () {
	const jsonSekolah = JSON.parse(request.responseText.toString())

	const namaSekolah = jsonSekolah.namaSekolah
	const lowerCasedNamaSekolah = namaSekolah.toLowerCase()
	const alamat = jsonSekolah.alamat
	const logo = jsonSekolah.logo
    
	localStorage.setItem("namaSekolah", namaSekolah)
	localStorage.setItem("alamat", alamat)
	localStorage.setItem("logoSekolah", logo)

	setToImage("imgLogoSekolah", jsonSekolah.logo)
	attachToView("txtNamaSekolah", namaSekolah)
	attachToView("txtAlamatSekolah", alamat)

	if (lowerCasedNamaSekolah.includes("tk")) {
		attachToView("labelPrestasi", "Nama Panggilan")
		attachToView("labelNISN", "NIK")
		attachToView("checkboxNISNLabel", "Atur NIK sebagai username")
		hideView("labelAsalSekolah")
		hideView("fieldRerataRapor")
	} else if (lowerCasedNamaSekolah.includes("sd")) {
		attachToView("labelNISN", "NIK")
		attachToView("checkboxNISNLabel", "Atur NIK sebagai username")
		hideView("fieldRerataRapor")
	} else if (lowerCasedNamaSekolah.includes("khadijah")) {
    	const idTipeSekolah = localStorage.getItem("idTipeSekolah")
    	const tipeSekolah = jsonSekolah.tipeSekolah
    	let namaTipeSekolah = ""
	    
	    for (var i = 0; i < tipeSekolah.length; i++){
            if (tipeSekolah[i].id == idTipeSekolah){
                namaTipeSekolah = tipeSekolah[i].namaTipe
            }
        }
	    
	    if (namaTipeSekolah.includes("Tarbiyah")) {
	        attachToView("labelHPAyah", "No HP Pribadi")
    		attachToView("labelHPIbu", "No HP Orang Tua")
    		attachToView("asalSekolah", "Asal Sekolah / Institusi (Opsional)")
    		hideView("fieldNISN")
    		hideView("chkBoxNISN")
	    }
	}
}

request.open("GET", `${mainURL}sekolah/byID${query}`)
request.send()
