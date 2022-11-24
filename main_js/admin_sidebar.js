window.onload = function () {  
    const request = new XMLHttpRequest()
    const view = document.getElementById("sidebar")

    request.onload = function () {
      if (this.status == 200) {
        view.innerHTML = request.responseText

        const logo = document.getElementById('imgLogo')
        logo.src = localStorage.logoSekolah
      }
    };

    request.open("GET", 'sidebar.html');
    request.send();
};

function signOut() {
    localStorage.removeItem('accessToken')
    window.location.href = `${viewURL}`
}