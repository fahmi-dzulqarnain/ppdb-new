includeHTML("includes/footer.html", "footer")

const request = new XMLHttpRequest()
const idSekolah = localStorage.getItem("idSekolah")
const query = `?id=${idSekolah}`

request.open("GET", `${mainURL}sekolah/byID${query}`)
request.send()
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
		"Pendaftaran: 220.000" //+ currency.format(jsonSekolah.biayaPendaftaran)
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

	if (namaSekolah.includes('TK') || namaSekolah.includes('SD')) {
	    hideView("syaratAlatTulis")
	}
}

const timelineRequest = new XMLHttpRequest()
const timelineQuery = `?idSekolah=${idSekolah}`

timelineRequest.open("GET", `${mainURL}sekolah/liniMasa${timelineQuery}`)
timelineRequest.send()
timelineRequest.onload = function () {
	if (this.status == 200) {
		const jsonData = JSON.parse(this.responseText.toString())

		setTimelines("assets/components/item-timeline.html", jsonData)
	}
}
