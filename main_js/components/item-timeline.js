function setTimelines(path, jsonData) {
	const request = new XMLHttpRequest()
	const container = document.getElementById("timeline-container")

	request.onload = function () {
		if (this.status == 200) {
			const itemView = request.responseText

			for (let i = 0; i < jsonData.length; i++) {
				container.innerHTML += itemView
			}

			const itemTimeline = document.getElementsByName("item-timeline")
			const titleTimeline = document.getElementsByName("title-timeline")
			const dateTimeline = document.getElementsByName("date-timeline")

			for (let i = 0; i < jsonData.length; i++) {
				const timeline = jsonData[i]
				const startDate = timeline.startDate
				const endDate = timeline.endDate
				const start = startDate == endDate ? "" : getReadableDate(startDate)
				const end = getReadableDate(endDate)
				const date = start == "" ? end : `${start} - ${end}`

				titleTimeline[i].innerHTML = timeline.kegiatan
				dateTimeline[i].innerHTML = date

				if ((i + 1) % 2 == 0) {
					itemTimeline[i].classList.add("right")
				} else {
					itemTimeline[i].classList.add("left")
				}
			}
		}
	}

	request.open("GET", path)
	request.send()
}

function getReadableDate(dateString) {
	const dateArray = dateString.split("-")
	const month = getMonthName(dateArray[1]).substring(0, 3)

	return `${dateArray[0]} ${month} ${dateArray[2]}`
}
