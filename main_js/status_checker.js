function checkExpiredStatus(deadline, idRegistrasi) {
  if (deadline) {
    var request = new XMLHttpRequest();
    var accessToken = localStorage.getItem("accessToken");
    var jsonBody = JSON.stringify({
      id: idRegistrasi,
      statusRegistrasi: "Pendaftaran Batal"
    });

    request.onload = function () {
      location.reload()
    };

    request.open("PATCH", `${mainURL}registrasi/siswa/status`);
    request.setRequestHeader("Authorization", "Bearer " + accessToken);
    request.setRequestHeader("Content-Type", "application/json");
    request.send(jsonBody);
  }
}

function changeStatus(status, idRegistrasi) {
    var request = new XMLHttpRequest();
    var accessToken = localStorage.getItem("accessToken");
    var jsonBody = JSON.stringify({
      id: idRegistrasi,
      statusRegistrasi: status
    });

    request.onload = function () {
      location.reload()
    };

    request.open("PATCH", `${mainURL}registrasi/siswa/status`);
    request.setRequestHeader("Authorization", "Bearer " + accessToken);
    request.setRequestHeader("Content-Type", "application/json");
    request.send(jsonBody);
}