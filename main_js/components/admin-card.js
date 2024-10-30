var selectedCardArray = []

function generateCardMenungguPembayaran(viewID, data) {
	const container = document.getElementById(viewID)

	const request = new XMLHttpRequest()

	request.onload = function () {
		if (this.status == 200) {
			const rowView = request.responseText
			const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })

			const txtNoPendaftaran = document.getElementsByName("txtNoPendaftaran")
			const txtNamaSiswa = document.getElementsByName("txtNamaSiswa")
			const txtTipeSekolah = document.getElementsByName("txtTipeSekolah")
			const txtNominalBayar = document.getElementsByName("txtNominalBayar")
			const btnBukaBuktiBayar = document.getElementsByName("btnBukaBuktiBayar")
			const btnDetail = document.getElementsByName("btnDetailSiswa")
			const btnSendWA = document.getElementsByName("btnSendWA")
			const btnSetujui = document.getElementsByName("btnSetujui")
			const btnTolak = document.getElementsByName("btnTolak")
			var indexRow = 0

			for (let i = 0; i < data.length; i++) {
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswa.idRegistrasi
					const status = registrasi.status

					if (status == "Menunggu Konfirmasi") {
						container.innerHTML += rowView

						indexRow++
					}
				}
			}

			hideOrShowNoDataView(indexRow)

			for (let i = 0; i < data.length; i++) {
				const tipeSekolah = data[i].tipeSekolah
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswa.idRegistrasi
					const orangTua = siswa.idOrangTua
					const status = registrasi.status
					const idRegistrasi = registrasi.id

					if (status == "Menunggu Konfirmasi") {
						const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")

						indexRow--

						txtNoPendaftaran[indexRow].innerHTML = noPendaftaran
						txtNamaSiswa[indexRow].innerHTML = siswa.namaLengkap
						txtTipeSekolah[indexRow].innerHTML = `${tipeSekolah.namaTipe} - ${status}`
						txtNominalBayar[indexRow].innerHTML = currency.format(
							registrasi.nominalTransfer
						)

						btnBukaBuktiBayar[indexRow].addEventListener("click", function () {
							const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")
							const namaLengkap = siswa.namaLengkap

							getUploadedImage(noPendaftaran, namaLengkap, idRegistrasi)
						})
						btnDetail[indexRow].onclick = function () {
							const idSiswa = siswa.id
							localStorage.setItem("idSiswa", idSiswa)

							open("detail.html")
						}
						btnSendWA[indexRow].onclick = function () {
							const noWA = orangTua.hpAyah.replace(/^0/, "62")
							open(`https://wa.me/${noWA}`)
						}
						btnSetujui[indexRow].onclick = function () {
							changeStatus("Dibayar", idRegistrasi)
						}
						btnTolak[indexRow].onclick = function () {
							changeStatus("Bukti Bayar Ditolak", idRegistrasi)
						}
					}
				}
			}
		}
	}

	request.open("GET", "../assets/components/admin-card/confirmation-card.html")
	request.send()
}

function generateInitialCard(viewID, data) {
	const container = document.getElementById(viewID)
	const request = new XMLHttpRequest()

	request.onload = function () {
		if (this.status == 200) {
			const rowView = request.responseText
			const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })
			const deadlineRegistrations = []

			const txtNoPendaftaran = document.getElementsByName("txtNoPendaftaranInitial")
			const txtNamaSiswa = document.getElementsByName("txtNamaSiswaInitial")
			const txtTipeSekolah = document.getElementsByName("txtTipeSekolahInitial")
			const txtNominalBayar = document.getElementsByName("txtNominalBayarInitial")
			const btnDetail = document.getElementsByName("btnDetailSiswaInitial")
			const btnSendWA = document.getElementsByName("btnSendWAInitial")
			var indexRow = 0

			for (let i = 0; i < data.length; i++) {
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const status = registrasi.status

					if (status != "Menunggu Konfirmasi") {
						container.innerHTML += rowView

						indexRow++
					}
				}
			}

			hideOrShowNoDataView(indexRow)

			for (let i = 0; i < data.length; i++) {
				const tipeSekolah = data[i].tipeSekolah
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const orangTua = siswaData[index].idOrangTua
					const status = registrasi.status

					if (status == "Menunggu Pembayaran") {
						deadlineRegistrations.push(registrasi)
					}

					if (status != "Menunggu Konfirmasi") {
						const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")
						indexRow--

						txtNoPendaftaran[indexRow].innerHTML = noPendaftaran
						txtNamaSiswa[indexRow].innerHTML = siswa.namaLengkap
						txtTipeSekolah[indexRow].innerHTML = `${tipeSekolah.namaTipe} - ${status}`
						txtNominalBayar[indexRow].innerHTML = currency.format(
							registrasi.nominalTransfer
						)

						btnDetail[indexRow].onclick = function () {
							const idSiswa = siswa.id
							localStorage.setItem("idSiswa", idSiswa)

							open("detail.html")
						}
						btnSendWA[indexRow].onclick = function () {
							const noWA = orangTua.hpAyah.replace(/^0/, "62")
							open(`https://wa.me/${noWA}`)
						}
					}
				}
			}

			checkExpiredStatusFromAdmin(deadlineRegistrations)
		}
	}

	request.open("GET", "../assets/components/admin-card/common-card.html")
	request.send()
}

