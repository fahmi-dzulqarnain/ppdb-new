function setGridSekolahContent(path, jsonData) {
    const request = new XMLHttpRequest();
    const container = document.getElementById("gridSekolah");
  
    request.onload = function () {
      if (this.status == 200) {
        const rowView = request.responseText;
  
        for (let i = 0; i < jsonData.length; i++) {
          container.innerHTML += rowView
        }
  
        const buttonSekolah = document.getElementsByName("buttonSekolah");
        const imgLogoSekolah = document.getElementsByName("imgLogoSekolah");
        const txtNamaSekolah = document.getElementsByName("txtNamaSekolah");
  
        for (let i = 0; i < jsonData.length; i++) {
            const sekolah = jsonData[i];
            const namaSekolah = sekolah.namaSekolah
  
            buttonSekolah[i].onclick = function() {
                localStorage.setItem('idSekolah', sekolah.idSekolah)
                location.href = 'main.html'
            }

            txtNamaSekolah[i].innerHTML = namaSekolah
            imgLogoSekolah[i].src = sekolah.logo
        }
      }
    };
  
    request.open("GET", path);
    request.send();
  }
  