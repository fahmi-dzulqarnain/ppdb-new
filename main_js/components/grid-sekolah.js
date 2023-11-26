function setGridSekolahContent(path, jsonData) {
	const request = new XMLHttpRequest()
	const container = document.getElementById("gridSekolah")

	request.onload = function () {
		var statusCode = this.status

		if (statusCode == 200) {
			const rowView = request.responseText

			for (let i = 0; i < jsonData.length; i++) {
				container.innerHTML += rowView
			}

			const buttonSekolah = document.getElementsByName("buttonSekolah")
			const imgLogoSekolah = document.getElementsByName("imgLogoSekolah")
			const txtNamaSekolah = document.getElementsByName("txtNamaSekolah")

			for (let i = 0; i < jsonData.length; i++) {
				const sekolah = jsonData[i]
				const namaSekolah = sekolah.namaSekolah
				const logo = sekolah.logo
				const detail = sekolah.detail
				const isShowOnTheWeb = sekolah.isShowOnTheWeb

				if (isShowOnTheWeb) {
					if (detail.length > 1) {
						const modalTitle = document.getElementById("modal-title")
						const modalContent = document.getElementById("modal-content")
						const requestButton = new XMLHttpRequest()
	
						requestButton.open("GET", "assets/components/location-button.html")
						requestButton.send()
						requestButton.onload = function () {
							if (requestButton.status == 200) {
								const buttonView = requestButton.responseText
		
								buttonSekolah[i].onclick = function () {
									setToImage("modal-img", logo)
									modalTitle.innerHTML = namaSekolah
									modalContent.innerHTML = ""
									
									for (let index = 0; index < detail.length; index++) {
										modalContent.innerHTML += buttonView
									}
		
									const buttonLocation = document.getElementsByName("btn-location")
		
									for (let index = 0; index < detail.length; index++) {
										buttonLocation[index].innerHTML = detail[index].alamat
									}
	
									for (let index = 0; index < detail.length; index++) {
										const selectedDetail = detail[index]
										const idSekolah = selectedDetail.idSekolah
		
										buttonLocation[index].onclick = function () {
											localStorage.setItem("idSekolah", idSekolah)
											location.href = "main.html"
										}
									}
	
									openDialog()
								}
							}
						}
					} else {
						buttonSekolah[i].onclick = function () {
							localStorage.setItem("idSekolah", detail[0].idSekolah)
							location.href = "main.html"
						}
					}
	
					txtNamaSekolah[i].innerHTML = namaSekolah
					imgLogoSekolah[i].src = logo
				} else {
					buttonSekolah[i].style.display = "none"
				}
			}
		}
	}

	request.open("GET", path)
	request.send()
}