function generateCardWithStatus(viewID, data, statusFilter) {
	const container = document.getElementById(viewID)
	const request = new XMLHttpRequest()

	request.onload = function () {
		if (this.status == 200) {
			container.innerHTML = ""

			const rowView = request.responseText
			const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })

			const txtNoPendaftaran = document.getElementsByName("txtNoPendaftaranFiltered")
			const txtNamaSiswa = document.getElementsByName("txtNamaSiswaFiltered")
			const txtTipeSekolah = document.getElementsByName("txtTipeSekolahFiltered")
			const txtNominalBayar = document.getElementsByName("txtNominalBayarFiltered")
			const btnDetail = document.getElementsByName("btnDetailSiswaFiltered")
			const btnSendWA = document.getElementsByName("btnSendWAFiltered")
			var indexRow = 0

			for (let i = 0; i < data.length; i++) {
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const status = registrasi.status

					if (status == statusFilter) {
						container.innerHTML += rowView

						indexRow++
					}
				}
			}

			hideOrShowNoDataView(indexRow)

			for (let i = 0; i < data.length; i++) {
				const tipeSekolah = data[i].tipeSekolah
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const orangTua = siswaData[index].idOrangTua
					const status = registrasi.status

					if (status == statusFilter) {
						const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")
						indexRow--

						txtNoPendaftaran[indexRow].innerHTML = noPendaftaran
						txtNamaSiswa[indexRow].innerHTML = siswa.namaLengkap
						txtTipeSekolah[indexRow].innerHTML = `${tipeSekolah.namaTipe} - ${status}`
						txtNominalBayar[indexRow].innerHTML = currency.format(
							registrasi.nominalTransfer
						)

						btnDetail[indexRow].onclick = function () {
							const idSiswa = siswa.id
							localStorage.setItem("idSiswa", idSiswa)

							open("detail.html")
						}
						btnSendWA[indexRow].onclick = function () {
							const noWA = orangTua.hpAyah.replace(/^0/, "62")
							open(`https://wa.me/${noWA}`)
						}
					}
				}
			}
		}
	}

	request.open("GET", "../assets/components/admin-card/filtered-card.html")
	request.send()
}

