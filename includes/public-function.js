const mainURL = "https://backend-ppdb.com:3000/"
const viewURL = "https://ppdb.alkahfi.or.id/"

// const mainURL = "http://localhost:3000/"
// const viewURL = "http://localhost/ppdb-versi-3/"

function includeHTML(path, elementID) {
	const request = new XMLHttpRequest()
	const view = document.getElementById(elementID)

	request.onload = function () {
		if (this.status == 200) {
			view.innerHTML = request.responseText
		}
	}

	request.open("GET", path)
	request.send()
}

function attachToView(viewID, content) {
	const view = document.getElementById(viewID)
	view.innerHTML = content
}

function addToView(viewID, content) {
	const view = document.getElementById(viewID)
	view.innerHTML += content
}

function showView(viewID) {
	const view = document.getElementById(viewID)
	view.style.display = "block"
}

function hideView(viewID) {
	const view = document.getElementById(viewID)
	view.style.display = "none"
}

function setInputValue(viewID, content) {
	const view = document.getElementById(viewID)
	view.value = content
}

function getValueOfInput(id) {
	const viewElement = document.getElementById(id)
	return viewElement.value
}

function setToImage(viewID, content) {
	const view = document.getElementById(viewID)
	view.src = content
}

function setLink(viewID, content) {
	const view = document.getElementById(viewID)
	view.href = content
}

function setIcon(viewID, iconClass) {
	const view = document.getElementById(viewID)
	view.className = iconClass
}

function getMonthName(monthNumberString) {
	const monthNumber = parseInt(monthNumberString) - 1
	const arrayOfMonth = [
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
	]

	return arrayOfMonth[monthNumber]
}

function numberWithSeparators(number) {
	return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

function onInputNumberSeparator(input) {
	let nums = input.value.replace(/\./g, "")

	if (!nums || nums.endsWith(".")) return

	input.value = parseFloat(nums).toLocaleString("id-ID")
}

function convertToInt(number) {
	if (isNaN(number)) {
		return 0
	}

	return parseInt(number)
}
