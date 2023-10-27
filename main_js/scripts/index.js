const request = new XMLHttpRequest()
const loadingContainer = document.getElementsByClassName('loading-container')

hideView('errorImage')

request.onload = function () {
	const response = JSON.parse(request.responseText.toString())
	const statusCode = this.status

	if (statusCode == 200) {
		setGridSekolahContent("assets/components/grid-sekolah.html", response)
		loadingContainer[0].style.display = 'none'
	} else {
		couldNotConnectToServer()
	}
}

request.open("GET", `${mainURL}sekolah`)
request.send()

setTimeout(function() {
	couldNotConnectToServer()
}, 7000)

function couldNotConnectToServer() {
	hideView('loadingImage')
	showView('errorImage')
}