function generateSelectableCard(viewID, data, statusFilter) {
	const container = document.getElementById(viewID)
	const request = new XMLHttpRequest()

	request.onload = function () {
		if (this.status == 200) {
			container.innerHTML = ""

			const rowView = request.responseText
			const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })

			const checkBoxes = document.getElementsByName("paid-checkbox")
			const selectableLabel = document.getElementsByName("selectable-label")
			const selectableCard = document.getElementsByName("selectable-card")
			const txtNoPendaftaran = document.getElementsByName("txtNoPendaftaranSelectable")
			const txtNamaSiswa = document.getElementsByName("txtNamaSiswaSelectable")
			const txtTipeSekolah = document.getElementsByName("txtTipeSekolahSelectable")
			const txtNominalBayar = document.getElementsByName("txtNominalBayarSelectable")
			const btnDetail = document.getElementsByName("btnDetailSiswaSelectable")
			const btnSendWA = document.getElementsByName("btnSendWASelectable")
			var indexRow = 0

			for (let i = 0; i < data.length; i++) {
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const status = registrasi.status

					if (status == statusFilter) {
						container.innerHTML += rowView

						indexRow++
					}
				}
			}

			hideOrShowNoDataView(indexRow)

			for (let i = 0; i < data.length; i++) {
				const tipeSekolah = data[i].tipeSekolah
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const orangTua = siswaData[index].idOrangTua
					const status = registrasi.status

					if (status == statusFilter) {
						const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")
						const idRegistrasi = registrasi.id
						const cardID = `card-${idRegistrasi}`
						indexRow--

						txtNoPendaftaran[indexRow].innerHTML = noPendaftaran
						txtNamaSiswa[indexRow].innerHTML = siswa.namaLengkap
						txtTipeSekolah[indexRow].innerHTML = `${tipeSekolah.namaTipe} - ${status}`
						txtNominalBayar[indexRow].innerHTML = currency.format(
							registrasi.nominalTransfer
						)
						checkBoxes[indexRow].value = idRegistrasi
						checkBoxes[indexRow].id = idRegistrasi
						selectableCard[indexRow].id = cardID
						selectableLabel[indexRow].setAttribute("for", idRegistrasi)

						btnDetail[indexRow].onclick = function () {
							const idSiswa = siswa.id
							localStorage.setItem("idSiswa", idSiswa)

							open("detail.html")
						}
						btnSendWA[indexRow].onclick = function () {
							const noWA = orangTua.hpAyah.replace(/^0/, "62")
							open(`https://wa.me/${noWA}`)
						}

						checkBoxes[indexRow].onclick = function () {
							const value = this.value

							if (this.checked) {
								selectedCardArray.push(value)
								document.getElementById(cardID).classList.add("selected")
							} else {
								const index = selectedCardArray.indexOf(value)

								if (index > -1) {
									selectedCardArray.splice(index, 1)
									document.getElementById(cardID).classList.remove("selected")
								}
							}
						}
					}
				}
			}
		}
	}

	request.open("GET", "../assets/components/admin-card/selectable-card.html")
	request.send()
}

function generateCancelledCard(viewID, data, statusFilter) {
	const container = document.getElementById(viewID)
	const request = new XMLHttpRequest()

	request.onload = function () {
		if (this.status == 200) {
			container.innerHTML = ""

			const rowView = request.responseText
			const currency = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" })

			const txtNoPendaftaran = document.getElementsByName("txtNoPendaftaranCancelled")
			const txtNamaSiswa = document.getElementsByName("txtNamaSiswaCancelled")
			const txtTipeSekolah = document.getElementsByName("txtTipeSekolahCancelled")
			const txtNominalBayar = document.getElementsByName("txtNominalBayarCancelled")
			const btnDetail = document.getElementsByName("btnDetailSiswaCancelled")
			const btnSendWA = document.getElementsByName("btnSendWACancelled")
			const btnExtend = document.getElementsByName("btnExtend")
			const btnHapus = document.getElementsByName("btnDelete")
			var indexRow = 0

			for (let i = 0; i < data.length; i++) {
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const status = registrasi.status

					if (status == statusFilter) {
						container.innerHTML += rowView

						indexRow++
					}
				}
			}

			hideOrShowNoDataView(indexRow)

			for (let i = 0; i < data.length; i++) {
				const tipeSekolah = data[i].tipeSekolah
				const siswaData = data[i].siswa

				for (let index = 0; index < siswaData.length; index++) {
					const siswa = siswaData[index]
					const registrasi = siswaData[index].idRegistrasi
					const orangTua = siswaData[index].idOrangTua
					const status = registrasi.status
					const idRegistrasi = registrasi.id

					if (status == statusFilter) {
						const noPendaftaran = `${registrasi.noPendaftaran}`.padStart(4, "0")
						indexRow--

						txtNoPendaftaran[indexRow].innerHTML = noPendaftaran
						txtNamaSiswa[indexRow].innerHTML = siswa.namaLengkap
						txtTipeSekolah[indexRow].innerHTML = `${tipeSekolah.namaTipe} - ${status}`
						txtNominalBayar[indexRow].innerHTML = currency.format(
							registrasi.nominalTransfer
						)

						btnDetail[indexRow].onclick = function () {
							const idSiswa = siswa.id
							localStorage.setItem("idSiswa", idSiswa)

							open("detail.html")
						}
						btnSendWA[indexRow].onclick = function () {
							const noWA = orangTua.hpAyah.replace(/^0/, "62")
							open(`https://wa.me/${noWA}`)
						}
						btnExtend[indexRow].onclick = function () {
							extendDeadline(idRegistrasi)
						}
						btnHapus[indexRow].onclick = function () {
							deleteAccount(idRegistrasi)
						}
					}
				}
			}
		}
	}

	request.open("GET", "../assets/components/admin-card/cancelled-card.html")
	request.send()
}

