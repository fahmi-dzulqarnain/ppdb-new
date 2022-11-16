function setRowContent(path, jsonData) {
  const request = new XMLHttpRequest();
  const container = document.getElementById("containerTipeSekolah");

  request.onload = function () {
    if (this.status == 200) {
      const rowView = request.responseText;

      for (let i = 0; i < jsonData.length; i++) {
        container.innerHTML += request.responseText;
      }

      const buttonTipeSekolah = document.getElementsByName("buttonTipeSekolah");
      const kuotaTipeSekolah = document.getElementsByName("kuotaTipeSekolah");
      const sisaKuota = document.getElementsByName("sisaKuotaTipeSekolah");

      for (let i = 0; i < jsonData.length; i++) {
        const tipeSekolah = jsonData[i];

        buttonTipeSekolah[i].innerHTML = tipeSekolah.namaTipe;
        kuotaTipeSekolah[i].innerHTML = `/ ${tipeSekolah.kuota}`;
        sisaKuota[i].innerHTML = tipeSekolah.sisaKuota;

        buttonTipeSekolah[i].onclick = function() {
          localStorage.setItem('idTipeSekolah', tipeSekolah.id)
          location.href = 'register/'
        } 
      }
    }
  };

  request.open("GET", path);
  request.send();
}
