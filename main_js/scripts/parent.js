const request = new XMLHttpRequest()
const accessToken = localStorage.getItem("accessToken")

if (accessToken == null) {
	signOut()
}

request.onload = function () {
	const response = JSON.parse(request.responseText)
	const status = this.status

	if (status != 200) {
		signOut()
	} else {
		const siswa = response.siswa
		const sekolah = response.sekolah
		const orangTua = siswa.idOrangTua
		const registrasi = siswa.idRegistrasi
		const idRegistrasi = registrasi.id
		const noPendaftaran =
			`${sekolah.idSekolah}`.padStart(4, "0") +
			"-" +
			`${registrasi.noPendaftaran}`.padStart(3, "0")
		const deadlineBayar = registrasi.deadlineBayar
		const statusPendaftaran = registrasi.status
		const isExpired =
			deadlineBayar < new Date().getTime() && statusPendaftaran == "Menunggu Pembayaran"
		const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })
		const countdownDisplay = document.getElementById("countdownDisplay")
		const unggahReceipt = document.getElementById("unggahReceipt")
		const tanggalLahirArray = siswa.tanggalLahir.split("-")
		const bulanLahir = getMonthName(tanggalLahirArray[1])
		const tempatTanggalLahir = `${siswa.tempatLahir}, ${tanggalLahirArray[0]} ${bulanLahir} ${tanggalLahirArray[2]}`

		var alamat = orangTua.alamat
		const kelurahan = orangTua.kelurahan
		const kecamatan = orangTua.kecamatan

		if (kelurahan != "") {
			alamat += `, Kelurahan ${kelurahan}`
		}

		if (kecamatan != "") {
			alamat += `, Kecamatan ${kecamatan}`
		}

		const statusArray = [
			"Menunggu Pembayaran",
			"Menunggu Konfirmasi",
			"Bukti Bayar Ditolak",
			"Pendaftaran Batal",
			"Dibayar",
			"Lulus",
			"Lulus Tes Akademik",
			"Lulus Bersyarat",
			"Cadangan",
			"Belum Diterima",
		]
		const iconArray = [
			"fa-solid fa-file-invoice-dollar",
			"fa-solid fa-clock",
			"fa-solid fa-file-circle-xmark",
			"fa-solid fa-ban",
			"fa-solid fa-check-to-slot",
			"fa-solid fa-building-circle-check",
			"fa-solid fa-school-circle-check",
			"fa-solid fa-envelope-circle-check",
			"fa-solid fa-school-circle-exclamation",
			"fa-solid fa-school-circle-xmark",
		]
		const indexOfStatus = statusArray.indexOf(statusPendaftaran)

		setToImage("imgLogo", sekolah.logo)
		setIcon("iconStatus", iconArray[indexOfStatus])
		attachToView("txtStatusPendaftaran", statusPendaftaran)
		attachToView("txtNominalPembayaran", currency.format(registrasi.nominalTransfer))
		attachToView("txtNamaRekening", sekolah.namaRekening)
		attachToView("txtNoRekening", sekolah.noRekening)
		attachToView("txtNoPendaftaran", noPendaftaran)
		countDown(deadlineBayar, countdownDisplay)
		checkExpiredStatus(isExpired, idRegistrasi)

		setInputValue("txtNamaLengkap", siswa.namaLengkap)
		setInputValue("txtTanggalLahir", tempatTanggalLahir)
		setInputValue("txtAsalSekolah", siswa.asalSekolah)
		setInputValue("txtPrestasi", siswa.prestasi)
		setInputValue("txtRerataRapor", siswa.rerataRapor)
		setInputValue("txtNamaAyah", orangTua.namaAyah)
		setInputValue("txtNamaIbu", orangTua.namaIbu)
		setInputValue("txtNoHPAyah", orangTua.hpAyah)
		setInputValue("txtNoHPIbu", orangTua.hpIbu)
		setInputValue("txtAlamat", alamat)

		unggahReceipt.addEventListener("click", () => uploadImage(idRegistrasi))

		if (
			statusPendaftaran != "Menunggu Pembayaran" &&
			statusPendaftaran != "Bukti Bayar Ditolak" &&
			statusPendaftaran != "Pendaftaran Batal"
		) {
			getUploadedImage(idRegistrasi)
			hideView("containerCountdown")
		}

		if (
			statusPendaftaran != "Menunggu Pembayaran" &&
			statusPendaftaran != "Pendaftaran Batal"
		) {
			showView("btnWAGroup")
			setLink("btnWAGroup", localStorage.getItem("linkWAGroup"))
		}

		var message = ""

		switch (statusPendaftaran) {
			case "Pendaftaran Batal":
				message = `Masa unggah bukti pembayaran telah kadaluarsa, 
                                   silakan mendaftar kembali. Apabila telah melakukan transfer, 
                                   hubungi panitia di ${sekolah.kontak}`
				hideView("payment-section")
				hideView("nominal-section")
				hideView("formReceipt")
				attachToView("txtMessage", message)
				break
			case "Dibayar":
				message =
					"Alhamdulillah! Pembayaran telah diterima, silakan untuk datang pada test yang akan dilaksanakan sesuai jadwal."
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			case "Lulus":
				message = `Alhamdulillah! Ananda telah lulus dan dinyatakan 
                                   diterima sebagai siswa di ${sekolah.namaSekolah}, 
                                   jangan lupa untuk melakukan pendaftaran ulang sesuai jadwal. 
                                   Hubungi Panitia Apabila Ada Pertanyaan di ${sekolah.kontak}.`
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			case "Lulus Bersyarat":
				message = `Alhamdulillah! Ananda dinyatakan lulus bersyarat, 
                                   artinya ada syarat yang harus dilakukan agar dapat 
                                   diterima sepenuhnya di ${sekolah.namaSekolah}.
                                       Hubungi Panitia Apabila Ada Pertanyaan di ${sekolah.kontak}.`
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			case "Lulus Tes Akademik":
				message = `Alhamdulillah! Ananda lulus tes akademik, langkah 
                                   selanjutnya yaitu mengunggah berkas kesehatan, ingatlah 
                                   untuk selalu memantau status pendaftaran sesuai jadwal. 
                                   Hubungi Panitia Apabila Ada Pertanyaan di ${sekolah.kontak}.`
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			case "Cadangan":
				message = `Ananda dinyatakan sebagai cadangan, artinya Ananda memiliki 
                                   nilai cukup dalam tes dan apabila ada yang membatalkan pendaftaran, 
                                   akan dihubungi oleh pihak ${sekolah.namaSekolah}.
                                   Hubungi Panitia Apabila Ada Pertanyaan di ${sekolah.kontak}.`
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			case "Belum Diterima":
				message = `Mohon maaf untuk saat ini Ananda belum diterima di ${sekolah.namaSekolah} 
                                   karena belum lulus test. Terima Kasih telah mendaftar, 
                                   Semoga Allah mengganti dengan yang lebih baik.
                                   Hubungi Panitia Apabila Ada Pertanyaan di ${sekolah.kontak}.`
				hideView("payment-section")
				hideView("nominal-section")
				attachToView("txtMessage", message)
				break
			default:
				break
		}
	}
}

request.open("GET", `${mainURL}siswa`)
request.setRequestHeader("Authorization", "Bearer " + accessToken)
request.send()

function signOut() {
	localStorage.removeItem("accessToken")
	window.location.href = `${viewURL}`
}