function getUploadedImage(noPendaftaran, namaLengkap, idRegistrasi) {
	const request = new XMLHttpRequest()
	const accessToken = localStorage.getItem("accessToken")
	const query = `?id=${idRegistrasi}`

	request.onload = function () {
		try {
			const response = JSON.parse(request.responseText)
			const statusCode = response.statusCode

			if (statusCode == 401) {
				signOut()
			} else {
				const title = response.error
				const messages = response.message

				showView("titleDialog")
				showView("lottieImage")
				hideView("imgReceipt")

				attachToView("titleDialog", title)
				attachToView("descriptionDialog", messages)
				openDialog()
			}
		} catch (error) {
			hideView("titleDialog")
			hideView("lottieImage")
			showView("imgReceipt")

			const urlCreator = window.URL || window.webkitURL
			const imageUrl = urlCreator.createObjectURL(this.response)

			setToImage("imgReceipt", imageUrl)
			attachToView("descriptionDialog", `${noPendaftaran} - ${namaLengkap}`)

			openDialog()
		}
	}

	request.open("GET", `${mainURL}registrasi/receipt${query}`)
	request.responseType = "blob"
	request.setRequestHeader("Authorization", `Bearer ${accessToken}`)
	request.send()
}

function changeStatus(status, idRegistrasi) {
	var request = new XMLHttpRequest()
	var accessToken = localStorage.getItem("accessToken")
	var jsonBody = JSON.stringify({
		ids: [idRegistrasi],
		statusRegistrasi: status,
	})

	request.onload = function () {
		location.reload()
	}

	request.open("PATCH", `${mainURL}registrasi/statusRegistrasi`)
	request.setRequestHeader("Authorization", "Bearer " + accessToken)
	request.setRequestHeader("Content-Type", "application/json")
	request.send(jsonBody)
}

function deleteAccount(idRegistrasi) {
	var request = new XMLHttpRequest()
	var accessToken = localStorage.getItem("accessToken")
	var jsonBody = JSON.stringify({
		registrationID: idRegistrasi,
	})

	request.onload = function () {
		location.reload()
	}

	request.open("DELETE", `${mainURL}auth/sudo`)
	request.setRequestHeader("Authorization", "Bearer " + accessToken)
	request.setRequestHeader("Content-Type", "application/json")
	request.send(jsonBody)
}

function extendDeadline(idRegistrasi) {
	var request = new XMLHttpRequest()
	var accessToken = localStorage.getItem("accessToken")
	var jsonBody = JSON.stringify({
		registrationID: idRegistrasi,
	})

	request.onload = function () {
		location.reload()
	}

	request.open("PATCH", `${mainURL}registrasi/extend`)
	request.setRequestHeader("Authorization", "Bearer " + accessToken)
	request.setRequestHeader("Content-Type", "application/json")
	request.send(jsonBody)
}

function changeBulkStatus(status, idRegistrasiArray) {
	var request = new XMLHttpRequest()
	var accessToken = localStorage.getItem("accessToken")
	var jsonBody = JSON.stringify({
		ids: idRegistrasiArray,
		statusRegistrasi: status,
	})

	request.onload = function () {
		location.reload()
	}

	request.open("PATCH", `${mainURL}registrasi/statusRegistrasi`)
	request.setRequestHeader("Authorization", "Bearer " + accessToken)
	request.setRequestHeader("Content-Type", "application/json")
	request.send(jsonBody)
}

function hideOrShowNoDataView(count) {
	if (count == 0) {
		noDataContainer.style.display = "flex"
	} else {
		noDataContainer.style.display = "none"
	}
}
