function daftar() {
	const request = new XMLHttpRequest()
	const idTipeSekolah = localStorage.getItem("idTipeSekolah")
	const chkBoxNISN = document.getElementById("checkboxNISN")
	const nisn = getValueOfInput("txtNISN")
	const rerataRaporString = getValueOfInput("txtRerataRapor")
	const isUseNISN = chkBoxNISN.checked && nisn !== ""
	const hpAyah = getValueOfInput("txtNoHPAyah")
	var rerataRapor = 0
	var username = hpAyah

	if (isUseNISN && nisn !== null && nisn != "") {
		username = nisn
	}

	if (!isNaN(rerataRaporString) && rerataRaporString != "") {
		rerataRapor = parseInt(rerataRaporString)
	}

	const jsonBody = JSON.stringify({
		username: username,
		sandi: getValueOfInput("txtTanggalLahir"),
		tipeAkun: "pendaftar",
		idTipeSekolah,
		namaAyah: getValueOfInput("txtNamaAyah"),
		hpAyah,
		namaIbu: getValueOfInput("txtNamaIbu"),
		hpIbu: getValueOfInput("txtNoHPIbu"),
		alamat: getValueOfInput("txtAlamat"),
		kelurahan: getValueOfInput("txtKelurahan"),
		kecamatan: getValueOfInput("txtKecamatan"),
		namaLengkap: getValueOfInput("txtNamaLengkap"),
		tempatLahir: getValueOfInput("txtTempatLahir"),
		tanggalLahir: getValueOfInput("txtTanggalLahir"),
		asalSekolah: getValueOfInput("txtAsalSekolah"),
		rerataRapor,
		prestasi: getValueOfInput("txtPrestasi"),
		nisn,
	})

	request.onload = function () {
		const response = JSON.parse(request.responseText)
		const statusCode = response.statusCode

		if (statusCode != 200) {
			var title = response.error
			const messages = response.message
			var message = ""

			if (title == "Bad Request") {
				title = "Mohon Tinjau!"

				for (let i = 0; i < messages.length; i++) {
					message += `${messages[i]}. `
				}
			} else {
				message = messages
			}

			attachToView("titleDialog", title)
			attachToView("descriptionDialog", message)
			openDialog()
		} else {
			window.location.replace(`${viewURL}login`)
		}
	}

	request.open("POST", `${mainURL}auth/register`)
	request.setRequestHeader("Content-Type", "application/json")
	request.send(jsonBody)
}
