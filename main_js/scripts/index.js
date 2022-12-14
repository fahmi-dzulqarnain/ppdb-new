const request = new XMLHttpRequest()

request.onload = function () {
	const response = JSON.parse(request.responseText.toString())

	setGridSekolahContent("assets/components/grid-sekolah.html", response)
}

request.open("GET", `${mainURL}sekolah`)
request.send()
