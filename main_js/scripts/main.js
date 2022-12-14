includeHTML("includes/footer.html", "footer")

const request = new XMLHttpRequest()
const idSekolah = localStorage.getItem("idSekolah")
const query = `?id=${idSekolah}`

request.onload = function () {
	const jsonSekolah = JSON.parse(request.responseText.toString())
	const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })
	const containerTipeSekolah = document.getElementById("containerTipeSekolah")
	const btnDaftar = document.getElementById("btnDaftar")
	const btnLogin = document.getElementById("btnLogin")
	const txtMessageDaftar = document.getElementById("txtMessageDaftar")

	const namaSekolah = jsonSekolah.namaSekolah
	const alamat = jsonSekolah.alamat
	const logo = jsonSekolah.logo
	const kontak = jsonSekolah.kontak
	const isRegistrationOpen = jsonSekolah.isRegistrationOpen

	setToImage("logo", logo)
	setToImage("dialogLogo", logo)
	attachToView("titleDialog", namaSekolah)
	attachToView("namaSekolah", namaSekolah)
	attachToView("alamat", alamat)
	attachToView(
		"biayaPendaftaran",
		"Pendaftaran: " + currency.format(jsonSekolah.biayaPendaftaran)
	)
	attachToView("biayaAwal", "Awal Masuk: " + currency.format(jsonSekolah.biayaAwal))
	attachToView("biayaSPP", "SPP Bulanan: " + currency.format(jsonSekolah.biayaSPP))
	setTimeout(() => {
		addToView("kontakSekolah", kontak)
	}, 1000)

	setRowContent("assets/components/row-tipe-sekolah.html", jsonSekolah.tipeSekolah)

	localStorage.setItem("namaSekolah", namaSekolah)
	localStorage.setItem("alamat", alamat)
	localStorage.setItem("logoSekolah", logo)
	localStorage.setItem("linkWAGroup", jsonSekolah.linkWAGroup)

	if (isRegistrationOpen) {
		btnDaftar.style.display = "flex"
	}

	btnLogin.href = `${viewURL}login`
}

request.open("GET", `${mainURL}sekolah/byID${query}`)
request.send()
