function formatTime(milliseconds) {
  var seconds = (milliseconds / 1000).toFixed(0);
  var minutes = Math.floor(seconds / 60);
  var hours = "";

  seconds = Math.floor(seconds % 60);

  seconds = seconds >= 10 ? seconds : "0" + seconds;

  if (minutes > 59) {
    hours = Math.floor(minutes / 60);
    minutes = minutes - hours * 60;
    minutes = minutes >= 10 ? minutes : "0" + minutes;
  }

  if (hours != "") {
    return `Kadaluarsa dalam <br>${hours} Jam ${minutes} Menit ${seconds} Detik`;
  }

  return `Kadaluarsa dalam <br>${minutes} Menit ${seconds} Detik`;
}

function countDown(time, element) {
  var remainingMilliseconds = time - Date.now();

  if (remainingMilliseconds > 0) {
    element.innerHTML = formatTime(remainingMilliseconds);
  } else {
    element.innerHTML = "Waktu Habis";
  }

  setTimeout(function () {
    countDown(time, element);
  }, 1000);
}
